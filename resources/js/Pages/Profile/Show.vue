
<template>
   <AppLayout>
     
           <!-- Profile Header -->
     <!-- Profile Header -->
     <div class="flex flex-wrap mx-auto">
        <main class="w-[900px] pr-6 overflow-hidden">
            <div class="bg-white rounded-lg shadow">
                <div class="relative">
                    <img src="https://picsum.photos/seed/picsum/600/300" alt="Cover" class="w-full h-48 object-cover rounded-t-lg">
                    <div class="absolute top-4 right-4 bg-white rounded-full p-2">
                        <i class="fas fa-pen text-gray-600"></i>
                    </div>
                    <div class="absolute -bottom-16 left-4">
                        <img src="https://picsum.photos/seed/picsum/100/100" alt="Profile" class="w-32 h-32 rounded-full border-4 border-white">
                    </div>
                </div>
                <div class="pt-20 px-4 pb-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold">{{ props.user.name }}</h1>
                            <p class="text-gray-600">{{ props.user.profile.headline }}</p>
                            <p class="text-gray-500 text-sm mt-1">{{props.user.profile.address}}· <a href="#" class="text-blue-600">Contact info</a></p>
                            <p class="text-blue-600 mt-1">316 connections</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="bg-blue-600 text-white px-4 py-1 rounded-full">Open to</button>
                            <button class="border border-blue-600 text-blue-600 px-4 py-1 rounded-full">Add profile section</button>
                            <Link v-if="props.user.can.edit" :href="route('profile.edit')" class="border border-gray-300 text-gray-600 px-4 py-1 rounded-full">Edit</Link>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow mt-4 p-4">
                <h2 class="font-bold text-lg mb-2">Suggested for you</h2>
                <p class="text-gray-600 text-sm mb-4"><i class="fas fa-eye"></i> Private to you</p>
                <div class="flex items-center">
                    <div class="flex-grow">
                        <p class="font-semibold">Intermediate</p>
                        <div class="bg-gray-200 h-2 rounded-full mt-1">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 85%;"></div>
                        </div>
                    </div>
                    <p class="text-gray-600 ml-4">6/7</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow mt-4 p-4">
                <h2 class="font-bold text-lg mb-2">Suggested for you</h2>
                <p class="text-gray-600 text-sm mb-4"><i class="fas fa-eye"></i> Private to you</p>
                <div class="flex items-center">
                    <div class="flex-grow">
                        <p class="font-semibold">Intermediate</p>
                        <div class="bg-gray-200 h-2 rounded-full mt-1">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 85%;"></div>
                        </div>
                    </div>
                    <p class="text-gray-600 ml-4">6/7</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow mt-4 p-4">
                <h2 class="font-bold text-lg mb-2">Suggested for you</h2>
                <p class="text-gray-600 text-sm mb-4"><i class="fas fa-eye"></i> Private to you</p>
                <div class="flex items-center">
                    <div class="flex-grow">
                        <p class="font-semibold">Intermediate</p>
                        <div class="bg-gray-200 h-2 rounded-full mt-1">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 85%;"></div>
                        </div>
                    </div>
                    <p class="text-gray-600 ml-4">6/7</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow mt-4 p-4">
                <h2 class="font-bold text-lg mb-2">Suggested for you</h2>
                <p class="text-gray-600 text-sm mb-4"><i class="fas fa-eye"></i> Private to you</p>
                <div class="flex items-center">
                    <div class="flex-grow">
                        <p class="font-semibold">Intermediate</p>
                        <div class="bg-gray-200 h-2 rounded-full mt-1">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 85%;"></div>
                        </div>
                    </div>
                    <p class="text-gray-600 ml-4">6/7</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow mt-4 p-4">
                <h2 class="font-bold text-lg mb-2">Suggested for you</h2>
                <p class="text-gray-600 text-sm mb-4"><i class="fas fa-eye"></i> Private to you</p>
                <div class="flex items-center">
                    <div class="flex-grow">
                        <p class="font-semibold">Intermediate</p>
                        <div class="bg-gray-200 h-2 rounded-full mt-1">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 85%;"></div>
                        </div>
                    </div>
                    <p class="text-gray-600 ml-4">6/7</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow mt-4 p-4">
                <h2 class="font-bold text-lg mb-2">Suggested for you</h2>
                <p class="text-gray-600 text-sm mb-4"><i class="fas fa-eye"></i> Private to you</p>
                <div class="flex items-center">
                    <div class="flex-grow">
                        <p class="font-semibold">Intermediate</p>
                        <div class="bg-gray-200 h-2 rounded-full mt-1">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 85%;"></div>
                        </div>
                    </div>
                    <p class="text-gray-600 ml-4">6/7</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow mt-4 p-4">
                <h2 class="font-bold text-lg mb-2">Suggested for you</h2>
                <p class="text-gray-600 text-sm mb-4"><i class="fas fa-eye"></i> Private to you</p>
                <div class="flex items-center">
                    <div class="flex-grow">
                        <p class="font-semibold">Intermediate</p>
                        <div class="bg-gray-200 h-2 rounded-full mt-1">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 85%;"></div>
                        </div>
                    </div>
                    <p class="text-gray-600 ml-4">6/7</p>
                </div>
            </div>
        </main>

        <aside class="basis-[25%] self-start sticky top-[73px]">
            <div class="bg-white rounded-lg shadow p-4 mb-4">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="font-semibold">Profile language</h3>
                    <i class="fas fa-pen text-gray-600"></i>
                </div>
                <p class="text-gray-600">English</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4 mb-4">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="font-semibold">Public profile & URL</h3>
                    <i class="fas fa-pen text-gray-600"></i>
                </div>
                <p class="text-gray-600 text-sm">www.linkedin.com/in/jomar-godinez-4624a8263</p>
            </div>
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <img src="/api/placeholder/256/150" alt="Who's hiring" class="w-full h-32 object-cover">
                <div class="p-4">
                    <h3 class="font-semibold mb-2">See who's hiring on LinkedIn.</h3>
                    <a href="#" class="text-blue-600 text-sm">Find jobs</a>
                </div>
            </div>
        </aside>
    </div>
   </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps(['user']);
</script>
