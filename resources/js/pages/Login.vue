<template>
    <div class="container py-4 md:py-6 mb-8">
        <div class="max-w-md w-full mx-auto">
            <div>
                <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900 dark:text-zinc-300">
                    Sign in
                </h2>
                <p class="mt-2 text-center text-sm leading-5 text-gray-600 dark:text-zinc-400">
                    Or
                    <router-link to="/register" class="font-medium text-blue-600 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150 dark:text-blue-500 dark:hover:text-blue-400">
                        create an account
                    </router-link>
                </p>
            </div>
            <form class="mt-8" method="POST" @submit.prevent="logIn">
                <input type="hidden" name="remember" value="true">
                <input-text class="mb-4"
                    label="Email address"
                    type="email"
                    placeholder="Email address"
                    autocomplete="email"
                    required
                    v-model="email"
                    :error="emailError"
                    ref="email" />
                <input-text label="Password"
                    type="password"
                    placeholder="Password"
                    autocomplete="current-password"
                    required
                    v-model="password" />

                <div class="mt-6 flex items-center justify-between">
                    <button type="submit" class="group py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition duration-150 ease-in-out">
                        Sign in
                    </button>
                    <div class="text-sm leading-5">
                        <router-link to="/resetpassword" class="font-medium text-blue-600 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150 dark:text-blue-500 dark:hover:text-blue-400">
                            Forgot your password?
                        </router-link>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import InputText from '../components/InputText.vue';

export default {
    components: {
        InputText,
    },
    data: () => ({
        email: '',
        password: '',
        emailError: null,
    }),
    methods: {
        logIn() {
            this.emailError = null;
            axios.post('/api/login', {
                email: this.email,
                password: this.password,
            }).then(response => {
                const user = response.data;
                this.$store.commit('setUser', user);
                let to = '/';
                if (this.$route.query.redirect) {
                    to = this.$route.query.redirect;
                }
                this.$router.push(to);
            }).catch(error => {
                console.error(error);
                this.password = '';
                this.$refs.email.focus();
                if (error.response) {
                    const { data } = error.response;
                    this.emailError = data.errors.email[0];
                } else {
                    this.emailError = 'An unknown error occurred signing in. Please try again.';
                }
            });
        },
    },
    mounted() {
        this.$refs.email.focus();
        axios.get('/sanctum/csrf-cookie');
    },
}
</script>
