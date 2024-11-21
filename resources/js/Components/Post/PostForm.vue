<script setup>
import SectionWrapper from '../SectionWrapper.vue';
import AddPostModal from '@/Components/Post/AddPostModal.vue';
</script>

<template>
    <SectionWrapper>
        <div class="flex items-start py-[20px] px-[25px] pt-[20px] pb-[10px]">
            <img :src="$page.props.auth.user.profile_photo_url" class="w-[35px] rounded-full mr-[10px]">
            <add-post-modal btn_name="Write Something..." class="w-full text-black border-gray-900 bg-gray-200 hover:bg-gray-300 rounded-2xl text-left p-2"/>
        </div>
        <div class="flex items-start">
            <li class="list-none border-t border-r border-[#ccc] flex-[0_0_25%] h-[40px] text-[13px] flex items-center justify-center cursor-pointer"><img src="" class="w-[15px] mr-[5px]" >Photo</li>
            <li class="list-none border-t border-r border-[#ccc] flex-[0_0_25%] h-[40px] text-[13px] flex items-center justify-center cursor-pointer"><img src="" class="w-[15px] mr-[5px]" >Video</li>
            <li class="list-none border-t border-r border-[#ccc] flex-[0_0_25%] h-[40px] text-[13px] flex items-center justify-center cursor-pointer"><img src="" class="w-[15px] mr-[5px]" >Event</li>
            <li class="list-none border-t border-r border-[#ccc] flex-[0_0_25%] h-[40px] text-[13px] flex items-center justify-center cursor-pointer">Post</li>
        </div>
    </SectionWrapper>
</template>