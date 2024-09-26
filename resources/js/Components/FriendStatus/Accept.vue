<template>
    <form @submit.prevent="acceptFriendRequest">
        <button class="bg-blue-600 text-white px-4 py-1 rounded-full">Accept</button>
    </form>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3';
const props = defineProps(['user']);
const form = useForm({});

const acceptFriendRequest = () => {
    console.log('triggered');
    form.put(route('friends.update', {user: props.user}), {
        preserveScroll: true,
        onSuccess: () => {}
    });
}
</script>