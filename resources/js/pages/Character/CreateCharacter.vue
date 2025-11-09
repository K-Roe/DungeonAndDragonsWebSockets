<script setup>
import { ref, reactive, computed, nextTick } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()

/** ---------- Config ---------- **/
const POINT_POOL = 60         // total points you can allocate
const STAT_MIN   = 8          // starting floor for each stat
const STAT_MAX   = 18         // hard cap per stat
const MAX_SKILLS = 3

const CLASSES = [
    { key: 'warrior', label: 'Warrior' },
    { key: 'rogue',   label: 'Rogue' },
    { key: 'mage',    label: 'Mage'  },
    { key: 'cleric',  label: 'Cleric'},
]

const RACES = [
    { key: 'human', label: 'Human' },
    { key: 'elf',   label: 'Elf (+1 DEX)' },
    { key: 'dwarf', label: 'Dwarf (+1 CON)' },
    { key: 'orc',   label: 'Orc (+1 STR)' },
]

// per-class skill list
const CLASS_SKILLS = {
    warrior: [
        { key: 'power_strike', label: 'Power Strike' },
        { key: 'shield_wall',  label: 'Shield Wall' },
        { key: 'battle_shout', label: 'Battle Shout' },
        { key: 'second_wind',  label: 'Second Wind' },
    ],
    rogue: [
        { key: 'backstab',   label: 'Backstab' },
        { key: 'stealth',    label: 'Stealth' },
        { key: 'lockpicking',label: 'Lockpicking' },
        { key: 'evasion',    label: 'Evasion' },
    ],
    mage: [
        { key: 'fireball',     label: 'Fireball' },
        { key: 'arcane_shield',label: 'Arcane Shield' },
        { key: 'frost_nova',   label: 'Frost Nova' },
        { key: 'teleport',     label: 'Teleport' },
    ],
    cleric: [
        { key: 'heal',        label: 'Heal' },
        { key: 'smite',       label: 'Smite' },
        { key: 'bless',       label: 'Bless' },
        { key: 'turn_undead', label: 'Turn Undead' },
    ],
}

/** ---------- Form state ---------- **/
const name = ref('')
const race = ref('human')
const charClass = ref('warrior')
const background = ref('')

const stats = reactive({
    strength: STAT_MIN,
    dexterity: STAT_MIN,
    constitution: STAT_MIN,
    intelligence: STAT_MIN,
    wisdom: STAT_MIN,
    charisma: STAT_MIN,
})

const selectedSkills = ref([])   // array of keys

// dice anim state
const rolling = ref(false)
const diceCloud = ref([]) // [{ id, x%, delayS, value, flying }]

const error = ref(null)
const success = ref(false)

/** ---------- Derived ---------- **/
const baseSum = computed(() => Object.values(stats).length * STAT_MIN)
const spentPoints = computed(() => {
    const total = Object.values(stats).reduce((a, b) => a + b, 0)
    return total - baseSum.value
})
const remainingPoints = computed(() => POINT_POOL - spentPoints.value)

const availableSkills = computed(() => CLASS_SKILLS[charClass.value] ?? [])
const canSave = computed(() =>
    name.value.trim() &&
    race.value &&
    charClass.value &&
    remainingPoints.value >= 0 &&
    selectedSkills.value.length <= MAX_SKILLS
)

/** ---------- Helpers ---------- **/
function clamp(v, min, max) { return Math.max(min, Math.min(max, v)) }

function incStat(key) {
    if (remainingPoints.value <= 0) return
    stats[key] = clamp(stats[key] + 1, STAT_MIN, STAT_MAX)
}
function decStat(key) {
    // never go below min; refund a point
    if (stats[key] <= STAT_MIN) return
    stats[key] = clamp(stats[key] - 1, STAT_MIN, STAT_MAX)
}

