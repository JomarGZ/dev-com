<template>
    <Link 
        :href="notification.data.info.link"
        
        class="flex items-center px-4 py-3 hover:bg-gray-200 cursor-pointer border-b border-black relative"
        :class="{'bg-gray-300' : notification.read_at == null}"
        >
        <img 
            :src="notification.data.info.profile_photo_url" 
            class="h-8 w-8 rounded-full object-cover"
            alt="User avatar"
        >
        <div class="ml-3 overflow-hidden flex-grow pr-8">
            <p class="text-sm font-bold text-gray-900">{{ notification.data.info.name }}</p>
            <p class="text-sm text-gray-500 truncate">{{ notification.data.info.message }}</p>
            <span class="text-xs text-gray-500">{{ relativeDate(notification.created_at) }}</span>
        </div>
        <form @submit.prevent="deleteNotification(notification.id)" class="absolute right-2 top-1/2 transform -translate-y-1/2">
            <button 
                type="submit" 
                class="w-6 h-6 flex items-center justify-center bg-gray-200 hover:bg-gray-300 rounded-full text-gray-600 hover:text-gray-800 transition-colors duration-200"
            >
                <span class="sr-only">Delete notification</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </form>
    </Link>
</template>
<script setup>
import { relativeDate } from '@/Utilities/Date';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps(['notification']);

const notification = ref(props.notification);
const deleteNotification = () => {};


</script>