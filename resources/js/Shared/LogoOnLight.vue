<template>
    <div class="w-full"
         :class="logoPosition"
    >
        <h1 class="inline-block font-bold text-XL lg:text-3xl text-green-800 tracking-wider">
            Meal
        </h1>
        <span class="inline-block font-normal text-XL lg:text-3xl text-green-500">
            SHOT
        </span>
    </div>
</template>

<script>
export default {
    props: {
        position: {
            type: String,
            default: 'center',
        },
    },
    computed: {
        logoPosition () {
            if (this.position === 'left') {
                return 'text-left';
            } else if (this.position === 'center') {
                return 'text-center mx-auto';
            } else {
                return 'text-right';
            }
        },
    },
}
</script>
