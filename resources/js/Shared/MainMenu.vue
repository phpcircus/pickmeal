<template>
    <div :class="display">
        <div :class="margin">
            <inertia-link class="flex items-center group py-3" :href="route('home')">
                <icon-base classes="mr-2" :dynamic-classes="isPath('') ? 'fill-green-500' : 'fill-green-800 group-hover:fill-green-500'">
                    <home />
                </icon-base>
                <div class="text-xl" :class="isPath('') ? 'text-green-500' : 'text-green-700 group-hover:text-green-500'">
                    Home
                </div>
            </inertia-link>
        </div>
        <div>
            <inertia-link class="flex items-center py-3 group" :href="route('about')">
                <icon-base classes="mr-2" :dynamic-classes="isPath('about') ? 'fill-green-500' : 'fill-green-800 group-hover:fill-green-500'">
                    <store-front />
                </icon-base>
                <div class="text-xl" :class="isPath('about') ? 'text-green-500' : 'text-green-700 group-hover:text-green-500'">
                    About MealShot
                </div>
            </inertia-link>
        </div>
    </div>
</template>

<script>
import Home from '@/Shared/Icons/Home';
import IconBase from '@/Shared/IconBase';
import StoreFront from '@/Shared/Icons/StoreFront';

export default {
    components: {
        Home,
        IconBase,
        StoreFront,
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
