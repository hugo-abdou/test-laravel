import axios from 'axios';
import { Inertia } from '@inertiajs/inertia';
export default {
    namespaced: true,
    state: {
        loadingPosts: false,
        fetshingData: false,
        posts: [],
        links: [],
    },
    getters: {
        getPosts({ posts }) {
            return posts;
        },
    },
    mutations: {
        setPosts(state, payload) {
            payload.data.map(item => {
                state.posts.push(item);
            });
            state.links = payload.links;
        },
        addMorePosts(state, payload) {
            payload.data.map(item => {
                let exist = false;
                state.posts.map(post => {
                    if (post.id == item.id) {
                        exist = true;
                    }
                });
                if (!exist) {
                    state.posts.push(item);
                }
            });
            state.links = payload.links;
            state.loadingPosts = false;
        },
        deletePost(state, payload) {
            state.posts.splice(payload, 1);
        },
    },
    actions: {
        loadeMorePosts({ state, rootState }) {
            let scrollPosition = Math.floor(
                document.documentElement.offsetHeight -
                    document.documentElement.scrollTop -
                    window.innerHeight
            );
            if (scrollPosition <= 500) {
                if (state.links.next && !state.fetshingData) {
                    state.fetshingData = true;
                    state.loadingPosts = true;
                    axios
                        .get(state.links.next)
                        .then(res => {
                            this.commit('profile/addMorePosts', res.data);
                            state.loadingPosts = false;
                            state.fetshingData = false;
                        })
                        .catch(err => {
                            console.log(err);
                        });
                }
            }
        },
        deletePost({ state }, { index }) {
            this.commit('deletePost', index);
        },
    },
};
