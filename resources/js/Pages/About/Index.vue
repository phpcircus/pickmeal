<template>
    <layout title="About Me">
        <div class="container mx-auto mt-24">
            <div class="flex">
                <div class="w-full md:w-2/3 mr-8">
                    <div class="flex flex-col justify-between">
                        <h1 class="text-3xl text-white mb-8 font-bold">You make enough decisions. Let us pick your meal!</h1>
                        <div class="flex mb-4 items-center">
                            <span class="text-xl text-white font-medium leading-loose">
                                <p class="text-white text-lg mb-4">
                                    MealSHOT was developed with one simple idea in mind. We spend the majority of our day making decisions. When its time to eat, it's often not a simple choice. Fast-food, casual, fine dining, burgers, sandwiches, vegetarian, vegan, gluten free, how much to spend, etc., etc., etc. If you're with a group, it can be even more difficult.
                                </p>
                                <p class="font-sigmar subpixel-antialiased text-teal-200 text-3xl mb-4">
                                    We're here to make that choice a little easier.
                                </p>
                                <p class="text-white text-white text-2xl mb-4 leading-snug mb-4">
                                    First, set a few options like location, distance to travel, and meal type.
                                </p>
                                <p class="font-sigmar subpixel-antialiased text-teal-200 text-3xl">
                                    Click <span class="text-teal-900">"Pick Meal"</span> and enjoy your meal!
                                </p>
                            </span>
                        </div>
                    </div>
                </div>
                <svg-base view="440.72 405.56" svg-fill="fill-gray-500"
                          :width="windowWidth > 1294 ? 400 : 300"
                          :height="windowWidth > 1294 ? 400 : 300"
                >
                    <thinking />
                </svg-base>
            </div>
        </div>
    </layout>
</template>

<script>
import Layout from '@/Shared/Layout';
import SvgBase from '@/Shared/SvgBase';
import Thinking from '@/Shared/SVG/Thinking';

export default {
    components: {
        SvgBase,
        Layout,
        Thinking,
    },
}
</script>
