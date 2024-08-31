
<template>
    <AppLayout :title="title">
        <div class="flex flex-wrap justify-between p-[20px] px-[6%]">
            <div class="flex-[0_0_25%] self-start sticky top-[73px]">
                <SectionWrapper>
                        <img src="https://picsum.photos/seed/picsum/200/100" class="w-full">
                        <div v-if="user" class="px-[25px] py-0">
                            <img src="https://picsum.photos/90/90" class="w-[90px] h-[90px] rounded-full bg-white p-[4px] mt-[-45px]">
                            <h1 class="text-[20px] font-semibold text-[#222]">{{ user.name }}</h1>
                            <h3 class="text-[14px] font-medium text-[#777]">{{ user.profile.headline }}</h3>
                            <ul class="list-none my-5">
                                <li class="w-full my-[5px] text-[13px]">Your profile views <span class="float-right text-[#045be6]">24</span></li>
                                <li class="w-full my-[5px] text-[13px]">Your post views <span class="float-right text-[#045be6]">128</span></li>
                                <li class="w-full my-[5px] text-[13px]">Your Connections <span class="float-right text-[#045be6]">108</span></li>
                            </ul>
                        </div>
                        <div class="flex items-center border-t border-[#ccc]">
                            <a href="#" class="flex flex-col flex-[0_0_50%] items-center justify-center py-[15px] text-[13px] border-l border-[#ccc]"><img src="" class="w-[20px] mr-[10px]">My Items</a>
                            <a href="#" class="flex flex-col flex-[0_0_50%] items-center justify-center py-[15px] text-[13px] border-l border-[#ccc]"><img src="" class="w-[20px] mr-[10px]">Try Premium</a>
                        </div>
                </SectionWrapper> 
              
                <SectionWrapper class=" py-[5px] px-[25px] my-[12px]">
                    <h3 class="text-[#777] text-[14px] font-medium my-[20px] mb-[10px]">RECENT</h3>
                    <a href="#" class="flex items-center text-[12px] font-medium text-[#888] my-[3px]"><img src="" class="w-[20px] mr-[10px]">Data Analysis</a>
                    <a href="#" class="flex items-center text-[12px] font-medium text-[#888] my-[3px]"><img src="" class="w-[20px] mr-[10px]">UI UX Design</a>
                    <a href="#" class="flex items-center text-[12px] font-medium text-[#888] my-[3px]"><img src="" class="w-[20px] mr-[10px]">Web Development</a>
                    <a href="#" class="flex items-center text-[12px] font-medium text-[#888] my-[3px]"><img src="" class="w-[20px] mr-[10px]">Object Oriented Programming</a>
                    <a href="#" class="flex items-center text-[12px] font-medium text-[#888] my-[3px]"><img src="" class="w-[20px] mr-[10px]">Operating Systems</a>
                    <a href="#" class="flex items-center text-[12px] font-medium text-[#888] my-[3px]"><img src="" class="w-[20px] mr-[10px]">Platform technologies</a>
                    <h3 class="text-[#777] text-[14px] font-medium my-[20px] mb-[10px]">GROUPS</h3>
                    <a href="#" class="flex items-center text-[12px] font-medium text-[#888] my-[3px]"><img src="" class="w-[20px] mr-[10px]">Data Analyst group</a>
                    <a href="#" class="flex items-center text-[12px] font-medium text-[#888] my-[3px]"><img src="" class="w-[20px] mr-[10px]">Learn NumPy</a>
                    <a href="#" class="flex items-center text-[12px] font-medium text-[#888] my-[3px]"><img src="" class="w-[20px] mr-[10px]">Machine Learning group</a>
                    <a href="#" class="flex items-center text-[12px] font-medium text-[#888] my-[3px]"><img src="" class="w-[20px] mr-[10px]">Data Science Aspirants</a> 
                    <h3 class="text-[#777] text-[14px] font-medium my-[20px] mb-[10px]">HASHTAG</h3>
                    <a href="#" class="flex items-center text-[12px] font-medium text-[#888] my-[3px]"><img src="" class="w-[20px] mr-[10px]">dataanalyst</a>
                    <a href="#" class="flex items-center text-[12px] font-medium text-[#888] my-[3px]"><img src="" class="w-[20px] mr-[10px]">numpy</a>
                    <a href="#" class="flex items-center text-[12px] font-medium text-[#888] my-[3px]"><img src="" class="w-[20px] mr-[10px]">machinelearning</a>
                    <a href="#" class="flex items-center text-[12px] font-medium text-[#888] my-[3px]"><img src="" class="w-[20px] mr-[10px]">datascience</a> 
                    <div class="border-t border-[#ccc] text-center mt-[20px] ml-[-25px] mr-[-25px]">
                        <a href="#" class="text-[#045be6] inline-block my-[10px]">Discover More</a>
                    </div>
                </SectionWrapper>
                    <p id="showMoreLink" onclick="">Show more <b>+</b></p>
                
            </div>
            <div class="flex-[0_0_47%]"> 
                <SectionWrapper>
                    <div class="flex items-start py-[20px] px-[25px] pt-[20px] pb-[10px]">
                        <img src="" class="w-[35px] rounded-full mr-[10px]">
                        <textarea rows="2" placeholder="Write Something" class="w-full border-0 outline-0 resize-none bg-transparent mt-[8px]"></textarea>
                    </div>
                    <div class="flex items-start">
                        <li class="list-none border-t border-r border-[#ccc] flex-[0_0_25%] h-[40px] text-[13px] flex items-center justify-center cursor-pointer"><img src="" class="w-[15px] mr-[5px]" >Photo</li>
                        <li class="list-none border-t border-r border-[#ccc] flex-[0_0_25%] h-[40px] text-[13px] flex items-center justify-center cursor-pointer"><img src="" class="w-[15px] mr-[5px]" >Video</li>
                        <li class="list-none border-t border-r border-[#ccc] flex-[0_0_25%] h-[40px] text-[13px] flex items-center justify-center cursor-pointer"><img src="" class="w-[15px] mr-[5px]" >Event</li>
                        <li class="list-none border-t border-r border-[#ccc] flex-[0_0_25%] h-[40px] text-[13px] flex items-center justify-center cursor-pointer">Post</li>
                    </div>
                </SectionWrapper>
                <div class="flex items-center my-[10px]">
                    <hr class="flex-1 border-0 h-[1px] bg-[#ccc]">
                    <p class="text-[13px] pl-[5px]">Sort by : <span class="font-semibold cursor-pointer">top <img src="" class="w-[12px] ml-[3px]" ></span> </p>

                </div>
                <div>
                    <SectionWrapper v-for="post in posts.data" :key="post.id" class="py-[20px] px-[25px] pb-[5px] my-[5px] mb-[15px]">
                       <PostPanel :post="post"/>
                    </SectionWrapper>
                </div>
            </div>
            <div class="basis-[25%] self-start sticky top-[73px]">
                <SectionWrapper class="p-[10px_25px]">
                    <img src="images/more.png" class="w-[15px] float-right mt-[15px]">
                    <h3 class="text-[18px] font-semibold text-[#333] mt-[10px] mb-[30px]">Trending News</h3>
                    <a href="#" class="block text-[12px] font-semibold mt-[10px] mb-[-5px]">High Demand for Skilled Employees</a>
                    <span class="text-[12px]">1d ago &middot; 10,934 readers</span>
                    <a href="#" class="block text-[12px] font-semibold mt-[10px] mb-[-5px]">Inflation in Canada Affects the Workforce</a>
                    <span class="text-[12px]">2d ago &middot; 7,043 readers</span>
                    <a href="#" class="block text-[12px] font-semibold mt-[10px] mb-[-5px]">Mass Recruiters fire Employees</a>
                    <span class="text-[12px]">4d ago &middot; 17,789 readers</span>
                    <a href="#" class="block text-[12px] font-semibold mt-[10px] mb-[-5px]">Crypto predicted to Boom this year</a>
                    <span class="text-[12px]">9d ago &middot; 2, 436 readers</span>
                    <a href="#" class="block text-[12px text-[#045be6] font-medium mt-[20px] mb-[10px]">Read More</a>
                </SectionWrapper>
                <SectionWrapper class="p-[15px_25px] text-center m-[12px_0] text-[12px]">
                    <small class="float-right font-medium">Ad &middot; &middot; &middot;</small>
                    <p class="mt-[30px] mb-[10px]">Master Web Development</p>
                    <div>
                        <img src="" class="w-[60px] rounded-full m-[4px]">
                        <img src="images/mi-logo.png" class="w-[60px] rounded-full m-[4px]">
                    </div>
                    <b class="block font-medium mt-[10px]">Brand and Demand in Xiaomi</b>
                    <a href="#" class="inline-block border border-[#045be6] rounded-[30px] p-[5px_15px] text-[#045be6] font-medium mt-[20px] mb-[10px] mx-auto">Learn More</a>
                </SectionWrapper>
                <div class="p-[15px_25px] text-center">
                    <a href="#" class="inline-block text-[14px] m-[4px_2px]">About</a>
                    <a href="#" class="inline-block text-[14px] m-[4px_2px]">Accessibility</a>
                    <a href="#" class="inline-block text-[14px] m-[4px_2px]">Help Center</a>
                    <a href="#" class="inline-block text-[14px] m-[4px_2px]">Privacy Policy</a>
                    <a href="#" class="inline-block text-[14px] m-[4px_2px]">Advertising</a>
                    <a href="#" class="inline-block text-[14px] m-[4px_2px]">Get the App</a>
                    <a href="#" class="inline-block text-[14px] m-[4px_2px]">More</a>
                    <div class="flex items-center justify-center text-[12px] mt-[10px] font-medium">
                        <img src="images/logo.png" class="w-[18px] mr-[4px]">
                        <p>Linkedin &#169; 2022. All Rights Reserved</p>
                    </div>
                </div>
            </div>
    </div>

    </AppLayout>
</template>

<script setup>
import PostPanel from '@/Components/PostPanel.vue';
import SectionWrapper from '@/Components/SectionWrapper.vue';
import AppLayout from '@/Layouts/AppLayout.vue';


const props = defineProps(['user', 'posts', 'title']);


</script>
