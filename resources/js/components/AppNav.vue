<template>
    <div>
        <nav class="sticky top-0 bg-gray-800 dark:bg-zinc-800">
            <div class="container">
                <div class="relative flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <router-link to="/" class="flex-shrink-0 text-gray-300 px-2" aria-label="Go home">
                            <img class="h-8 w-auto" :src="logo" alt />
                        </router-link>
                    </div>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0"
                        v-if="user">
                        <FormBtn primary class="mr-4"
                            aria-label="Write a new post"
                            title="New Post"
                            @click="postModalOpen = true">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                            </svg>
                        </FormBtn>

                        <button class="p-1 border-2 border-transparent text-gray-400 rounded-full hover:text-white focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out"
                            id="notification-menu"
                            aria-label="Notifications"
                            aria-haspopup="true"
                            @click="notificationsOpen = !notificationsOpen">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </button>

                        <!-- Profile dropdown -->
                        <div class="ml-3 relative">
                            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-white transition duration-150 ease-in-out"
                                id="user-menu"
                                aria-label="User menu"
                                aria-haspopup="true"
                                @click="userOpen = !userOpen">
                                <img class="h-8 w-8 rounded-full" :src="user.gravatar" :alt="`Avatar of ${user.name}`" />
                            </button>
                        </div>
                    </div>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0"
                        v-else>
                        <router-link to="/login" class="px-3 py-2 rounded-md text-sm font-medium leading-5 text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out dark:hover:bg-zinc-700 dark:focus:bg-zinc-700">
                            Sign in
                        </router-link>
                        <router-link to="/register" class="px-3 py-2 ml-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition duration-150 ease-in-out">
                            Create Account
                        </router-link>
                    </div>
                </div>
            </div>
        </nav>
        <div class="absolute inset-0"
            @click="userOpen = false; notificationsOpen = false"
            v-show="userOpen || notificationsOpen"
            v-if="user"
        ></div>
        <div class="container relative"
            v-if="user">
            <transition
                enter-active-class="transition ease-out duration-100"
                enter-class="opacity-0 scale-95"
                enter-to-class="opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-class="opacity-100 scale-100"
                leave-to-class="opacity-0 scale-95">
                <div v-show="userOpen" class="origin-top-right absolute right-0 -mt-2 mr-3 w-48 rounded-md shadow-lg z-10">
                    <div class="py-1 rounded-md bg-white shadow-xs dark:bg-zinc-700" role="menu" aria-orientation="vertical" aria-labelledby="user-menu" @click="userOpen = false">
                        <router-link :to="`/@${user.username}`" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out dark:text-zinc-100 dark:hover:bg-zinc-600 dark:focus:bg-gray-600 dark:hover:text-white">
                            Your Profile
                        </router-link>
                        <router-link to="/settings" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out dark:text-zinc-100 dark:hover:bg-zinc-600 dark:focus:bg-gray-600 dark:hover:text-white">
                            Settings
                        </router-link>
                        <button class="block w-full text-left px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out dark:text-zinc-100 dark:hover:bg-zinc-600 dark:focus:bg-gray-600 dark:hover:text-white"
                            @click="logOut">
                            Sign out
                        </button>
                    </div>
                </div>
            </transition>
            <transition
                enter-active-class="transition ease-out duration-100"
                enter-class="opacity-0 scale-95"
                enter-to-class="opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-class="opacity-100 scale-100"
                leave-to-class="opacity-0 scale-95">
                <div v-show="notificationsOpen" class="origin-top absolute right-0 -mt-2 mr-3 sm:mr-0 w-48 rounded-md shadow-lg z-10">
                    <div class="py-1 rounded-md bg-white shadow-xs dark:bg-zinc-700 h-48 flex flex-col overflow-y-auto"
                        role="menu"
                        aria-orientation="vertical"
                        aria-labelledby="notification-menu"
                        @click="userOpen = false">
                        <div v-if="notificationsLoading" class="text-center pt-20 text-gray-600 dark:text-zinc-400">
                            Just a sec&hellip;
                        </div>
                        <div v-else-if="notifications.length">
                            <div v-for="notif in notifications" :key="notif.id"
                                class="py-2 px-4">
                                <!-- TODO: show notification detail -->
                                <code>{{ notif.type }}</code>
                            </div>
                        </div>
                        <div v-else class="text-center pt-20 text-gray-600 dark:text-zinc-400">
                            You're all caught up!
                        </div>
                    </div>
                </div>
            </transition>
        </div>
        <post-modal v-if="user" :show.sync="postModalOpen" dismissable />
        <hotkey-modal :show.sync="hotkeyModalOpen" />
    </div>
</template>

<script>
import Mousetrap from 'mousetrap';
import FormBtn from '../components/FormBtn.vue';
import PostModal from '../components/PostModal.vue';
import HotkeyModal from '../components/HotkeyModal.vue';

export default {
    components: {
        FormBtn,
        PostModal,
        HotkeyModal,
    },
    props: {
        logo: String,
    },
    data: () => ({
        userOpen: false,
        postModalOpen: false,
        notificationsOpen: false,
        notifications: [],
        notificationsLoading: true,
        hotkeyModalOpen: false,
    }),
    computed: {
        user() {
            return this.$store.state.user;
        },
    },
    watch: {
        notificationsOpen(open) {
            if (open) {
                this.loadNotifications();
            }
        },
    },
    methods: {
        async logOut() {
            await axios.post('/api/logout');
            this.$store.commit('setUser', null);
            this.$router.push('/');
            await axios.get('/sanctum/csrf-cookie');
        },
        async loadNotifications() {
            const { data } = await axios.get('/api/notifications');
            this.notifications = data.data;
            this.notificationsLoading = false;
        },
    },
    mounted() {
        // Bind global hotkeys
        Mousetrap.bind('esc', () => {
            this.userOpen = false;
            this.postModalOpen = false;
            this.notificationsOpen = false;
            this.hotkeyModalOpen = false;
        });

        // Modals
        Mousetrap.bind('?', () => {
            this.hotkeyModalOpen = !this.hotkeyModalOpen;
        });
        Mousetrap.bind('n', (e) => {
            this.postModalOpen = true;
            e.preventDefault();
        });

        // Menus
        Mousetrap.bind('o', () => {
            this.notificationsOpen = !this.notificationsOpen;
        });
        Mousetrap.bind('u', (e) => {
            this.userOpen = true;
            e.preventDefault();
        });

        // Navigation
        Mousetrap.bind('g h', () => {
            this.$router.push('/');
        });
        Mousetrap.bind('g p', () => {
            if (this.user) {
                this.$router.push(`/@${this.user.username}`);
            }
        });
    },
};
</script>
