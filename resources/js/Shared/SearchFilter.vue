<template>
    <div class="flex items-center">
        <div class="flex w-full bg-white shadow rounded">
            <dropdown class="px-4 md:px-6 rounded-l border-r hover:bg-gray-100 focus:border-white focus:z-10" width="100">
                <div slot="trigger" class="flex pt-3 items-center">
                    <span class="text-gray-900 inline-block">Filter</span>
                    <svg class="w-2 h-2 fill-gray-800 ml-2 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 961.243 599.998">
                        <path d="M239.998 239.999L0 0h961.243L721.246 240c-131.999 132-240.28 240-240.624 239.999-.345-.001-108.625-108.001-240.624-240z" />
                    </svg>
                </div>
                <div slot="dropdown" class="mt-2 px-4 py-6 ml-16 md:ml-0 w-screen shadow-lg bg-white rounded" :style="{ maxWidth: `${maxWidth}px` }">
                    <slot />
                </div>
            </dropdown>
            <input class="relative w-full px-6 py-3 rounded-r" autocomplete="off" type="text" name="search" placeholder="Search…" :value="value" @input="$emit('input', $event.target.value)">
        </div>
        <button class="ml-3 text-sm text-gray-700 hover:text-gray-800 focus:text-teal-500" type="button" @click="$emit('reset')">Reset</button>
    </div>
</template>

<script>
import Dropdown from '@/Shared/Dropdown';

export default {
    components: {
        Dropdown,
    },
    props: {
        value: String,
        maxWidth: {
            type: Number,
            default: 300,
        },
    },
}
</script>
