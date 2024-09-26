<template>
    <form @submit.prevent="denyFriendRequest">
        <button class="border border-blue-600 text-blue-600 px-4 py-1 rounded-full">Ignore</button>
    </form>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3';
const props = defineProps(['user']);
const form = useForm({});

const denyFriendRequest = () => {
    form.delete(route('friends.deny', {user: user}), {
        preserveScroll: true,
        onSuccess: () => {}
    });
}
</script>