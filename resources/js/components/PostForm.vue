<template>
    <form method="POST" ref="form" @submit.prevent="submit">
        <div class="mb-3">
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
        <FormBtn type="submit" primary>
            Post
        </FormBtn>
    </form>
</template>

<script>
import FormBtn from '../components/FormBtn.vue';

export default {
    components: {
        FormBtn,
    },
    data: () => ({
        content: '',
    }),
    methods: {
        submit() {
            axios.post('/api/posts', {
                content: this.content,
            }).then(response => {
                // TODO: reload posts if on a relevant page
                this.$refs.form.reset();
                this.$emit('newPost', response.data);
            }).catch(error => {
                console.error(error);
            });
        },
    },
};
</script>
