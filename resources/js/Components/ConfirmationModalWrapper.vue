<template>
    <ConfirmationModal :show="state.show">
        <template #title>
                {{ state.title }}
        </template>
        <template #content>
                {{ state.message }}
        </template>
        <template #footer>
                <SecondaryButton ref="cancelButtonRef" @click="cancel">Cancel</SecondaryButton>
                <PrimaryButton @click="confirm" class="ml-3">Confirm</PrimaryButton>
        </template>
    </ConfirmationModal>
</template>

<script setup>
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import { useConfirm } from '@/Utilities/Composables/useConfirm';
import { nextTick, ref, watchEffect } from 'vue';

const {state, confirm, cancel} = useConfirm();

const cancelButtonRef = ref(null);
watchEffect(async () => {
    if (state.show) {
        await nextTick();
        cancelButtonRef.value?.$el.focus();
    }
})
</script>