<template>
    <div :class="display">
        <div :class="margin">
            <inertia-link class="flex items-center group py-3" :href="route('dashboard')">
                <icon-base classes="mr-2" :dynamic-classes="isPath('dashboard') ? 'fill-green-500' : 'fill-green-800 group-hover:fill-green-500'">
                    <home />
                </icon-base>
                <div :class="isPath('dashboard') ? 'text-green-500' : 'text-green-700 group-hover:text-green-500'" class="text-xl">Dashboard</div>
            </inertia-link>
        </div>
        <div>
            <inertia-link class="flex items-center py-3 group" :href="route('about')">
                <icon-base classes="mr-2" :dynamic-classes="isPath('about') ? 'fill-green-500' : 'fill-green-800 group-hover:fill-green-500'">
                    <user />
                </icon-base>
                <div :class="isPath('about') ? 'text-green-500' : 'text-green-700 group-hover:text-green-500'" class="text-xl">About Us</div>
            </inertia-link>
        </div>
    </div>
</template>

<script>
import User from '@/Shared/Icons/User';
import Home from '@/Shared/Icons/Home';
import IconBase from '@/Shared/IconBase';

export default {
    components: {
        User,
        Home,
        IconBase,
    },
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
