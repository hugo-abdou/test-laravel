import Vue from "vue";
import Vuex from "vuex";
import store from "@store";
import { App, plugin } from "@inertiajs/inertia-vue";
import { InertiaProgress } from "@inertiajs/progress";
//////////////////////////////////////////////////////////////////////////////////////////////////
import "./autoLoad.js"; // @import all components in component folder as __Global__ components
import "./filters/filters.js"; // add filters to the vue instens
import "./helpers.js"; // add Helpers to the vue instens
//////////////////////////////////////////////////////////////////////////////////////////////////
// init vue plugins
Vue.use(Vuex);
Vue.use(plugin);
InertiaProgress.init();

//////////////////////////////////////////////////////////////////////////////////////////////////
// init Vue Application
new Vue({
    store: new Vuex.Store(store),
    render: h =>
        h(App, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: name => {
                    return import(`@vue/Pages/${name}`).then(module => {
                        module.default.layout = (h, page) =>
                            h(require("@vue/Layouts/AppLayout").default, [page]);
                        return module.default;
                    });
                },
            },
        }),
}).$mount("#app");
//////////////////////////////////////////////////////////////////////////////////////////////////
