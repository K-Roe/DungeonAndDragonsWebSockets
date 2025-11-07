<script setup>
import {ref} from "vue"

// Props
defineProps({
  show: {
    type: Boolean,
    required: true
  }
})

const emit = defineEmits(["close", "save"])

const selectedMonth = ref("")
const selectedYear = ref("")
const toastMessage = ref("")
let toastTimeout = null

const showToast = (message) => {
  toastMessage.value = message
  clearTimeout(toastTimeout)
  toastTimeout = setTimeout(() => {
    toastMessage.value = ""
  }, 3000) // auto-hide after 3s
}

const months = [
  "January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
]

const currentYear = new Date().getFullYear();
const range = 10; // years forward/backward

const years = Array.from({ length: range * 2 + 1 }, (_, i) => currentYear - range + i);

const cancel = () => {
  selectedMonth.value = ""
  selectedYear.value = ""
  emit("close")
}

const save = () => {
  if (!selectedMonth.value || !selectedYear.value) {
    showToast("⚠️ Please select both a month and a year before saving.")
    return
  }

  const assessmentName = `${selectedMonth.value} ${selectedYear.value}`
  emit("save", assessmentName)
  cancel()
}
</script>

<template>
  <div v-if="show" class="fixed inset-0 bg-black/70 flex items-center justify-center z-50"
       @click.self="cancel">
    <div v-if="toastMessage"
         class="fixed bottom-6 right-6 bg-red-600 text-white px-4 py-2 rounded-lg shadow-lg animate-fade-in">
      {{ toastMessage }}
    </div>
    <div class="bg-white/10 border border-white/20 backdrop-blur-md rounded-2xl p-8 w-96 shadow-2xl">
      <h2 class="text-2xl font-bold mb-6 text-indigo-300 drop-shadow-lg">
        Date Of Your Assessment
      </h2>

      <!-- Month & Year Select -->
      <div class="flex gap-4 mb-6">
        <select v-model="selectedMonth"
                class="flex-1 px-4 py-3 rounded-lg bg-white text-gray-900 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          <option disabled value="">Select Month</option>
          <option v-for="(month, index) in months" :key="index" :value="month">
            {{ month }}
          </option>
        </select>

        <select v-model="selectedYear"
                class="flex-1 px-4 py-3 rounded-lg bg-white text-gray-900 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          <option disabled value="">Select Year</option>
          <option v-for="year in years" :key="year" :value="year">
            {{ year }}
          </option>
        </select>
      </div>

      <div class="flex justify-end gap-4">
        <button
            class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition duration-300"
            @click="cancel">
          Cancel
        </button>
        <button
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition duration-300"
            @click="save"
        >
          Save
        </button>
      </div>
    </div>
  </div>
</template>

<style>
@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fade-in 0.3s ease-out;
}
</style>
