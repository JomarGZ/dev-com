<script setup>
import { usePage } from '@inertiajs/vue3';
import Dropdown from '../Dropdown.vue';
import Icon from '../Icon.vue';
import { computed, ref } from 'vue';
import NotificationItem from './NotificationItem.vue';

const page = usePage();


const notifications = computed(() => page.props.auth.user.notifications);
const unreadNotificationsLength = computed(() => page.props.auth.user.unread_notifications.length);
const unreadNotifications = computed(() => page.props.auth.user.unread_notifications);
const readNotifications = computed(() => page.props.auth.user.read_notifications);

</script>
<template>
       <Dropdown class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
            <template #trigger>
                    <button>
                        <Icon name="bell"/>
                        <template v-if="unreadNotificationsLength > 0">
                            <span class="text-white text-xs bg-red-600 rounded-full px-2 py-1 absolute bottom-2 left-3">
                                {{ unreadNotificationsLength }}
                            </span>
                        </template>
                    </button>
            </template>
            <template #content v-if="notifications.length > 0">
                    <NotificationItem v-for="unreadNotification in unreadNotifications" :key="unreadNotification.id" :unread="unreadNotification"/>
                    <NotificationItem v-for="readNotification in readNotifications" :key="readNotification.id" :read="readNotification"/>
            </template>
            <template #content v-else>
                <div class="block text-center px-4 py-2 text-xs text-gray-400">
                    You have 0 notifications
                </div>
            </template>
        </Dropdown>
</template>