<template>
  <div class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-50">
    <!-- Chat bubble -->
    <button
        v-if="!chatOpen"
        @click="toggleChat"
        class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-purple-600 flex items-center justify-center text-white shadow-xl hover:bg-purple-500 transition"
        title="Open Merlin AI Chat"
    >
      💬
    </button>

    <!-- Chat window -->
    <div
        v-if="chatOpen"
        class="w-72 sm:w-80 max-h-[70vh] bg-white/95 rounded-xl shadow-2xl flex flex-col overflow-hidden"
    >
      <!-- Header -->
      <div class="bg-purple-600 text-white p-3 flex justify-between items-center rounded-t-xl">
        <span class="font-semibold text-sm sm:text-base">Merlin AI Chat</span>
        <button @click="toggleChat" class="text-white text-lg font-bold hover:text-gray-200">✕</button>
      </div>

      <!-- Messages -->
      <div class="flex-1 p-2 sm:p-3 overflow-y-auto space-y-2 chat-scroll bg-gray-50">
        <div
            v-for="(msg, i) in chatStore.messages"
            :key="i"
            :class="msg.role === 'user' ? 'self-end bg-blue-500 text-white' : 'self-start bg-green-200 text-gray-800'"
            class="px-3 py-2 rounded-xl max-w-[75%] sm:max-w-[70%] break-words shadow-sm text-sm sm:text-base"
        >
          <span v-if="msg.role === 'assistant'" class="font-semibold mr-1">Merlin AI:</span>
          <span>{{ msg.content }}</span>
        </div>

        <!-- Loading indicator -->
        <div
            v-if="chatStore.loading"
            class="self-start bg-green-200 text-gray-800 px-3 py-2 rounded-xl max-w-[70%] sm:max-w-[60%] animate-pulse shadow-sm text-sm sm:text-base"
        >
          Merlin AI is typing...
        </div>
      </div>

      <!-- Input -->
      <div class="p-2 border-t border-gray-300 flex gap-1 sm:gap-2 bg-gray-100">
        <input
            v-model="userMessage"
            @keyup.enter="sendMessage"
            type="text"
            placeholder="Ask me anything..."
            class="flex-1 border border-gray-300 rounded-md px-2 py-1 text-gray-900 placeholder-gray-500 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-purple-500"
        />
        <button
            @click="sendMessage"
            class="bg-purple-600 text-white px-3 py-1 sm:px-4 sm:py-1.5 rounded-md hover:bg-purple-500 transition font-semibold text-sm sm:text-base"
            :disabled="chatStore.loading"
        >
          Send
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useChatStore } from '../stores/chat';

const chatStore = useChatStore();
const userMessage = ref('');
const chatOpen = ref(false);

const sendMessage = async () => {
  if (!userMessage.value.trim()) return;
  await chatStore.sendMessage(userMessage.value);
  userMessage.value = '';
};

const toggleChat = () => {
  chatOpen.value = !chatOpen.value;
  if (chatOpen.value) chatStore.initChat();
};
</script>

<style scoped>
.chat-scroll::-webkit-scrollbar { width: 6px; }
.chat-scroll::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.2); border-radius: 3px; }
</style>
