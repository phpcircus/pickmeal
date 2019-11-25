<template>
    <div class="w-full relative">
        <text-input v-model="input" :errors="getErrors(field)" class="w-3/4 mt-px mr-4 mb-4"
                    placeholder="123 Easy St. Beverly Hills, CA 90210"
                    :label="label"
                    label-class="text-base text-green-800"
                    @input="handleInput()"
        />
        <div v-if="$page.autocomplete.length > 0" class="flex flex-col bg-white border border-gray-500 absolute top-16 w-3/4 p-2 mb-4 z-20">
            <div v-for="suggestion in $page.autocomplete" :key="suggestion.locationId" class="w-full mb-1 px-2 py-2 border-b border-gray-400 cursor-pointer last:mb-0 hover:bg-blue-500 group">
                <span class="block text-sm text-gray-700 font-semibold whitespace-no-wrap overflow-hidden group-hover:text-white" @click="setAddress(suggestion)">
                    {{ suggestion.address.houseNumber }} {{ suggestion.address.street }} {{ suggestion.address.city }}, {{ suggestion.address.state }} {{ suggestion.address.postalCode }}
                </span>
            </div>
        </div>
    </div>
</template>

<script>
import { debounce } from 'lodash';
import TextInput from '@/Shared/TextInput';

export default {
    components: {
        TextInput,
    },
    props: {
        field: {
            type: String,
            default: () => 'address',
        },
        label: {
            type: String,
            default: () => 'Address',
        },
    },
    data () {
        return {
            input: null,
            options: null,
            found: false,
        }
    },
    watch: {
        input: function (newInput, oldInput) {
            this.debounceAutosuggest();
        },
    },
    created () {
        this.debounceAutosuggest = debounce(this.callHereAutosuggest, 500);
    },
    methods: {
        handleInput () {
            this.found = false;
            this.$emit('input', this.input);
        },
        callHereAutosuggest () {
            if (! this.found) {
                this.$inertia.post(this.route('location.autocomplete'), { search: this.input });
            }
        },
        setAddress (suggestion) {
            this.input = `${suggestion.address.houseNumber} ${suggestion.address.street} ${suggestion.address.city}, ${suggestion.address.state} ${suggestion.address.postalCode}`;
            this.$page.autocomplete = [];
            this.found = true;

            this.$dispatch('locationSet', { locationId: suggestion.locationId, address: this.input });
        },
    },
}
</script>
