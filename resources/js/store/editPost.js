import Tools from '@config/editorTools';
import { Inertia } from '@inertiajs/inertia';

export default {
    namespaced: true,
    state: () => ({
        tools: Tools,
        post: {},
    }),
    getters: {
        editorData({ post }) {
            if (Array.isArray(post.content)) return { blocks: post.content };
            else return post.content;
        },
    },
    mutations: {
        setDefaultData(state, payload) {
            state.post = {};
            state.post = payload.data;
        },
        changeStatus_vesibility(state, payload) {
            state.post = { ...state.post, ...payload };
        },
        toggleDisableComments(state, payload) {
            state.post.disable_comments = payload;
        },
    },
    actions: {
        save(store, { title, data }) {
            let post = {
                ...store.state.post,
                title: title,
                content: data,
            };
            Inertia.patch(post.update, post, {
                preserveScroll: true,
                preserveState: true,
            });
        },
    },
};
