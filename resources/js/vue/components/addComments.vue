<template>
    <div
        class="focus-within:shadow-outline-blue rounded-md overflow-hidden bg-gray-300  shadow-inner"
    >
        <input
            name="comment"
            v-model="comment"
            class="appearance-none px-3 py-2 bg-transparent  placeholder-gray-500 text-gray-900 focus:outline-none sm:text-sm sm:leading-5 min-w-11/12"
            placeholder="Add comment"
            @keypress.enter="submit"
        />
        <span
            class="text-gray-600 cursor-pointer transform rotate-90 text-xl inline-block"
            @click="submit"
        >
            <i
                v-show="comment.length"
                class="feather icon-navigation-2 block active:animate-bounce"
                :class="{ 'animate-bounce': submetComment }"
            ></i>
        </span>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
export default {
    props: ['post'],
    data() {
        return {
            submetComment: false,
            comment: '',
        };
    },
    methods: {
        submit() {
            if (this.comment.length) {
                Inertia.put(
                    this.$routes('post.comment', [this.post]),
                    { content: this.comment },
                    {
                        preserveState: true,
                        preserveScroll: true,
                        only: ['comment', this.post],
                        onStart: () => {
                            this.submetComment = true;
                        },
                        onSuccess: page => {
                            this.$emit('comment', page);
                            this.comment = '';
                        },
                        onFinish: () => {
                            this.submetComment = false;
                        },
                    }
                );
            }
        },
    },
};
</script>
