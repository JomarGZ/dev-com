<script setup>
import Icon from "@/Components/Icon.vue";

const props = defineProps({
    processing: Boolean,
    label: {
        type: String,
        default : 'Submit'
    }
});

const getProcessingLabal = (label) => {
    if (label.toLowerCase() === 'submit') {
        return 'Submitting';
    } 
    return `${props.label}ing`;
};
</script>
<template>
    <button 
        :disabled="processing" 
        :type="$attrs.type || 'submit'" 
        :class="['px-4 py-1.5 text-white rounded-full font-medium bg-blue-700', $attrs.class]"
    >
        <Icon v-if="processing" name="white-spinner"/>
        <span>
            {{ processing ? getProcessingLabal(label) : label }}
        </span>
    </button>
</template>