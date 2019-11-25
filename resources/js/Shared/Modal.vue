<template>
    <div>
        <modal-component name="dialogModal" width="80%" :max-width="400"
                         :adaptive="true"
                         :delay="250"
                         height="auto"
                         class="text-center center"
                         @before-open="beforeOpenDialog($event)"
        >
            <dialog-modal :title="dialog.title" :text="dialog.text" :buttons="dialog.buttons" />
        </modal-component>

        <modal-component name="restaurantModal" width="80%" :max-width="400"
                         :adaptive="true"
                         :delay="250"
                         height="auto"
                         class="text-center center"
                         @before-open="beforeOpenRestaurant($event)"
                         @closed="closedRestaurant($event)"
        >
            <restaurant-modal :heading="restaurant.heading" :restaurants="restaurant.restaurants" :buttons="restaurant.buttons" />
        </modal-component>
    </div>
</template>

<script>
import DialogModal from '@/Modals/DialogModal';
import RestaurantModal from '@/Modals/RestaurantModal';

export default {
    components: {
        DialogModal,
        RestaurantModal,
    },
    data () {
        return {
            dialog: {
                title: null,
                text: null,
                buttons: [],
            },
            restaurant: {
                heading: null,
                restaurants: [],
                buttons: [],
            },
        }
    },
    methods: {
        beforeOpenDialog (event) {
            this.dialog.title = event.params.title;
            this.dialog.text = event.params.text;
            this.dialog.buttons = event.params.buttons;
        },
        beforeOpenRestaurant (event) {
            this.restaurant.heading = event.params.heading;
            this.restaurant.restaurants = event.params.restaurants;
            this.restaurant.buttons = event.params.buttons;
        },
        closedRestaurant (event) {
            this.$dispatch('restaurantModalClosed');
        },
    },
}
</script>
