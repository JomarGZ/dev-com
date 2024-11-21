<script setup>
import Icon from "@/Components/Icon.vue";

const props = defineProps({
    processing: Boolean,
    label: {
        type: String,
        default : 'Submit'
    }
});

</script>
<template>
    <button 
        :disabled="processing" 
        :type="$attrs.type || 'submit'" 
        :class="['px-3 py-1.5 text-white rounded-full hover:bg-blue-800 font-medium bg-blue-700', $attrs.class]"
    >
        <span v-if="processing">
            <Icon  name="white-spinner"/>
        </span>
        <span v-else>
            {{ label }}
        </span>
    </button>
</template>