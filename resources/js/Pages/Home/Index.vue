<template>
    <layout title="Home">
        <div class="container mx-auto mt-24">
            <div class="flex">
                <div v-if="windowWidth > 1024" class="w-1/3 mr-8">
                    <svg-base view="440.72 405.56" svg-fill="fill-gray-500"
                              :width="windowWidth > 1294 ? 400 : 300"
                              :height="windowWidth > 1294 ? 400 : 300"
                    >
                        <family />
                    </svg-base>
                </div>
                <div :class="windowWidth > 1024 ? 'w-2/3' : 'w-full'">
                    <div class="flex flex-col w-full">
                        <h1 class="font-sigmar subpixel-antialiased text-6xl font-bold text-green-900 mx-auto mb-8">
                            Let Us Pick Your Meal!
                        </h1>
                        <div class="flex mb-4 w-full">
                            <label class="inline-flex items-center mr-4">
                                <input v-model="useLocation"
                                       type="radio"
                                       class="form-radio text-green-800"
                                       value="custom"
                                       :checked="useLocation === 'custom'"
                                >
                                <span class="text-green-800 font-semibold ml-1">Use custom location</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input v-model="useLocation"
                                       type="radio"
                                       class="form-radio text-green-800"
                                       value="current"
                                       :checked="useLocation === 'current'"
                                >
                                <span class="text-green-800 font-semibold ml-1">Use current location</span>
                            </label>
                        </div>
                        <p v-if="getLocationErrors() && useLocation === 'custom'" class="w-full md:w-1/2 text-red-500 text-sm font-semibold px-4 py-2 bg-red-200 text-red-800 rounded mb-6 leading-snug" v-html="getLocationErrors()" />
                        <autocomplete-address v-if="useLocation === 'custom'" label="Enter an address and search this area" @input="setCustomAddress" />
                        <p class="text-xl font-bold uppercase text-green-800 mt-8 mb-4">
                            Price Level
                        </p>
                        <div class="flex flex-col">
                            <div class="flex">
                                <label class="inline-flex items-center mr-4">
                                    <input v-model="price"
                                           type="radio"
                                           class="form-radio text-green-800"
                                           :value="1"
                                           :checked="price === 1"
                                    >
                                    <span class="text-green-800 font-semibold ml-1">Fast Food</span>
                                </label>
                                <label class="inline-flex items-center mr-4">
                                    <input v-model="price"
                                           type="radio"
                                           class="form-radio text-green-800"
                                           :value="2"
                                           :checked="price === 2"
                                    >
                                    <span class="text-green-800 font-semibold ml-1">Casual</span>
                                </label>
                                <label class="inline-flex items-center mr-4">
                                    <input v-model="price"
                                           type="radio"
                                           class="form-radio text-green-800"
                                           :value="3"
                                           :checked="price === 3"
                                    >
                                    <span class="text-green-800 font-semibold ml-1">Fine Dining</span>
                                </label>
                            </div>
                        </div>
                        <p class="text-xl font-bold uppercase text-green-800 mt-8 mb-4">
                            Search Radius
                        </p>
                        <div class="flex flex-col">
                            <div class="flex">
                                <select-input v-model="searchRadius" class="w-full lg:w-1/2" :errors="getErrors('searchRadius')">
                                    <option :key="2" :value="2" :selected="searchRadius === 2">
                                        2 Miles
                                    </option>
                                    <option :key="5" :value="5" :selected="searchRadius === 5">
                                        5 Miles
                                    </option>
                                    <option :key="10" :value="10" :selected="searchRadius === 10">
                                        10 Miles
                                    </option>
                                    <option :key="15" :value="15" :selected="searchRadius === 15">
                                        15 Miles
                                    </option>
                                    <option :key="20" :value="20" :selected="searchRadius === 20">
                                        20 Miles
                                    </option>
                                    <option :key="25" :value="25" :selected="searchRadius === 25">
                                        25 Miles
                                    </option>
                                </select-input>
                            </div>
                        </div>
                        <p class="text-xl font-bold uppercase text-green-800 mt-8 mb-4">
                            Maximum number of results
                        </p>
                        <div class="flex flex-col">
                            <div class="flex">
                                <select-input v-model="numberOfResults" class="mb-6 w-full lg:w-1/2" :errors="getErrors('numberOfResults')">
                                    <option :key="1" :value="1" :selected="numberOfResults === 1">
                                        1
                                    </option>
                                    <option :key="2" :value="2" :selected="numberOfResults === 2">
                                        2
                                    </option>
                                    <option :key="3" :value="3" :selected="numberOfResults === 3">
                                        3
                                    </option>
                                    <option :key="4" :value="4" :selected="numberOfResults === 4">
                                        4
                                    </option>
                                    <option :key="5" :value="5" :selected="numberOfResults === 5">
                                        5
                                    </option>
                                </select-input>
                            </div>
                        </div>
                        <loading-button class="bttn bttn-4 btn-sep items-center h-60p w-260p group ml-auto shadow-md" type="button" :loading="pickingMeal"
                                        @clicked="pickMeal()"
                        >
                            <icon-base icon-fill="fill-white" classes="mr-4 group-hover:fill-green-100">
                                <food />
                            </icon-base>
                            Pick Meal!
                        </loading-button>
                    </div>
                </div>
            </div>
        </div>
    </layout>
