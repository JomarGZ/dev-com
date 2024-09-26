<template>
    <template v-if="props.friendRequestReceivedFrom">
         <div class="flex gap-2">
             <Accept :user="user"/>
             <Ignore :user="user"/>
         </div>
     </template>
     <template v-else-if="props.friendRequestSentTo">
             <h3 class=" border px-3 py-1 rounded font-semibold text-md text-gray-800 leading-tight">Pending friend request</h3>
     </template>
     <template v-else-if="props.isFriendWith">
         <form @submit.prevent="unfriend">
             <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded-full" :disabled="unFriendform.processing">Unfriend</button>
         </form>
     </template>
     <template v-else-if="$page.props.auth.user.id !== props.user.id">
         <form @submit.prevent="addFriend">
             <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded-full" :disabled="addFriendform.processing">Add Friend</button>
         </form>
     </template>
 </template>
 <script setup>
 import { useForm } from '@inertiajs/vue3';
 import Accept from './Accept.vue';
 import Ignore from './Ignore.vue';
 
 const props = defineProps(['user', 'friendRequestReceivedFrom', 'isFriendWith', 'friendRequestSentTo']);
 const addFriendform = useForm({});
 const unFriendform = useForm({});
 
 const addFriend = () => {
    addFriendform.post(route('friends.store', {user: props.user}), {
         preserveScroll: true,
         onSuccess: () => {}
    });
 }
 const unfriend = () => {
    unFriendform.delete(route('friends.destroy', {user: props.user}), {
         preserveScroll: true,
         onSuccess: () => {}
    });
 }

 </script>