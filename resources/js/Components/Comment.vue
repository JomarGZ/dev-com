<template>
    <div class="sm:flex">
        <div class="mb-4 flex-shrink-0 sm:mb-0 sm:mr-4">
            <img :src="`https://ui-avatars.com/api/?name=${comment.user.name}&background=random`" class="h-10 w-10 rounded-full" />
        </div>
        <div class="flex-1">
            <div class="mt-1 prose prose-sm max-w-none" v-html="comment.html"></div>
            <span class="first-letter:uppercase block pt-1 text-xs text-gray-600">
                By {{ comment.user.name }} {{ relativeDate(comment.created_at) }} | <span class="text-pink-500">{{ comment.likes_count }} likes</span>
            </span>
            <div class="mt-1 flex justify-end space-x-3 text-right empty:hidden">
                <div v-if="$page.props.auth.user">
                    <Link v-if="comment.can.like" preserve-scroll :href="route('likes.store', ['comment', comment.id])" method="post" class="inline-block text-gray-700 hover:text-pink-500 transition-colors">
                        <HandThumbUpIcon class="size-4 inline-block mr-1"/>
                        <span class="sr-only">Like Comment</span>
                    </Link>
                    <Link v-else preserve-scroll :href="route('likes.destroy', ['comment', comment.id])" method="delete" class="inline-block text-gray-700 hover:text-pink-500 transition-colors">
                        <HandThumbDownIcon class="size-4 inline-block mr-1"/>
                        <span class="sr-only">Unlike Comment</span>
                    </Link>
                </div>
                <form v-if="comment.can?.edit" @submit.prevent="$emit('update', comment.id)">
                    <button class="font-mono text-xs hover:font-semibold">Edit</button>
                </form>
                <form v-if="comment.can?.delete" @submit.prevent="$emit('delete', comment.id)">
                    <button class="font-mono text-red-700 text-xs hover:font-semibold">Delete</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import {relativeDate} from "@/Utilities/Date.js";
import { HandThumbDownIcon, HandThumbUpIcon } from "@heroicons/vue/24/solid";
import { Link } from "@inertiajs/vue3";
const props = defineProps(['comment']);


const emit = defineEmits(['delete', 'update']);

</script>