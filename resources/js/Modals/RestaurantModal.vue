<template>
    <div class="flex flex-col">
        <div class="flex flex-col bg-purple-800 w-full text-center py-4">
            <template v-if="restaurantsFound">
                <h1 class="font-sigmar text-white text-2xl uppercase mb-4">{{ heading }}</h1>
                <div v-for="restaurant in restaurants" :key="restaurant.id" class="flex flex-col mb-4">
                    <a :href="restaurant.share" target="_blank" class="text-white text-2xl mb-2 underline hover:text-teal-300">{{ restaurant.title }}</a>
                    <p class="text-white text-sm" v-html="restaurant.address" />
                </div>
            </template>
            <template v-else class="mb-4">
                <p class="text-white text-xl px-2 mb-2">Sorry, no restaurants found.</p>
                <p class="text-teal-200 text-base px-2"> Try changing your options...</p>
            </template>
        </div>
        <div class="bg-white mx-8 my-4">
            <div class="w-full mb-12">
                <div class="flex justify-between px-4">
                    <button v-if="restaurantsFound" type="button" class="btn btn-text"
                            :class="buttonTextColor(buttons[0])"
                            @click="buttons[0].handler"
                    >
                        {{ buttons[0].title }}
                    </button>
                    <button type="button" class="btn btn-text" :class="buttonTextColor(buttons[1])"
                            @click="buttons[1].handler"
                    >
                        {{ buttons[1].title }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        heading: String,
        restaurants: Array,
        buttons: Array,
    },
    data () {
        return {
            sending: false,
        }
    },
    computed: {
        restaurantsFound () {
            return this.restaurants.length > 0
        },
    },
    created () {
        this.$listen('restaurantModalClosed', () => {
            this.$page.show_restaurant_modal = false;
        });
    },
    methods: {
        buttonTextColor (button) {
            if (button.type === 'delete') {
                return 'text-red-500';
            }
            if (button.type === 'create' || button.type === 'restore') {
                return 'text-teal-500'
            }
            if (button.type === 'info') {
                return 'text-teal-500'
            }
            if (button.type === 'close') {
                return 'text-gray-500'
            }
        },
    },
}
</script>
