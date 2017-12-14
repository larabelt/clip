import Vue from 'vue';
import Vuex from 'vuex';

import Form from 'belt/clip/js/clippables/form';
import Table from 'belt/clip/js/clippables/table';
import clippable from 'belt/clip/js/clippables/store/clippable';
import highlighted from 'belt/clip/js/clippables/store/highlighted';

Vue.use(Vuex);

export default new Vuex.Store({
    namespaced: false,
    modules: {
        clippable,
        highlighted,
    },
});