function toggleSkill(key) {
    // only allow skills from current class
    if (!availableSkills.value.find(s => s.key === key)) return

    const idx = selectedSkills.value.indexOf(key)
    if (idx >= 0) {
        selectedSkills.value.splice(idx, 1)
    } else {
        if (selectedSkills.value.length >= MAX_SKILLS) return
        selectedSkills.value.push(key)
    }
}

// tiny race bonuses (visual only, baked when saving)
function raceBonusFor(key) {
    if (race.value === 'elf'   && key === 'dexterity')   return 1
    if (race.value === 'dwarf' && key === 'constitution')return 1
    if (race.value === 'orc'   && key === 'strength')    return 1
    return 0
}

/** ---------- Dice ---------- **/
function rollD12() { return Math.floor(Math.random() * 12) + 1 }

async function rollWithDice() {
    if (rolling.value) return
    rolling.value = true
    error.value = null

    // create one die per stat, random lanes + stagger
    const keys = Object.keys(stats)
    diceCloud.value = keys.map((k, i) => ({
        id: k,
        x: Math.random() * 80 + 10,      // 10%..90%
        delay: Math.random() * 0.25,     // 0..0.25s start offset
        value: '?',
        flying: true,
    }))

    await nextTick()

    // animate rolling across
    for (const die of diceCloud.value) {
        die.flying = true
    }

    // spin time
    await new Promise(r => setTimeout(r, 1800))

    // generate numbers while respecting pool
    // naive approach: roll first, then clamp + adjust if we exceed pool
    const rolled = keys.reduce((acc, k) => {
        acc[k] = clamp(rollD12(), 1, 12) // raw d12
        return acc
    }, {})

    // translate rolled d12 → stat targets around mid (STAT_MIN..STAT_MAX)
    // e.g. map 1..12 to 8..18 linearly-ish
    const mapped = {}
    keys.forEach(k => {
        mapped[k] = clamp(Math.round(STAT_MIN + (rolled[k] - 1) * ((STAT_MAX - STAT_MIN) / 11)), STAT_MIN, STAT_MAX)
    })

    // apply while keeping inside pool
    const currentSpent = spentPoints.value
    const targetSpent  = Object.values(mapped).reduce((a,b)=>a+b,0) - baseSum.value
    let delta = targetSpent - currentSpent

    // if too expensive, reduce largest stats first
    if (delta > remainingPoints.value) {
        let excess = delta - remainingPoints.value
        // repeatedly trim 1 point from the biggest stat until we fit
        while (excess > 0) {
            let maxKey = keys[0]
            keys.forEach(k => { if (mapped[k] > mapped[maxKey]) maxKey = k })
            if (mapped[maxKey] > STAT_MIN) {
                mapped[maxKey]--
                excess--
            } else {
                break
            }
        }
    }

    // commit
    keys.forEach(k => { stats[k] = mapped[k] })

    // reveal values on the dice (feels nice)
    diceCloud.value.forEach(d => {
        d.value = stats[d.id]
    })

    // let them finish gliding off-screen, then clear
    await new Promise(r => setTimeout(r, 1200))
    diceCloud.value = []
    rolling.value = false
}

/** ---------- Save ---------- **/
async function saveCharacter() {
    if (!canSave.value) {
        error.value = 'Finish your sheet: name/class/race, skills ≤ 3, and points not negative.'
        return
    }
    error.value = null

    // bake race bonus into a separate object (server can merge if desired)
    const bonuses = {
        strength: raceBonusFor('strength'),
        dexterity: raceBonusFor('dexterity'),
        constitution: raceBonusFor('constitution'),
        intelligence: raceBonusFor('intelligence'),
        wisdom: raceBonusFor('wisdom'),
        charisma: raceBonusFor('charisma'),
    }

    try {
        await axios.post('/characters', {
            name: name.value.trim(),
            race: race.value,
            class: charClass.value,
            background: background.value.trim(),
            stats: { ...stats },
            race_bonus: bonuses,
            skills: selectedSkills.value,
            meta: {
                point_pool: POINT_POOL,
                remaining_points: remainingPoints.value,
                stat_min: STAT_MIN,
                stat_max: STAT_MAX,
            }
        })
        success.value = true
        setTimeout(() => router.push('/'), 1200)
    } catch (e) {
        error.value = 'Could not save character.'
    }
}
</script>

