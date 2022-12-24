<template>
    <button
        :class="cssClass"
        @click="$emit('click')"
        :disabled="disabled">
        <slot />
    </button>
</template>

<script>
export default {
    props: {
        primary: Boolean,
        sm: Boolean,
        lg: Boolean,
        disabled: Boolean,
    },
    computed: {
        cssClass() {
            return {
                'inline-flex items-center rounded-md border text-base leading-6 font-medium shadow-sm focus:outline-none focus:shadow-outline-blue transition ease-in-out duration-150': true,
                'border-gray-300 text-gray-700 bg-white hover:bg-blue-50 focus:border-blue-300 dark:shadow-none dark:bg-zinc-700 dark:hover:bg-zinc-600 dark:text-zinc-200 dark:hover:text-gray-100 dark:border-0': !this.$props.primary,
                'border-transparent text-white bg-blue-600 hover:bg-blue-500 focus:border-blue-700 active:bg-blue-700': this.$props.primary,
                'px-4 py-2 sm:text-sm sm:leading-5': !this.$props.lg,
                'px-8 py-3 md:py-4 md:px-10 md:text-lg': this.$props.lg,
            }
        },
    },
}
</script>
