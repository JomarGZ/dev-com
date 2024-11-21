<script setup>
import Icon from '../Icon.vue';

const props = defineProps({
    show: Boolean
})
</script>
<template>
    
    <transition
        enter-from-class="opacity-0 scale-125"
        enter-to-class="opacity-100 scale-100"
        enter-active-class="transition duration-200"
        leave-active-class="transition duration-200"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-125"
    >
        <div v-if="show" class="fixed inset-0 z-50 bg-[rgb(0,0,0,.4)] grid place-items-center pt-16">
            <div class="bg-white rounded-xl w-[700px] max-w-[90%]">
                <!-- Header -->
                <header class="p-3 flex items-center gap-2">
                    <slot name="header"></slot>
                <button @click="$emit('close')" class="ml-auto p-2 hover:bg-gray-200 rounded-full">
                    <Icon name="x-close"/>
                </button>
                </header>
        
                <!-- Content -->
                <div class="px-3 pb-3">
                    <slot></slot>
                
                </div>
                <!-- Footer -->
                <footer class="p-3 flex items-center justify-between border-t">
                    <slot name="footer"></slot>
                </footer>
            </div>
        </div>
    </transition>
</template>