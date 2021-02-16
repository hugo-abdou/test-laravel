import Vue from 'vue';
const files = require.context('./vue/components/global', true, /\.vue$/i);
files.keys().map(key => {
    let fileName = key
        .split('/')
        .pop()
        .split('.')[0];
    Vue.component(fileName, files(key).default);
});
