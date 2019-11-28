<template>
    <div :class="display">
        <div :class="margin">
            <inertia-link class="flex items-center group py-3" :href="route('home')">
                <div class="font-sigmar subpixel-antialiased text-xl" :class="isPath('') ? 'text-teal-500' : 'text-teal-700 group-hover:text-teal-500'">
                    Home
                </div>
            </inertia-link>
        </div>
        <div>
            <inertia-link class="flex items-center py-3 group" :href="route('about')">
                <div class="font-sigmar subpixel-antialiased text-xl" :class="isPath('about') ? 'text-teal-500' : 'text-teal-700 group-hover:text-teal-500'">
                    About Us
                </div>
            </inertia-link>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        display: {
            type: String,
            default: 'block',
        },
    },
    computed: {
        margin () {
            if (this.display === 'block' || this.display === 'flex flex-col') {
                return 'mb-4';
            } else if (this.display === 'flex flex-row') {
                return 'mr-8';
            } else {
                return 'mb-4';
            }
        },
    },
}
</script>
