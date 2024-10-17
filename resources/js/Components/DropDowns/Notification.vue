<template>
  <div class="relative inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
    <!-- Notification button -->
    <button @click="toggleDropdown" class="flex items-center space-x-2 p-2 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 relative" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
      </svg>
      <span v-if="unread.length > 0" class="bg-red-500 text-white text-xs rounded-full px-2 py-1 absolute top-2">{{ unread.length }}</span>
    </button>

    <!-- Dropdown -->
    <div v-if="isOpen" class="absolute right-0 top-12 mt-2 w-80 bg-white rounded-md shadow-lg overflow-hidden z-20">
      <div class="py-2">
        <div class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100">
          Notifications
        </div>
        <div v-if="notifications.length == 0" class="px-4 py-2 text-sm text-gray-500">
          No new notifications    
        </div>
        <div v-else>
          <Link v-for="notification in notifications" :key="notification.id"  href="#" class="flex items-center px-4 py-3 hover:bg-gray-200 cursor-pointer" :class="{'bg-gray-300' : notification.read_at == null}">
            <img src="https://picsum.photos/55/55" class="h-8 w-8 rounded-full object-cover">
            <div class="ml-3 overflow-hidden">
              <p class="text-sm font-medium text-gray-900">{{ notification.name }}</p>
              <p class="text-sm text-gray-500 truncate">{{ notification.message }}</p>
              <span class="text-xs text-gray-400">{{ notification.date }}</span>
            </div>
          </Link>
        </div>
        <a href="#" class="block bg-gray-50 text-sm font-medium text-indigo-600 text-center px-4 py-2 hover:text-indigo-500">
          View all notifications
        </a>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue'

const isOpen = ref(false);
const notifications = ref([
  {
    id: 1,
    name: 'John Doe',
    message: 'Accepted your friend request',
    date: '2 minutes ago',
    read_at: null
  },
  {
    id: 2,
    name: 'Jason Mras',
    message: 'Denied your friend request',
    date: '1 hour ago',
    read_at: '2024-10-12 03:59:44'
  },
  {
    id: 3,
    name: 'Jenny Santos',
    message: 'Sent you a friend request',
    date: '2 days ago',
    read_at: null
  },
]);
const unread = ref([
  {
    id: 1,
    name: 'John Doe',
    message: 'Accepted your friend request',
    date: '2 minutes ago',
    read_at: null
  },
  {
    id: 3,
    name: 'Jenny Santos',
    message: 'Sent you a friend request',
    date: '2 days ago',
    read_at: null
  },
]);
const toggleDropdown = () => isOpen.value = !isOpen.value;

//display number of unread notifications if there is any.
//filter the unread notification.
//
</script>