<template>
    <li class="list-none flex items-center justify-between my-4">
        <inertia-link :href="follower.profileUrl" class="flex items-center">
            <img
                :src="follower.avatar"
                class="rounded-full border border-gray-400 h-8 w-8 shadow inline"
                alt
            />
            <div class="ml-2">
                <span class="block">{{ follower.name }}</span>
                <span class="text-xs">Company</span>
            </div>
        </inertia-link>
        <div v-if="follower.canFollow">
            <inertia-link
                method="put"
                :data="{ id: follower.id }"
                preserve-state
                preserve-scroll
                :only="['followers']"
                :href="follower.followUrl"
                class="border-2 shadow-md duration-150 ease-in-out focus:outline-none font-bold px-3 py-1 rounded-md text-white text-xs uppercase active:animate-ping"
                :class="
                    follower.authFollowThisUser
                        ? ' bg-white text-blue-600 border-blue-400 hover:bg-gray-300'
                        : ' bg-blue-500 text-white border-blue-600 hover:bg-blue-700'
                "
            >
                <i
                    class="feather text-lg ml-1"
                    :class="follower.authFollowThisUser ? ' icon-user-check ' : ' icon-user-plus '"
                ></i>
            </inertia-link>
        </div>
    </li>
</template>
<script>
export default {
    name: 'ModelInfo',
    props: ['follower'],
};
</script>