</template>

<script>
import Layout from '@/Shared/Layout';
import SvgBase from '@/Shared/SvgBase';
import Food from '@/Shared/Icons/Food';
import IconBase from '@/Shared/IconBase';
import Family from '@/Shared/SVG/Family';
import SelectInput from '@/Shared/SelectInput';
import LoadingButton from '@/Shared/LoadingButton';
import AutocompleteAddress from '@/Shared/AutocompleteAddress';

export default {
    components: {
        Food,
        Layout,
        SvgBase,
        Family,
        IconBase,
        SelectInput,
        LoadingButton,
        AutocompleteAddress,
    },
    data () {
        return {
            useLocation: 'custom',
            gettingLocation: false,
            searchRadius: 2,
            price: 1,
            customLocationAddress: null,
            customLocationId: null,
            pickingMeal: false,
            initialCurrentLocation: null,
            currentLocation: null,
            numberOfResults: 1,
        }
    },
    watch: {
        '$page.show_restaurant_modal': {
            handler (value) {
                if (value == true) {
                    this.$modal.show('restaurantModal', {
                        heading: `Your mealshot${this.numberOfResults > 1 ? 's' : ''} ${this.numberOfResults > 1 ? 'are' : 'is'}...`,
                        restaurants: this.$page.restaurants,
                        buttons: [
                            {
                                title: 'Pick again',
                                handler: () => this.pickAgain(),
                            },
                            {
                                title: 'Dismiss',
                                type: 'close',
                                handler: () => {
                                    this.$page.show_restaurant_modal = false;
                                },
                            },
                        ],
                    });
                } else {
                    this.$modal.hide('restaurantModal');
                    this.$page.restaurants = [];
                }
            },
        },
        useLocation: function (newValue, oldValue) {
            if (newValue === 'custom') {
                this.currentLocation = null;
            } else {
                this.customLocationAddress = null;
                this.customLocationId = null;
            }
        },
    },
    created () {
        this.$listen('locationSet', ({locationId, address}) => {
            this.customLocationAddress = address;
            this.customLocationId = locationId;
        });
    },
    methods: {
        async pickMeal (preserveState = true) {
            this.getCurrentLocation().then( () => {
                this.pickingMeal = true;
                if (this.useLocation === 'current') {
                    this.currentLocation = this.initialCurrentLocation;
                }
                this.$inertia.post(this.route('pick'), {
                    search: {
                        useLocation: this.useLocation,
                        customLocationId: this.customLocationId,
                        customLocationAddress: this.customLocationAddress,
                        currentLocation: this.currentLocation,
                        searchRadius: this.searchRadius,
                        price: this.price,
                        numberOfResults: this.numberOfResults,
                    },
                },{
                        preserveState: preserveState,
                        preserveScroll: true,
                }).then(() => this.pickingMeal = false);
            }).catch( () => {
                console.log('something went wrong');
            });
        },
        pickAgain () {
            this.$page.show_restaurant_modal = false;
            this.pickMeal();
        },
        getCurrentLocation () {
            return new Promise( (resolve, reject) => {
                if(! ('geolocation' in navigator)) {
                    this.$page.warning = 'Geolocation is not available.';

                    reject();
                }

                this.gettingLocation = true;

                navigator.geolocation.getCurrentPosition(pos => {
                    this.gettingLocation = false;

                    this.initialCurrentLocation = `${pos.coords.latitude}, ${pos.coords.longitude}`;
                    resolve();
                }, err => {
                    this.gettingLocation = false;
                    this.$page.warning = err.message;

                    reject();
                });
            });
        },
        getLocationErrors () {
            let custom = this.getErrors('customLocationId');
            let current = this.getErrors('currentLocation');

            if (custom && custom.length > 0) {
                return custom[0];
            }

            if (current && current.length > 0) {
                return current[0];
            }

            return '';
        },
        setCustomAddress (input) {
            if (this.customLocationId) {
                this.customLocationId = null;
            }

            this.customLocationAddress = input;
        },
    },
}
</script>
