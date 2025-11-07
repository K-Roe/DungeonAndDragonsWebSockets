<template>
  <div v-if="show" class="fixed inset-0 bg-black/70 flex justify-center items-center z-50 p-4">
    <div
        class="bg-white/10 border border-white/20 backdrop-blur-md rounded-2xl p-6 w-full max-w-md max-h-[90vh] overflow-y-auto text-center shadow-2xl"
    >
      <h3 class="text-xl sm:text-2xl font-bold text-purple-300 mb-4 drop-shadow-lg break-words">
        {{ title }}
      </h3>
      <p class="text-white/80 mb-6 break-words text-sm sm:text-base">
        {{ message }} <strong v-if="itemName">{{ itemName }}</strong>
      </p>
      <div class="flex flex-col sm:flex-row justify-center gap-3">
        <button
            @click="$emit('confirm')"
            class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-2xl shadow-lg transition duration-300"
        >
          {{ confirmText }}
        </button>
        <button
            @click="$emit('cancel')"
            class="w-full sm:w-auto bg-gray-600 hover:bg-gray-700 text-white font-semibold px-6 py-3 rounded-2xl shadow-lg transition duration-300"
        >
          {{ cancelText }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  show: { type: Boolean, required: true },
  title: { type: String, default: 'Confirm Action' },
  message: { type: String, default: 'Are you sure?' },
  itemName: { type: String, default: '' },
  confirmText: { type: String, default: 'Confirm' },
  cancelText: { type: String, default: 'Cancel' },
})

defineEmits(['confirm', 'cancel'])
</script>
