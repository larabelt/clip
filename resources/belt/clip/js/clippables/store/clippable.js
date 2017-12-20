import Form from 'belt/clip/js/clippables/form';
import Table from 'belt/clip/js/clippables/table';

export default {
    namespaced: true,
    state: {
        active: new Form(),
        attached: [],
        mode: 'list',
        morphableID: '',
        morphableType: '',
        table: new Table(),
    },
    mutations: {
        active: (state, active) => state.active = active,
        attached: (state, attached) => state.attached = attached,
        mode: (state, mode) => state.mode = mode,
        morphableID: (state, morphableID) => state.morphableID = morphableID,
        morphableType: (state, morphableType) => state.morphableType = morphableType,
        table: (state, table) => state.table = table,
    },
    actions: {
        active: ({commit, state}, attachment) => {
            let form = new Form({morphable_type: state.morphableType, morphable_id: state.morphableID});
            form.setData(attachment);
            commit('active', form);
        },
        attach: ({commit, state}, attachment) => {

            let form = new Form({morphable_type: state.morphableType, morphable_id: state.morphableID});
            form.setData({id: attachment.id});

            return new Promise((resolve, reject) => {
                form.store()
                    .then(response => {
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });

        },
        attached: (context, attached) => context.commit('attached', attached),
        construct: ({commit, state}, attachment) => {
            let table = new Table({morphable_type: state.morphableType, morphable_id: state.morphableID});
            commit('table', table);
        },
        detach: ({commit, state}, id) => {

            let form = new Form({morphable_type: state.morphableType, morphable_id: state.morphableID});

            return new Promise((resolve, reject) => {
                form.destroy(id)
                    .then(response => {
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        load: ({commit, state}) => {

            /**
             * Just get attachment ids for convenience
             */
            commit('attached', []);
            let table = new Table({morphable_type: state.morphableType, morphable_id: state.morphableID});
            table.query.fields = 'attachment_id';
            table.index()
                .then((response) => {
                    commit('attached', response);
                });

            return new Promise((resolve, reject) => {
                state.table.index()
                    .then(response => {
                        //commit('data', response.data);
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        move: ({commit, state}, params) => {

            let form = new Form({morphable_type: state.morphableType, morphable_id: state.morphableID});

            form.setData({
                id: state.active.id,
                move: params.type,
                position_entity_id: params.target.id
            });

            return new Promise((resolve, reject) => {
                form.submit()
                    .then(response => {
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        set: (context, options) => {
            if (options.mode) {
                context.commit('mode', options.mode);
            }
            if (options.morphableType) {
                context.commit('morphableType', options.morphableType);
            }
            if (options.morphableID) {
                context.commit('morphableID', options.morphableID);
            }
        },
    },
    getters: {
        active: state => state.active,
        attached: state => state.attached,
        mode: state => state.mode,
        morphableID: state => state.morphableID,
        morphableType: state => state.morphableType,
        table: state => state.table,
    }
};