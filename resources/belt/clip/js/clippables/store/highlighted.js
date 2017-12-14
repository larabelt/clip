//import Table from 'belt/core/js/paramables/table';

export default {
    namespaced: true,
    state: {
        data: {},
    },
    mutations: {
        data: (state, value) => state.data = value,
        forget: (state, id) => Vue.delete(state.data, id),
        push: (state, attachment) => Vue.set(state.data, attachment.id, attachment),
    },
    actions: {
        data: (context, value) => context.commit('data', value),
        forget: (context, id) => context.commit('forget', id),
        push: (context, attachment) => context.commit('push', attachment),
        toggle: ({dispatch, commit, state}, attachment) => {
            if (state.data.hasOwnProperty(attachment.id)) {
                commit('forget', attachment.id);
            } else {
                commit('push', attachment);
            }
        },

    },
    getters: {
        data: state => state.data,
    }
}