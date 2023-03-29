import { onMounted, ref } from "vue";

export function useCsrf() {
    const csrf = ref<string | null>(null);

    onMounted(() => {
        csrf.value = document.head.querySelector('meta[name="csrf-token"]')?.attributes['content'].value;

        if (!csrf.value) {
            console.warn('[useCsrf] impossibile recuperare il token')
        }

    })
    return { csrf }
}