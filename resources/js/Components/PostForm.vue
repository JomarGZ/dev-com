<script setup>
import SectionWrapper from './SectionWrapper.vue';
const props = defineProps({
    profile_photo_url: {
        type: String,
        required: true
    }
})
</script>

<template>
    <SectionWrapper>
        <div class="flex items-start py-[20px] px-[25px] pt-[20px] pb-[10px]">
            <img :src="profile_photo_url" class="w-[35px] rounded-full mr-[10px]">
            <textarea rows="2" placeholder="Write Something" class="w-full border-0 outline-0 resize-none bg-transparent mt-[8px]"></textarea>
        </div>
        <div class="flex items-start">
            <li class="list-none border-t border-r border-[#ccc] flex-[0_0_25%] h-[40px] text-[13px] flex items-center justify-center cursor-pointer"><img src="" class="w-[15px] mr-[5px]" >Photo</li>
            <li class="list-none border-t border-r border-[#ccc] flex-[0_0_25%] h-[40px] text-[13px] flex items-center justify-center cursor-pointer"><img src="" class="w-[15px] mr-[5px]" >Video</li>
            <li class="list-none border-t border-r border-[#ccc] flex-[0_0_25%] h-[40px] text-[13px] flex items-center justify-center cursor-pointer"><img src="" class="w-[15px] mr-[5px]" >Event</li>
            <li class="list-none border-t border-r border-[#ccc] flex-[0_0_25%] h-[40px] text-[13px] flex items-center justify-center cursor-pointer">Post</li>
        </div>
    </SectionWrapper>
</template>