import { createI18n } from "vue-i18n"

const it = {}

export const initI18n = () => {
    return createI18n({
        locale: 'it',
        fallbackLocale: 'it',
        messages: { it }
    })
}
