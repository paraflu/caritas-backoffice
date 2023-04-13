/**
 * Gestione del tema corrente del browser
 * 
 */
import { ref } from "vue";

export function useThemeSwitcher() {
    const systemPrefered = ref<'dark' | 'light'>(window.matchMedia("(prefers-color-scheme: dark)").matches ? 'dark' : 'light');

    window
        .matchMedia("(prefers-color-scheme: dark)")
        .addEventListener("change", function (e) {
            systemPrefered.value = e.matches ? "dark" : "light";
            applyStyle();
        });

    const applyStyle = () => {
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && systemPrefered.value === 'dark')) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }

    return { systemPrefered, applyStyle }
}