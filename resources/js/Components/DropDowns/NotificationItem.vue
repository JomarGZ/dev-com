<script setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps(['read', 'unread']);

</script>

<template>
    <template v-if="unread">
        <Link class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">unread data</Link>
    </template>
    <template v-if="read">
        <Link class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">read data</Link>
    </template>
</template>