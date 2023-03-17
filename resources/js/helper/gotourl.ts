import { router } from '@inertiajs/vue3'

export const goto = (url: string) => router.visit(url);
