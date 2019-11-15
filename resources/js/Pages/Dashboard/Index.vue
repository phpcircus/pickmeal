<template>
    <layout title="Home">
        <div class="container mx-auto mt-12">
            <div class="flex mt-12">
                <div class="w-1/3 mt-12">
                    <svg-base view="440.72 405.56"
                              svg-fill="fill-gray-500"
                              :width="isMobileScreen ? 300 : 400"
                              :height="isMobileScreen ? 300 : 400"
                    >
                        <family />
                    </svg-base>
                </div>
                <div class="flex mt-12 w-1/3 mr-8">
                    <div class="flex flex-col w-full">
                        <h1 class="uppercase text-4xl font-bold text-green-800 pb-4 mb-8">Let us pick your meal!</h1>
                        <div class="flex mb-8 w-full">
                            <label class="inline-flex items-center mr-4">
                                <input v-model="useLocation"
                                       type="radio"
                                       class="form-radio text-green-500"
                                       value="current"
                                       :checked="useLocation === 'current'"
                                >
                                <span class="font-semibold ml-1">Use current location</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input v-model="useLocation"
                                       type="radio"
                                       class="form-radio text-green-500"
                                       value="custom"
                                       :checked="useLocation === 'custom'"
                                >
                                <span class="font-semibold ml-1">Use custom location</span>
                            </label>
                        </div>
                        <autocomplete-address v-if="useLocation === 'custom'"
                                              label="Enter an address and search this area"
                        />
                        <p class="text-xl font-bold uppercase text-green-800 mt-8 mb-4">
                            Price Level
                        </p>
                        <div class="flex flex-col">
                            <div class="flex">
                                <label class="inline-flex items-center mr-4">
                                    <input v-model="price"
                                           type="radio"
                                           class="form-radio text-green-500"
                                           value="1"
                                           :checked="price === 1"
                                    >
                                    <span class="font-semibold ml-1">$</span>
                                </label>
                                <label class="inline-flex items-center mr-4">
                                    <input v-model="price"
                                           type="radio"
                                           class="form-radio text-green-500"
                                           value="2"
                                           :checked="price === 2"
                                    >
                                    <span class="font-semibold ml-1">$$</span>
                                </label>
                                <label class="inline-flex items-center mr-4">
                                    <input v-model="price"
                                           type="radio"
                                           class="form-radio text-green-500"
                                           value="3"
                                           :checked="price === 3"
                                    >
                                    <span class="font-semibold ml-1">$$$</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input v-model="price"
                                           type="radio"
                                           class="form-radio text-green-500"
                                           value="4"
                                           :checked="price === 4"
                                    >
                                    <span class="font-semibold ml-1">$$$$</span>
                                </label>
                            </div>
                        </div>
                        <p class="text-xl font-bold uppercase text-green-800 mt-8 mb-4">
                            Search Radius
                        </p>
                        <div class="flex flex-col">
                            <div class="flex">
                                5 Miles
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex mt-24 w-1/3">
                    <button class="bttn bttn-4 btn-sep items-center h-60p w-280p group">
                        <icon-base icon-fill="fill-white"
                                   classes="mr-4 group-hover:fill-green-100"
                        >
                            <food />
                        </icon-base>
                        Pick Meal!
                    </button>
                </div>
            </div>
        </div>
    </layout>
</template>

<script>
import SvgBase from '@/Shared/SvgBase';
import IconBase from '@/Shared/IconBase';
import Layout from '@/Shared/Layout';
import Family from '@/Shared/SVG/Family';
import Food from '@/Shared/Icons/Food';
import AutocompleteAddress from '@/Shared/AutocompleteAddress';

export default {
    components: {
        Food,
        Layout,
        SvgBase,
        Family,
        IconBase,
        AutocompleteAddress,
    },
    data () {
        return {
            useLocation: 'current',
        }
    },
    location () {

    },
}
</script>
