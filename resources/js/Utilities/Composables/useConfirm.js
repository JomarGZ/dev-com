import { reactive, readonly } from "vue"

const globalState = reactive({
    show: false,
    title: '',
    message: ''
});


export function useConfirm() {
    const resetModal = () => {
        globalState.message = '';
        globalState.title = '';
        globalState.show = false;
        globalState.resolver = null;
    }
    return {
        state: readonly(globalState),
        confirmation: (message, title = 'Please Confirm') => {
            globalState.message = message;
            globalState.title = title;
            globalState.show = true;

            return new Promise((resolver) => {
                globalState.resolver = resolver;
            });
        },

        confirm: () => {
            if (globalState.resolver) { 
                globalState.resolver(true)
            }
            resetModal();
        },

        cancel: () => {
            if (globalState.resolver) {
                globalState.resolver(false)
            }
            resetModal();
        }
    };
}
