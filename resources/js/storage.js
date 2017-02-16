import fileIndex from './components/file/ctlr-index';
import fileCreate from './components/file/ctlr-create';
import fileEdit  from './components/file/ctlr-edit';
import store from 'belt/core/js/store/index';

export default class BeltStorage {

    constructor() {

        if ($('#belt-storage').length > 0) {

            const router = new VueRouter({
                mode: 'history',
                base: '/admin/belt/storage',
                routes: [
                    {path: '/files', component: fileIndex, canReuse: false, name: 'fileIndex'},
                    {path: '/files/create', component: fileCreate, name: 'fileCreate'},
                    {path: '/files/edit/:id', component: fileEdit, name: 'fileEdit'}
                ]
            });

            const app = new Vue({router, store}).$mount('#belt-storage');
        }
    }

}