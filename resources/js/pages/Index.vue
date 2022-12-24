<template>
    <div>
        <Home v-if="authenticated" />
        <div v-else class="text-center py-5 md:py-16 md:py-24 px-4">
            <h1 class="text-4xl font-extrabold tracking-tight text-blue-600 mb-4 md:mb-6 sm:text-5xl sm:leading-none md:text-6xl dark:text-blue-500">
                Welcome
            </h1>
            <p class="text-lg">Join the network to post, follow buddies, and find new ones!</p>
            <div class="mt-6 md:mt-8">
                <div class="mt-5 sm:mt-8 sm:flex sm:justify-center">
                    <div class="rounded-md shadow">
                        <router-link to="/register" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:shadow-outline transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                            Create Account
                        </router-link>
                    </div>
                    <div class="mt-3 sm:mt-0 sm:ml-3 rounded-md shadow">
                        <router-link to="/login" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-blue-700 bg-white hover:text-blue-600 hover:bg-blue-50 focus:outline-none focus:shadow-outline transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10 dark:bg-zinc-700 dark:hover:bg-zinc-600 dark:text-zinc-200 dark:hover:text-gray-100">
                            Sign in
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Home from './Home.vue';

export default {
    components: {
        Home,
    },
    computed: {
        authenticated() {
            return this.$store.state.user ? true : false;
        },
    },
};
</script>