<template>
    <div class="relative min-h-screen bg-gradient-to-b from-gray-900 via-stone-900 to-gray-800 text-amber-100 overflow-hidden">
        <!-- DICE ANIMATION LAYER -->
        <div v-for="d in diceCloud" :key="d.id"
             class="pointer-events-none absolute z-0"
             :style="{ left: d.x + '%', animationDelay: (d.delay || 0) + 's' }">
            <div class="d12-spin">
                <div class="d12-face">{{ d.value }}</div>
            </div>
        </div>

        <!-- Sheet -->
        <div class="relative z-10 max-w-4xl mx-auto mt-8 bg-[url('/parchment-texture.jpg')] bg-cover border-2 border-yellow-700 rounded-2xl p-8 shadow-2xl">
            <h1 class="text-3xl font-bold text-red-900 mb-6 font-uncial text-center">🛡️ Character Creator</h1>

            <!-- Top row: Name / Race / Class -->
            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm text-red-900 font-bold mb-1">Name</label>
                    <input v-model="name" class="w-full px-3 py-2 rounded bg-amber-50/90 text-gray-900 border border-yellow-700" />
                </div>

                <div>
                    <label class="block text-sm text-red-900 font-bold mb-1">Race</label>
                    <select v-model="race" class="w-full px-3 py-2 rounded bg-amber-50/90 text-gray-900 border border-yellow-700">
                        <option v-for="r in RACES" :key="r.key" :value="r.key">{{ r.label }}</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm text-red-900 font-bold mb-1">Class</label>
                    <select v-model="charClass" class="w-full px-3 py-2 rounded bg-amber-50/90 text-gray-900 border border-yellow-700">
                        <option v-for="c in CLASSES" :key="c.key" :value="c.key">{{ c.label }}</option>
                    </select>
                </div>
            </div>

            <!-- Background -->
            <div class="mt-4">
                <label class="block text-sm text-red-900 font-bold mb-1">Background</label>
                <input v-model="background" class="w-full px-3 py-2 rounded bg-amber-50/90 text-gray-900 border border-yellow-700" />
            </div>

            <!-- Points + Roll -->
            <div class="mt-6 flex flex-wrap items-center gap-3 justify-between">
                <div class="flex items-center gap-3">
          <span class="inline-flex items-center gap-2 bg-amber-200/90 text-gray-900 border border-yellow-700 rounded px-3 py-1 font-bold">
            🎯 Pool: {{ POINT_POOL }} | Spent: {{ spentPoints }} | Left: {{ remainingPoints }}
          </span>
                    <span class="text-xs text-red-900 italic">Min {{ STAT_MIN }}, Max {{ STAT_MAX }} per stat</span>
                </div>
                <button
                    @click="rollWithDice"
                    :disabled="rolling"
                    class="bg-red-800 hover:bg-red-700 text-amber-100 font-bold px-4 py-2 rounded-lg shadow-md transition disabled:opacity-50">
                    🎲 {{ rolling ? 'Rolling...' : 'Roll D12 For Me' }}
                </button>
            </div>

            <!-- Stats Grid -->
            <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-3 gap-4 text-gray-900">
                <div v-for="(v, k) in stats" :key="k" class="bg-amber-50/90 p-4 rounded-lg border border-yellow-700">
                    <div class="flex items-center justify-between">
                        <div class="font-uncial text-red-900 uppercase text-sm">{{ k }}</div>
                        <div class="text-xs text-gray-700">
                            bonus: +{{ raceBonusFor(k) }}
                        </div>
                    </div>

                    <div class="mt-3 flex items-center justify-between">
                        <button @click="decStat(k)" class="w-8 h-8 rounded bg-red-900 text-amber-100 font-bold disabled:opacity-40"
                                :disabled="stats[k] <= STAT_MIN">−</button>
                        <div class="text-2xl font-extrabold">{{ v }}</div>
                        <button @click="incStat(k)" class="w-8 h-8 rounded bg-green-700 text-amber-100 font-bold disabled:opacity-40"
                                :disabled="remainingPoints <= 0 || stats[k] >= STAT_MAX">+</button>
                    </div>
                </div>
            </div>

            <!-- Skills -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-2xl text-red-900 font-uncial">Skills ({{ selectedSkills.length }}/{{ MAX_SKILLS }})</h2>
                    <span class="text-xs text-red-900 italic">Class-locked</span>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    <button
                        v-for="s in availableSkills"
                        :key="s.key"
                        @click="toggleSkill(s.key)"
                        class="border border-yellow-700 rounded-lg px-3 py-2 text-left transition"
                        :class="selectedSkills.includes(s.key)
              ? 'bg-green-200/90 text-gray-900 shadow'
              : 'bg-amber-50/90 text-gray-900 hover:bg-amber-100'"
                    >
                        <div class="font-bold">{{ s.label }}</div>
                        <div class="text-xs opacity-75">{{ s.key }}</div>
                    </button>
                </div>
            </div>

            <!-- Messages -->
            <p v-if="error" class="text-red-700 font-bold mt-4">{{ error }}</p>
            <p v-if="success" class="text-green-700 font-bold mt-4">Character saved! Returning to tavern...</p>

            <!-- Save -->
            <div class="mt-8 text-center">
                <button
                    @click="saveCharacter"
                    :disabled="!canSave"
                    class="bg-green-700 hover:bg-green-600 disabled:opacity-40 text-amber-100 font-bold px-6 py-3 rounded-lg shadow-md transition transform hover:scale-105"
                >
                    Save Character
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.font-uncial { font-family: 'Uncial Antiqua', cursive; }

