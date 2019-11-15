<template>
    <layout title="About Me">
        <h1 class="w-2/3 uppercase text-3xl font-bold text-green-800 pb-4 pt-4 mb-8">
            A little about me
        </h1>
        <div class="w-full md:w-1/2">
            <div class="flex flex-col justify-between">
                <span class="text-3xl text-gray-800 mb-8 font-bold">Clayton Stone</span>
                <div class="flex mb-4 items-center">
                    <h2 class="text-xl text-green-800 mr-2 uppercase font-medium">Years in web development:</h2>
                    <span class="text-xl text-green-600">14</span>
                </div>
                <div class="flex mb-4 items-center">
                    <h2 class="text-xl text-green-800 mr-2 uppercase font-medium">Started with:</h2>
                    <span class="text-xl text-green-600 font-medium">Coldfusion</span>
                </div>
                <div class="flex mb-8 items-center">
                    <h2 class="text-xl text-green-800 mr-2 uppercase font-medium">Current:</h2>
                    <span class="text-xl text-green-600 font-medium">PHP(Laravel), Javascript(Vue), Firebase</span>
                </div>
                <div class="flex mb-4 items-center">
                    <span class="text-xl text-green-800 font-medium leading-loose">
                        I've started this blog to track my experiences and to have a place to log what I'm learning. So this is more of a tool for me than anything else. However, maybe I'll write something that can be useful to others. Either way, I'm excited about what is to come.
                    </span>
                </div>
            </div>
        </div>
    </layout>
</template>

<script>
import Layout from '@/Shared/Layout';

export default {
    components: {
        Layout,
    },
}
</script>
