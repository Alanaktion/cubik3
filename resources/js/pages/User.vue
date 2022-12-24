<template>
    <div class="container py-4 md:py-6">
        <header class="flex mb-4 flex-col sm:flex-row sm:items-center" v-if="user">
            <div class="sm:text-right sm:flex-1 text-2xl md:text-3xl md:font-light">
                {{ user.name }}
            </div>
            <div class="w-32 sm:mx-6">
                <img class="w-full rounded-full"
                    :src="user.gravatar"
                    :alt="`Avatar of ${user.name}`">
            </div>
            <div class="sm:flex-1">
                <FormBtn v-if="me && me.id === user.id">
                    Edit Profile
                </FormBtn>
                <FormBtn v-else @click="toggleFollow(!following)">
                    <svg class="w-4 h-4 mr-2 stroke-current" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                        <path v-if="!following" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        <path v-else d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"/>
                    </svg>
                    {{ following ? 'Unfollow' : 'Follow' }}
                </FormBtn>
            </div>
        </header>
        <div v-else>
            An error occurred loading the user.
            <!-- TODO: make this message more specific to the error -->
        </div>
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
import FormBtn from '../components/FormBtn.vue';
import PostCard from '../components/PostCard.vue';
import PostCardPlaceholder from '../components/PostCardPlaceholder.vue';

export default {
    components: {
        FormBtn,
        PostCard,
        PostCardPlaceholder,
    },
    data: () => ({
        loading: true,
        user: null,
        posts: [],
        page: 0,
        lastPage: 0,
        following: false,
    }),
    beforeRouteEnter (to, from, next) {
        const username = to.params.user;
        axios.get(`/api/users/@${username}`)
            .then(response => {
                const { user, following } = response.data;
                next(vm => vm.setUser(user));
            })
            .catch(error => {
                // TODO: handle error state
                next();
            });
    },
    beforeRouteUpdate (to, from, next) {
        const username = to.params.user;
        axios.get(`/api/users/@${username}`)
            .then(response => {
                const user = response.data;
                this.setUser(user);
                next();
            })
            .catch(error => {
                // TODO: handle error state
                next();
            });
    },
    computed: {
        me() {
            return this.$store.state.user;
        },
    },
    methods: {
        setUser(user) {
            this.user = user;
        },
        async fetchPosts() {
            const username = this.$route.params.user;
            // TODO: handle errors loading posts
            const response = await axios.get(`/api/users/@${username}/posts`);
            const { data } = response;
            this.posts = data.data;
            this.page = data.page;
            this.lastPage = data.lastPage;
            this.loading = false;
            // TODO: support fetching paginated posts
        },
        async toggleFollow(value) {
            const username = this.$route.params.user;
            const action = value ? 'follow' : 'unfollow';
            axios.post(`/api/users/@${username}/${action}`)
                .then(response => {
                    this.following = response.data.following;
                })
                .catch(error => {
                    console.error(error);
                });
        },
    },
    watch: {
        '$route': 'fetchPosts',
    },
    created() {
        this.fetchPosts();
    },
}
</script>
