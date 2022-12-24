<template>
    <div class="rounded border dark:border-zinc-600 p-3">
        <div class="flex items-center mb-4">
            <router-link class="mr-3"
                :to="`/@${post.user.username}`">
                <img class="w-10 h-10 rounded-full" :src="post.user.gravatar" :alt="`Avatar of ${post.user.name}`">
            </router-link>
            <div class="text-sm">
                <router-link class="text-gray-900 dark:text-zinc-100 leading-none"
                    :to="`/@${post.user.username}`">
                    {{ post.user.name }}
                </router-link>
                <router-link class="block text-gray-500"
                    :to="`/posts/${post.id}`"
                    :title="fullDate">
                    {{ relativeDate }}
                </router-link>
            </div>
        </div>
        <div class="mb-2" v-text="post.content"></div>
    </div>
</template>

<script>
function prettyDate(date) {
    var diff = ((Date.now() - date.getTime()) / 1000),
        day_diff = Math.floor(diff / 86400);

    if (isNaN(day_diff) || day_diff < 0 || day_diff >= 31) {
        return date.toLocaleString();
    }

    return day_diff == 0 && (
            diff < 60 && 'just now' ||
            diff < 120 && '1 minute ago' ||
            diff < 3600 && Math.floor(diff / 60) + ' minutes ago' ||
            diff < 7200 && '1 hour ago' ||
            diff < 86400 && Math.floor(diff / 3600) + ' hours ago'
        ) ||
        day_diff == 1 && 'Yesterday' ||
        day_diff < 7 && day_diff + ' days ago' ||
        day_diff < 31 && Math.ceil(day_diff / 7) + ' weeks ago';
}

export default {
    props: {
        post: Object,
    },
    computed: {
        fullDate() {
            const date = new Date(this.$props.post.created_at);
            return date.toLocaleString();
        },
        relativeDate() {
            const date = new Date(this.$props.post.created_at);
            const diff = ((Date.now() - date.getTime()) / 1000);
            const dayDiff = Math.floor(diff / 86400);

            if (isNaN(dayDiff) || dayDiff < 0 || dayDiff >= 31) {
                return date.toLocaleString();
            }

            return dayDiff == 0 && (
                    diff < 60 && 'just now' ||
                    diff < 120 && '1 minute ago' ||
                    diff < 3600 && Math.floor(diff / 60) + ' minutes ago' ||
                    diff < 7200 && '1 hour ago' ||
                    diff < 86400 && Math.floor(diff / 3600) + ' hours ago'
                ) ||
                dayDiff == 1 && 'Yesterday' ||
                dayDiff < 7 && dayDiff + ' days ago' ||
                dayDiff < 31 && Math.ceil(dayDiff / 7) + ' weeks ago';
        },
    },
};
</script>
