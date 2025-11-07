<template>
  <div class="flex flex-wrap justify-center gap-4 mb-4">
    <!-- Profile Button -->
    <router-link
        to="/profile"
        class="flex items-center justify-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-2 rounded-lg shadow-lg transition duration-300"
    >
      📊 View Profile
    </router-link>

    <!-- Create Assessment Button -->
    <button
        @click="$emit('create')"
        class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow-lg transition duration-300"
    >
      📝 Create Assessment
    </button>

  </div>
</template>

<script setup>

import {useSubscriptionStore} from "../../stores/subscription.js";

defineProps({
  assessmentId: String,
  assessmentCount: Number

})

const subscriptionStore = useSubscriptionStore();


defineEmits(['create'])
</script>
