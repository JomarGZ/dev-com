<script setup>
import SectionWrapper from '../SectionWrapper.vue';
import { relativeDate } from '@/Utilities/Date';
import AddPostModal from './AddPostModal.vue';
import Icon from '../Icon.vue';
const props = defineProps({
    post:Object
})
const emit = defineEmits(['deletePost']);

const deletePost = (postId) => {
    emit('deletePost', postId);
}
</script>
 <template>
    <section-wrapper class="py-[20px] px-[25px] pb-[5px] my-[5px] mb-[15px]">
        <div class="relative">
            <div class="absolute right-0 ml-auto gap-4 items-center">
                <button v-if="post.can.delete" @click="deletePost(post.id)" class="hover:bg-gray-200 p-2 rounded-full">
                    <Icon name="x-close"/>
                </button>
                <add-post-modal 
                    v-if="post.can.edit" 
                    :editPost="true" 
                    btn_name="Edit" 
                    class="hover:bg-gray-200 p-2 rounded-full"
                />
            </div>
            <div class="flex items-start mb-[20px]">
                <img :src="post.user.profile_photo_url" class="w-[35px] rounded-full mt-[5px] mr-[5px]">
                <div>
                    <h1 class="text-[18px] font-semibold text-[#333]">{{ post.user.name }}</h1>
                    <small class="block mb-[-2px]">Founder and CEO at Giva | Angel Investor</small>
                    <small class="block mb-[-2px]">{{ relativeDate(post.created_at) }}</small>
                </div>
            </div>
            <p class="text-[14px] mb-[15px] text-gray-700 font-semibold">
                {{ post.body }}
            </p>
            <img src="https://picsum.photos/seed/picsum/300/200" width="100%">

            <div class="flex flex-wrap items-center justify-between text-[12px] border-b border-[#ccc] pb-[6px]">
                <div class="flex items-center">
                    <img src="" class="w-[15px] mr-[-5px]">
                    <img src="" class="w-[15px] mr-[-5px]">
                    <img src="" class="w-[15px] mr-[-5px]">
                    <span class="ml-[10px]">Adam Doe and 89 others</span>
                </div>
                <div>
                    <span>22 comments &middot; 40 shares</span>
                </div>
            </div>
            <div class="flex items-center justify-between p-[10px] text-[14px] font-medium">
                <div class="flex items-center">
                    <img src="" class="w-[22px] rounded-full">
                    <img src="" class="w-[12px] ml-[5px]">
                    
                </div>
                <div class="w-[18px] mr-[8px]">
                    <img src="">
                    <span>Like</span>
                </div>
                <div class="w-[18px] mr-[8px]">
                    <img src="">
                    <span>Comment</span>
                </div>
                <div class="w-[18px] mr-[8px]">
                    <img src="">
                    <span>Share</span>
                </div>
                <div class="w-[18px] mr-[8px]">
                    <img src="">
                    <span>Send</span>
                </div>
            </div>
        </div>
    </section-wrapper>
</template>
