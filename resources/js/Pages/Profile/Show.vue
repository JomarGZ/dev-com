
<template>
   <AppLayout>
        <div>
            <h2>Show profile</h2>
            <p>{{ user.name }}</p>
            <Link v-if="user.can.edit" :href="route('profile.show')">Edit Profile</Link>
        </div>
   </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps(['user']);
</script>
