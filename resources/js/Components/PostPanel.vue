<template>
     <div>
        <div class="flex items-start mb-[20px]">
            <img src="https://picsum.photos/seed/picsum/35/35" class="w-[35px] rounded-full mt-[5px] mr-[5px]">
            <div>
                <h1 class="text-[18px] font-semibold text-[#333]">{{ post.user.name }}</h1>
                <small class="block mb-[-2px]">Founder and CEO at Giva | Angel Investor</small>
                <small class="block mb-[-2px]">2 hours ago </small>
            </div>
        </div>
        <p class="text-[14px] mb-[15px]">The sucess of every website depends on Search engine optimisation
            and digital marketing strategy. If you are not in the first page of all major search engines
            then you are ahead among your competitors.
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
</template>
<script setup>
const props = defineProps({
    post:Object
})
</script>