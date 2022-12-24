<template>
    <div class="container py-4 md:py-6 mb-8">
        <div class="max-w-md w-full mx-auto">
            <div>
                <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900 dark:text-zinc-300">
                    Create Account
                </h2>
                <p class="mt-2 text-center text-sm leading-5 text-gray-600 dark:text-zinc-400">
                    Or
                    <router-link to="/login" class="font-medium text-blue-600 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150 dark:text-blue-500 dark:hover:text-blue-400">
                        sign in
                    </router-link>
                </p>
            </div>
            <form class="mt-8" method="POST" @submit.prevent="logIn">
                <input type="hidden" name="remember" value="true">
                <input-text class="mb-4"
                    label="Display name"
                    type="text"
                    autocomplete="name"
                    required
                    v-model="name"
                    :error="nameError"
                    ref="name" />
                <input-text class="mb-4"
                    label="Username"
                    type="text"
                    autocomplete="username"
                    required
                    v-model="username"
                    :error="usernameError" />
                <input-text class="mb-4"
                    label="Email address"
                    type="email"
                    autocomplete="email"
                    required
                    v-model="email"
                    :error="emailError" />
                <input-text class="mb-4"
                    label="Password"
                    type="password"
                    autocomplete="new-password"
                    required
                    v-model="password"
                    :error="passwordError" />
                <input-text label="Confirm password"
                    type="password"
                    autocomplete="new-password"
                    required
                    v-model="passwordConfirmation" />

                <div class="mt-6 flex items-center justify-between">
                    <button type="submit" class="group py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition duration-150 ease-in-out">
                        Create Account
                    </button>
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
        name: '',
        nameError: '',
        username: '',
        usernameError: '',
        email: '',
        emailError: '',
        password: '',
        passwordError: '',
        passwordConfirmation: '',
    }),
    methods: {
        logIn() {
            this.nameError = '';
            this.usernameError = '';
            this.emailError = '';
            this.passwordError = '';

            axios.post('/api/register', {
                name: this.name,
                username: this.username,
                email: this.email,
                password: this.password,
                password_confirmation: this.passwordConfirmation,
            }).then(async response => {
                const user = response.data;
                this.$store.commit('setUser', user);
                let to = '/';
                if (this.$route.query.redirect) {
                    to = this.$route.query.redirect;
                }
                this.$router.push(to);
            }).catch(error => {
                console.error(error);
                this.$refs.email.focus();
                if (error.response) {
                    const { errors } = error.response.data;
                    this.nameError = errors.name ? errors.name[0] : null;
                    this.usernameError = errors.username ? errors.username[0] : null;
                    this.emailError = errors.email ? errors.email[0] : null;
                    this.passwordError = errors.password ? errors.password[0] : null;
                    if (this.passwordError) {
                        this.password = '';
                        this.passwordConfirmation = '';
                    }
                } else {
                    this.nameError = 'An unknown error occurred signing in. Please try again.';
                }
            });
        },
    },
    mounted() {
        this.$refs.name.focus();
        axios.get('/sanctum/csrf-cookie');
    },
}
</script>