/* ---------- D12 visual + motion ---------- */
/* Each die consists of a rotating shell and a face with number */
.d12-spin {
    width: 58px;
    height: 58px;
    perspective: 900px;
    animation: glide 1.6s ease-in-out forwards;
    filter: drop-shadow(0 6px 8px rgba(0,0,0,0.35));
}

.d12-face {
    width: 58px;
    height: 58px;
    display: grid;
    place-items: center;
    font-weight: 800;
    color: #2b1c10;

    /* faux d12 shape — a dodecagon-ish cut with beveled feel */
    background: radial-gradient(circle at 30% 30%, #ffe089, #d7a73c 65%, #b5821e 100%);
    border: 2px solid #6b4a12;
    border-radius: 12px;
    clip-path: polygon(
        50% 0%,
        72% 6%,
        90% 18%,
        100% 38%,
        100% 62%,
        90% 82%,
        72% 94%,
        50% 100%,
        28% 94%,
        10% 82%,
        0% 62%,
        0% 38%,
        10% 18%,
        28% 6%
    );

    transform: rotateX(0deg) rotateY(0deg);
    animation: spin3d 1.2s ease-in-out infinite alternate;
}

@keyframes spin3d {
    0%   { transform: rotateX(0deg) rotateY(0deg)   scale(1.0); }
    50%  { transform: rotateX(35deg) rotateY(180deg) scale(1.08); }
    100% { transform: rotateX(0deg) rotateY(360deg)  scale(1.0); }
}

/* fly from top to bottom with a gentle arc */
@keyframes glide {
    0%   { transform: translateY(-80vh) translateX(-10px) rotate(-8deg); opacity: 0.2; }
    20%  { opacity: 1; }
    50%  { transform: translateY(10vh) translateX(20px) rotate(6deg); }
    100% { transform: translateY(90vh) translateX(40px) rotate(0deg); opacity: 0.0; }
}
</style>
