<template>
    <div class="fixed top-0 inset-x-0 px-4 py-4 sm:inset-0 sm:flex sm:items-center sm:justify-center" v-show="showRoot" @keyup.esc="overlayClick">
        <transition
            enter-active-class="ease-out duration-300"
            enter-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="ease-in duration-200"
            leave-class="opacity-100"
            leave-to-class="opacity-0">
            <div class="fixed inset-0 transition-opacity"
                v-show="show"
                @click="overlayClick">
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
            <form class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full dark:bg-zinc-800"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-headline"
                v-show="show"
                ref="form"
                @submit.prevent="submit">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-start">
                        <img class="hidden sm:block w-10 h-10 rounded-full mr-3" :src="user.gravatar" :alt="`Avatar of ${user.name}`">
                        <textarea class="appearance-none block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 dark:bg-zinc-850 dark:text-zinc-100 dark:border-zinc-600 dark:placeholder-gray-400"
                            aria-label="Write a post"
                            name="content"
                            id="content"
                            rows="2"
                            required
                            ref="content"
                            v-model="content"
                            placeholder="What's up?"
                            @keyup.ctrl.enter.prevent="submit"
                            @keyup.meta.enter.prevent="submit"
                        ></textarea>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 flex flex-row-reverse sm:px-6 sm:pb-4 dark:bg-zinc-700 dark:bg-opacity-50">
                    <FormBtn class="ml-3" type="submit" primary>
                        Post
                    </FormBtn>
                    <FormBtn type="button" @click="close">
                        Cancel
                    </FormBtn>
                </div>
            </form>
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
        dismissable: Boolean,
    },
    data: () => ({
        showRoot: false,
        hideRootTimeout: null,
        content: '',
    }),
    computed: {
        user() {
            return this.$store.state.user;
        },
    },
    watch: {
        show(show) {
            if (this.hideRootTimeout) {
                window.clearTimeout(this.hideRootTimeout);
            }
            if (show) {
                this.showRoot = true;
                this.$nextTick(() => {
                    this.$refs.content.focus();
                })
            } else {
                this.$refs.content.blur();
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
        overlayClick() {
            if (this.$props.dismissable) {
                this.close();
            }
        },
        submit() {
            axios.post('/api/posts', {
                content: this.content,
            }).then(response => {
                // TODO: reload posts if on a relevant page
                this.$refs.form.reset();
                this.$emit('newPost', response.data);
                this.close();
            }).catch(error => {
                console.error(error);
            });
        },
    },
};
</script>
