<template>
    <svg ref="svg" xmlns="http://www.w3.org/2000/svg" :class="appliedClasses" :width="width" :height="height" :viewBox="`0 0 ${view}`" :aria-labelledby="svgName" role="presentation">
        <title :id="svgName" lang="en">{{ svgName }}</title>
        <g><slot /></g>
    </svg>
</template>

<script>
export default {
    props: {
        svgName: {
            type: String,
            default: 'image',
        },
        width: {
            type: [Number, String],
            default: 18,
        },
        height: {
            type: [Number, String],
            default: 18,
        },
        classes: {
            type: String,
            default: '',
        },
        dynamicClasses: {
            type: String,
            default: '',
        },
        svgFill: {
            type: String,
            default: '',
        },
        view: {
            type: String,
            default: '500 500',
        },
    },
    computed: {
        appliedClasses () {
            var classes;
            if (this.classes) {
                classes = this.classes;
            }
            if (this.dynamicClasses) {
                classes = `${classes} ${this.dynamicClasses}`;
            }
            if (this.svgFill) {
                classes = `${classes} ${this.svgFill}`;
            }

            return classes ? classes : '';
        },
    },
}
</script>
