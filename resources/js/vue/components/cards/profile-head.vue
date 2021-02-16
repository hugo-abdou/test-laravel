<template>
    <div class="w-full h-96 relative rounded-lg shadow overflow-hidden">
        <div
            class="w-full h-full overflow-hidden"
            @mouseenter="showEditCover = true"
            @mouseleave="showEditCover = false"
        >
            <img
                :src="cover.url ? cover.url : '../../../images/profile/post-media/2.jpg'"
                class="object-cover h-full w-full"
            />
            <div class="absolute w-full h-full top-0 bg-gray-900 bg-opacity-25"></div>
            <div class="absolute w-full h-full top-0 bg-white bg-opacity-50" v-show="cover.onload">
                <i
                    class="feather icon-refresh-cw text-2xl text-center block mt-32 text-gray-700 font-semibold"
                    :class="{ 'animate-spin': cover.onload }"
                ></i>
            </div>
            <button
                v-if="$page.props.auth.id == user.id"
                @click="$refs.cover.click()"
                v-show="showEditCover"
                type="button"
                class="absolute right-5 top-5 p-3 focus:outline-none bg-gray-800 bg-opacity-50  hover:bg-opacity-100 border border-gray-700 rounded-full font-semibold text-gray-400 transition ease-in-out duration-150 active:animate-ping"
            >
                <i class="feather icon-edit text-lg"></i>
            </button>
            <inertia-link
                v-if="$page.props.auth.id !== user.id"
                method="put"
                :data="{ id: user.id }"
                preserve-state
                preserve-scroll
                :only="['authFollowCurrentUser', 'followers']"
                :href="$routes('profile.follow', [user.slug])"
                class="absolute bottom-5 right-6 border-2 shadow-md duration-150 ease-in-out focus:outline-none font-bold px-3 py-1 rounded-md text-white text-xs uppercase active:animate-ping"
                :class="
                    follow
                        ? ' bg-white text-blue-600 border-blue-400 hover:bg-gray-300'
                        : ' bg-blue-500 text-white border-blue-600 hover:bg-blue-700'
                "
            >
                <span>follow</span>
                <i
                    class="feather text-lg ml-1"
                    :class="follow ? ' icon-user-check ' : ' icon-user-plus '"
                ></i>
            </inertia-link>
            <input type="file" class="hidden" ref="cover" @change="onEditCover" />
            <div
                class="absolute bottom-6 left-4 flex items-center justify-between"
                @mouseenter="editAvatarShow = true"
                @mouseleave="editAvatarShow = false"
            >
                <div
                    class="relative rounded-full w-28 h-28 shadow border border-white overflow-hidden"
                >
                    <img
                        :src="
                            avatar.url
                                ? avatar.url
                                : '../../../images/profile/user-uploads/user-01.jpg'
                        "
                        class="object-cover h-28 w-full"
                        alt="avatar"
                    />

                    <button
                        v-if="$page.props.auth.id == user.id"
                        v-show="editAvatarShow"
                        @click="$refs.avatar.click()"
                        type="button"
                        class="absolute bottom-0 w-full p-1 focus:outline-none bg-gray-800 bg-opacity-50  hover:bg-opacity-100 border border-gray-700  font-semibold text-gray-400 transition ease-in-out duration-150 active:animate-ping"
                    >
                        <i class="feather icon-camera text-lg"></i>
                    </button>

                    <div
                        class="absolute w-full h-full top-0 bg-white bg-opacity-50"
                        v-show="avatar.onload"
                    >
                        <i
                            class="feather icon-refresh-cw text-2xl text-center w-full block mt-10 text-gray-700 font-semibold"
                            :class="{ 'animate-spin': avatar.onload }"
                        ></i>
                    </div>
                    <input type="file" class="hidden" ref="avatar" @change="onEditAvatar" />
                </div>
                <h1
                    class="ml-4 text-4xl font-bold text-gray-100"
                    style="text-shadow: 1px 3px 0 rgba(0, 0, 0, 0.1), 1px 2px 0 rgba(0, 0, 0, 0.06);"
                    v-text="user.name"
                ></h1>
            </div>
        </div>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
export default {
    props: ['profileImages', 'user', 'follow'],
    data() {
        return {
            editAvatarShow: false,
            showEditCover: false,
            cover: {
                url: null,
                onload: false,
            },
            avatar: {
                url: null,
                onload: false,
            },
        };
    },
    mounted() {
        if (this.profileImages) {
            if (this.profileImages['avatar']) {
                this.avatar.url = this.profileImages['avatar'];
            }
            if (this.profileImages['cover']) {
                this.cover.url = this.profileImages['cover'];
            }
        }
    },
    methods: {
        onEditCover(e) {
            this.sendFormData(e, 'cover');
        },
        onEditAvatar(e) {
            this.sendFormData(e, 'avatar');
        },
        sendFormData(e, name) {
            const form = new FormData();
            const image = e.target.files[0];

            form.append(name, image, image.name);

            Inertia.post(this.$routes('media.update'), form, {
                preserveScroll: true,
                preserveState: true,
                onStart: () => {
                    this[name].onload = true;
                },
            }).then(() => {
                this.renderImageData(e, name);
                this[name].onload = false;
            });
        },
        renderImageData(e, element) {
            const reader = new FileReader();
            const image = e.target.files[0];

            reader.readAsDataURL(image);

            reader.onload = e => {
                this[element].url = e.target.result;
            };
        },
    },
};
</script>
