<script setup>
import PostItem from './PostItem.vue';
import { router } from '@inertiajs/vue3'; 
import { useFlash } from '@/Utilities/Composables/useFlash';

const props = defineProps(['posts']);

const { confirmFlash2, toast } = useFlash();

const deleteR = async (postId) => {
    return await router.delete(route('posts.destroy', postId), {
        onSuccess: () => {
            toast({
                icon: 'success',
                title: 'Item is successfully deleted'
            })
        },
        onError: () => {
            toast({
                icon: 'error',
                title: 'Item is failed to delete'
            })
        }
    });
}
const deletePost = async (postId) => {
   await confirmFlash2({
        entityId: postId,
        deleteAction: deleteR
    });
}
</script>
<template>
    <template v-if="posts && posts.data && posts.data.length > 0">
        <post-item @editPost="edit" @deletePost="deletePost" v-for="post in posts.data" :key="post.id" :post="post"/>
    </template>
    <template v-else>
            <div class="text-center">
                <span>There is no post to show at the moment.</span>
            </div>
    </template>
</template>