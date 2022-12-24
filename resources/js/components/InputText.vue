<template>
    <div>
        <label class="block text-gray-700 dark:text-zinc-300 text-sm font-bold mb-2" :for="id">
            {{ label }}
        </label>
        <input class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded shadow-sm focus:outline-none focus:z-10 dark:bg-zinc-800 dark:text-zinc-100 dark:placeholder-gray-400"
            :class="{
                'border-red-500 focus:shadow-outline-red': error,
                'border-gray-300 dark:border-gray-600 focus:border-blue-300 focus:shadow-outline-blue': !error,
            }"
            :id="id"
            :type="type"
            required
            :placeholder="placeholder || label"
            :autocomplete="autocomplete"
            :value="value"
            @input="$emit('input', $event.target.value)"
            ref="input">
        <p class="text-red-500 text-sm mt-2" v-if="error">
            {{ error }}
        </p>
    </div>
</template>

<script>
export default {
    props: {
        value: String,
        label: String,
        placeholder: String,
        autocomplete: String,
        type: String,
        required: Boolean,
        error: String,
    },
    data: () => ({
        id: '',
    }),
    methods: {
        focus: function () {
            this.$refs.input.focus();
        },
    },
    beforeMount() {
        const randStr = Math.random()
            .toString()
            .replace(/[^\d]/g, '')
            .substring(0, 8);
        this.id = `input-${randStr}`;
    }
}
</script>
