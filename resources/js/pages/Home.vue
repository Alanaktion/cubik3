<template>
    <div class="container py-4 md:py-6">
        <p class="text-lg">Hello, {{ user.name }}! 👋</p>
        <post-form class="mt-3"
            @newPost="addNewPost" />

        <div v-if="loading">
            <post-card-placeholder class="my-4 md:my-5 opacity-100" />
            <post-card-placeholder class="my-4 md:my-5 opacity-75" />
            <post-card-placeholder class="my-4 md:my-5 opacity-50" />
        </div>
        <div v-else>
            <post-card class="my-4 md:my-5"
                v-for="post in posts"
                :key="post.id"
                :post="post" />
        </div>
    </div>
</template>

<script>
import PostForm from '../components/PostForm.vue';
import PostCard from '../components/PostCard.vue';
import PostCardPlaceholder from '../components/PostCardPlaceholder.vue';

export default {
    components: {
        PostForm,
        PostCard,
        PostCardPlaceholder,
    },
    data: () => ({
        loading: false,
        posts: [],
        page: 0,
        lastPage: 0,
    }),
    computed: {
        user() {
            return this.$store.state.user || {};
        },
    },
    methods: {
        fetchPosts() {
            this.loading = true;
            axios.get('/api/posts')
                .then(response => {
                    const { data } = response;
                    this.posts = data.data;
                    this.page = data.page;
                    this.lastPage = data.last_page;
                    this.loading = false;
                })
                .catch(error => {
                    console.error(error);
                });
            // TODO: fetch more posts when scrolling
        },
        addNewPost(post) {
            this.posts.unshift(post);
        },
    },
    mounted() {
        this.fetchPosts();
    },
};
</script>
