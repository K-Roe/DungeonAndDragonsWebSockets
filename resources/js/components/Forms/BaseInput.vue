<template>
  <div>
    <label :for="id" class="block mb-2 font-semibold text-white/90">{{ label }}</label>
    <input
        :id="id"
        :value="modelValue"
        :type="type"
        :placeholder="placeholder"
        class="w-full px-4 py-2 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-purple-400"
        @input="$emit('update:modelValue', $event.target.value)"
    />
  </div>
</template>

<script setup>
defineProps({
  id: {type: String, required: true},
  label: {type: String, required: true},
  placeholder: {type: String, default: ''},
  type: {type: String, default: 'text'},
  modelValue: {type: String, default: ''}
})

defineEmits(['update:modelValue'])
</script>
