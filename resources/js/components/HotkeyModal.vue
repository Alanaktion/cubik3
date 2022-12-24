<template>
    <div class="fixed top-0 inset-x-0 px-4 py-4 sm:inset-0 sm:flex sm:items-center sm:justify-center" v-show="showRoot" @keyup.esc="close">
        <transition
            enter-active-class="ease-out duration-300"
            enter-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="ease-in duration-200"
            leave-class="opacity-100"
            leave-to-class="opacity-0">
            <div class="fixed inset-0 transition-opacity"
                v-show="show"
                @click="close">
                <div class="absolute inset-0 bg-gray-500 dark:bg-zinc-900 opacity-75"></div>
            </div>
        </transition>

        <transition
            enter-active-class="ease-out duration-300"
            enter-class="opacity-0 -translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to-class="opacity-100 translate-y-0 sm:scale-100"
            leave-active-class="ease-in duration-200"
            leave-class="opacity-100 translate-y-0 sm:scale-100"
            leave-to-class="opacity-0 -translate-y-4 sm:translate-y-0 sm:scale-95">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-sm sm:w-full dark:bg-zinc-800"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-headline"
                v-show="show">
                <div class="text-xl px-4 my-4 sm:px-6 text-gray-700 dark:text-zinc-300">Shortcut Keys</div>
                <dl>
                    <div class="flex items-center justify-between bg-gray-50 px-4 py-4 sm:px-6 dark:bg-zinc-900">
                        <dt class="text-sm leading-5 font-medium text-gray-600 dark:text-zinc-400">
                            Go home
                        </dt>
                        <dd>
                            <kbd class="border px-1 bg-white shadow rounded-sm dark:border-gray-600 dark:bg-zinc-850">g</kbd>
                            <kbd class="border px-1 bg-white shadow rounded-sm dark:border-gray-600 dark:bg-zinc-850">h</kbd>
                        </dd>
                    </div>
                    <div class="flex items-center justify-between bg-white px-4 py-4 sm:px-6 dark:bg-zinc-800">
                        <dt class="text-sm leading-5 font-medium text-gray-600 dark:text-zinc-400">
                            Go to your profile
                        </dt>
                        <dd>
                            <kbd class="border px-1 bg-white shadow rounded-sm dark:border-gray-600 dark:bg-zinc-850">g</kbd>
                            <kbd class="border px-1 bg-white shadow rounded-sm dark:border-gray-600 dark:bg-zinc-850">p</kbd>
                        </dd>
                    </div>
                    <div class="flex items-center justify-between bg-gray-50 px-4 py-4 sm:px-6 dark:bg-zinc-900">
                        <dt class="text-sm leading-5 font-medium text-gray-600 dark:text-zinc-400">
                            Write a post
                        </dt>
                        <dd>
                            <kbd class="border px-1 bg-white shadow rounded-sm dark:border-gray-600 dark:bg-zinc-850">n</kbd>
                        </dd>
                    </div>
                    <div class="flex items-center justify-between bg-white px-4 py-4 sm:px-6 dark:bg-zinc-800">
                        <dt class="text-sm leading-5 font-medium text-gray-600 dark:text-zinc-400">
                            Submit a post
                        </dt>
                        <dd>
                            <template v-if="macos">
                                <kbd class="border px-1 bg-white shadow rounded-sm dark:border-gray-600 dark:bg-zinc-850">⌘</kbd> +
                                <kbd class="border px-1 bg-white shadow rounded-sm dark:border-gray-600 dark:bg-zinc-850">↵</kbd>
                            </template>
                            <template v-else>
                                <kbd class="border px-1 bg-white shadow rounded-sm dark:border-gray-600 dark:bg-zinc-850">ctrl</kbd> +
                                <kbd class="border px-1 bg-white shadow rounded-sm dark:border-gray-600 dark:bg-zinc-850">enter</kbd>
                            </template>
                        </dd>
                    </div>
                    <div class="flex items-center justify-between bg-gray-50 px-4 py-4 sm:px-6 dark:bg-zinc-900">
                        <dt class="text-sm leading-5 font-medium text-gray-600 dark:text-zinc-400">
                            Open user menu
                        </dt>
                        <dd>
                            <kbd class="border px-1 bg-white shadow rounded-sm dark:border-gray-600 dark:bg-zinc-850">u</kbd>
                        </dd>
                    </div>
                    <div class="flex items-center justify-between bg-white px-4 py-4 sm:px-6 dark:bg-zinc-800">
                        <dt class="text-sm leading-5 font-medium text-gray-600 dark:text-zinc-400">
                            Open notifications
                        </dt>
                        <dd>
                            <kbd class="border px-1 bg-white shadow rounded-sm dark:border-gray-600 dark:bg-zinc-850">o</kbd>
                        </dd>
                    </div>
                </dl>
                <div class="bg-gray-50 px-4 py-3 flex justify-end sm:px-6 sm:pb-4 dark:bg-zinc-700 dark:bg-opacity-50">
                    <FormBtn type="button" @click="close">
                        Close
                    </FormBtn>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import FormBtn from '../components/FormBtn.vue';

export default {
    components: {
        FormBtn,
    },
    props: {
        show: Boolean,
    },
    data: () => ({
        showRoot: false,
        hideRootTimeout: null,
    }),
    computed: {
        macos() {
            return new Boolean(window.navigator.userAgent.match(/Mac OS/));
        },
    },
    watch: {
        show(show) {
            if (this.hideRootTimeout) {
                window.clearTimeout(this.hideRootTimeout);
            }
            if (show) {
                this.showRoot = true;
            } else {
                this.hideRootTimeout = window.setTimeout(() => {
                    this.showRoot = false;
                }, 300);
            }
        },
    },
    methods: {
        close() {
            this.$emit('update:show', false);
        },
    },
};
</script>
