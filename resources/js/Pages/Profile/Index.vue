

<template>
   <AppLayout :title="title">
    <div class="flex justify-center items-center w-full box-border">
      <div class=" min-w-0 max-w-screen-xl flex justify-center mx-auto">
        <div class=" bg-white py-2.5 px-0 flex flex-col basis-1/4 h-fit rounded-lg">
          <div class=" mx-3">
            <h1 class="text-lg font-medium">Manage my network</h1>
          </div>
          <div class="-links border-b-2 border-gray-200 py-2 px-5">
            <ul class="list-none text-sm font-light">
              <li class="my-4">
                <a href="#" class="flex justify-between">
                  <span>Connections</span>
                  <span>1005</span>
                </a>
              </li>
              <li class="my-4">
                <a href="#" class="flex justify-between">
                  <span>Contacts</span>
                  <span>395</span>
                </a>
              </li>
              <li class="my-4">
                <a href="#" class="flex justify-between">
                  <span>Following and followers</span>
                  <span>1005</span>
                </a>
              </li>
              <li class="my-4">
                <a href="#" class="flex justify-between">
                  <span>Groups</span>
                  <span>8</span>
                </a>
              </li>
              <li class="my-4">
                <a href="#" class="flex justify-between">
                  <span>Events</span>
                  <span>4</span>
                </a>
              </li>
              <li class="my-4">
                <a href="#" class="flex justify-between">
                  <span>Pages</span>
                  <span>50</span>
                </a>
              </li>
              <li class="my-4">
                <a href="#" class="flex justify-between">
                  <span>Newsletters</span>
                  <span>10</span>
                </a>
              </li>
              <li class="my-4">
                <a href="#" class="flex justify-between">
                  <span>Hashtags</span>
                  <span>15</span>
                </a>
              </li>
            </ul>
          </div>
          <div class="footer text-gray-700 border-t-2 border-gray-200 text-center mt-2.5 text-xs py-4">
            <div class="useful-links space-y-2">
              <span>About</span>
              <span>Accessibility</span>
              <span>Help Center</span>
              <span>Privacy and Terms</span>
              <span>AD Choices</span>
              <span>Advertising</span>
              <span>Business services</span>
              <span>Get the LinkedIn app</span>
              <span>More</span>
            </div>
            <div class="footer-tag text-black text-sm font-extrabold">LinkedIn Corporation &copy; 2023</div>
          </div>
        </div>

        <div class="basis-7/10 ml-6">
          <div class="invitations bg-white rounded-lg p-4 mb-6">
            <div v-if="users">
                <div v-for="user in users.data" :key="user.id" class="flex justify-between mb-5">
                <div class="profile flex items-center">
                    <img src="https://picsum.photos/seed/picsum/60/60" class="w-15 h-15 mr-2.5" />
                    <div class="profile-user flex flex-col justify-center">
                    <h1 class="text-lg">
                        <Link :href="user.links.show">
                            {{ user.name }}
                        </Link>
                    </h1>
                    <h2 class="text-sm">Survey Researcher</h2>
                    </div>
                </div>
                <div v-if="! user.can.edit" class="response flex items-center gap-3">
                    <button type="button" class="accept bg-[#376cff] text-white py-1 px-5 rounded-full font-semibold">Accept</button>
                    <button type="button" class="reject bg-gray-200 text-black py-1 px-5 rounded-full font-semibold">Reject</button>
                </div>
                </div>
            </div>
            <div v-else class="my-3 text-center">
                <p class="text-center">Not found</p>
            </div>
          </div>
          <div class="ad bg-white rounded-lg p-5 mb-6">
            <h1 class="mb-3 text-lg">Achieve your goals faster with Premium</h1>
            <h2 class="text-md mb-5">See who's viewed your profile and directly message members outside of your network.</h2>
            <button class="bg-[#e9cb25] text-black font-semibold py-1 px-6 rounded-full text-sm">Try Premium for Free</button>
          </div>
        </div>
      </div>
    </div>
   </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps(['title', 'users']);
</script>