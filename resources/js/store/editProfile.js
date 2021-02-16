import { Inertia } from '@inertiajs/inertia';
export default {
    state: {
        default: {},
        form: {
            contactOptions: [],
        },
        languages: ['English', 'Spanish', 'Frensh', 'Russian', 'German', 'Arabic', 'Sanskrit'],
        permissions: ['Read', 'Write', 'Create', 'Delete'],
        roles: {
            user: {
                permissions: ['Read'],
            },
            subscriber: {
                permissions: ['Read', 'Write', 'Create', 'Delete'],
            },
        },
        gallery: {
            model: {
                show: false,
            },
            images: [],
            selectedImageIndex: null,
        },
    },
    getters: {
        getDefaultData(state) {
            return state.default;
        },
        getGallery({ gallery }) {
            return gallery;
        },
    },
    mutations: {
        setFormData(state, payload) {
            let data = state.form[payload.name];
            if (payload.name == 'contactOptions') {
                if (state.form[payload.name].length == 0) {
                    state.form[payload.name].push(payload.data[0]);
                } else {
                    if (!state.form[payload.name].find(item => payload.data[0] === item)) {
                        state.form[payload.name].push(payload.data[0]);
                    } else {
                        state.form[payload.name] = state.form[payload.name].filter(item => {
                            return item !== payload.data[0];
                        });
                    }
                }
                return;
            }
            state.form[payload.name] = payload.data;
        },
        setDefaultData(state, payload) {
            state.default = payload;
            if (payload) {
                state.form = { ...state.form, ...payload };
            }
        },
        hideGalleryModel({ gallery }) {
            this.commit('restGalleryValus');
            gallery.model.show = false;
        },
        restGalleryValus({ gallery }) {
            gallery.images = [];
            gallery.selectedImageIndex = null;
        },
        showGalleryModel({ gallery }, payload) {
            gallery.images = payload.imgs;
            gallery.selectedImageIndex = payload.index;
            gallery.model.show = true;
        },
    },
    actions: {
        async saveData({ state, rootState }) {
            let data = state.form;
            await Inertia.post('/profile', data, {
                preserveScroll: true,
            });
        },
    },
};
