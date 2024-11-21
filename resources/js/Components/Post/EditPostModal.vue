<script setup>
import Modal from "@/Components/Modal/Modal.vue";
import LoadingPrimaryButton from "@/Components/Buttons/LoadingPrimaryButton.vue";
import { ref, watch, watchEffect } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import { useFlash } from "@/Utilities/Composables/useFlash";
import axios from "axios";
const props = defineProps(['btn_name', 'postId']);

const { toast } = useFlash();
const showModal = ref(false);
const form = useForm({
    body: ''
});

watch(showModal, async () => {
    if (showModal.value === true) {
        if (!props.postId) {
            console.error('Post ID is required to process deletion');
            return;
        }
        const res = await axios.get(route('posts.edit', props.postId))
        form.body = res.data.body;
           
    } else {
        form.reset();
    }
});

const disabledBtn = ref(true);

watch(form, () => {
    if (form.body !== '') {
        disabledBtn.value = false;
    } else {
        disabledBtn.value = true;
    }
})

const UpdatePostRequest = (postId) => {
    if (!postId) {
        console.error('Post ID is required on updating the post');
        return;
    }
    return form.put(route('posts.update', postId), {
        onSuccess: () => {
            toast({
                title: 'Post update successfuly'
            });
            form.reset();
            showModal.value = false;
        },
        onError: (err) => {
            console.error('Error on update post', err);
            toast({
                icon: 'error',
                title : 'Failed to update post'
            })
        }
    });
}
const submit = async () => {
    await UpdatePostRequest(props.postId);
}

</script>
<template>
    <button 
        @click="showModal = true" 
        :class="$attrs.class"
    >
    {{ btn_name ? btn_name : 'Open Modal' }}
    </button>
    <teleport to="body">
        <Modal :show="showModal" @close="showModal = false">
                <template #header>
                    <div class="flex items-center gap-2">
                        <div class="w-12 h-12 rounded-full overflow-hidden">
                            <img :src="$page.props.auth.user.profile_photo_url" alt="Profile" class="w-full h-full object-cover" />
                        </div>
                        <div>
                            <div class="flex items-center gap-1">
                                <h3 class="font-semibold">{{ $page.props.auth.user.name }}</h3>
                                <svg class="w-4 h-4 text-gray-600" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M8 11L3 6h10z"/>
                                </svg>
                            </div>
                            <p class="text-xs text-gray-600">Post to Anyone</p>
                            <div v-if="form.errors.body" class="mb-2">
                                <p class="text-red-600 bg-red-100 text-center rounded-sm text-sm p-1">{{ form.errors.body }}</p>
                            </div>
                        </div>
                    </div>
                </template>
                <template #default>
                     <form>
                        <textarea v-model="form.body"
                            placeholder="What do you want to talk about?" 
                            class="w-full h-32 resize-none border-0 focus:ring-0 text-lg placeholder:text-gray-500"
                        ></textarea>
                        <!-- Action buttons -->
                        <div class="flex items-center gap-1">
                            <button type="button" class="p-2 hover:bg-gray-100 rounded-full" title="Add media">
                                <svg class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM5 19V5h14v14H5z" fill="currentColor"/>
                                    <path d="M13.96 12.29l-2.75 3.54-1.96-2.36L6.5 17h11l-3.54-4.71z" fill="currentColor"/>
                                </svg>
                            </button>
                            <button type="button" class="p-2 hover:bg-gray-100 rounded-full" title="Add event">
                                <svg class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24">
                                    <path d="M19 4h-1V3c0-.55-.45-1-1-1s-1 .45-1 1v1H8V3c0-.55-.45-1-1-1s-1 .45-1 1v1H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2z" fill="currentColor"/>
                                </svg>
                            </button>
                            <button type="button" class="p-2 hover:bg-gray-100 rounded-full" title="Print">
                                <svg class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24">
                                    <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z" fill="currentColor"/>
                                </svg>
                            </button>
                            <button type="button" class="p-2 hover:bg-gray-100 rounded-full" title="More">
                                <svg class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24">
                                    <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" fill="currentColor"/>
                                </svg>
                            </button>
                        </div>
                     </form>
                </template>
                <template #footer>
                    <button type="button" class="p-2 hover:bg-gray-100 rounded-full" title="Set timer">
                        <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24">
                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z" fill="currentColor"/>
                        </svg>
                    </button>
                    <loading-primary-button @click="submit()" :disabled="disabledBtn" :processing="form.processing" label="Update Post"/>
                </template>
        </Modal>
    </teleport>
</template>