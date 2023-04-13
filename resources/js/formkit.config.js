import { generateClasses } from "@formkit/themes";

export default {
    config: {
        classes: generateClasses({
            global: {
                outer: "mb-4",
                input: "border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full",
                button: "btn",
                label: 'block font-medium text-sm text-gray-700 dark:text-gray-500',
                messages: 'list-none p-0 mt-1 mb-0',
                message: 'text-red-500 mb-1 text-sm my-2',
            },
            submit: {
                input: "$reset btn"
            },
        }),
    }
}