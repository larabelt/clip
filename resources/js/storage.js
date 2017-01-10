import fileIndex from './components/file/ctlr-index';
import fileCreate from './components/file/ctlr-create';
import fileEdit  from './components/file/ctlr-edit';

export default class OhioStorage {

    constructor() {

        if ($('#ohio-storage').length > 0) {

            const router = new VueRouter({
                mode: 'history',
                base: '/admin/ohio/storage',
                routes: [
                    {path: '/files', component: fileIndex, canReuse: false, name: 'fileIndex'},
                    {path: '/files/create', component: fileCreate, name: 'fileCreate'},
                    {path: '/files/edit/:id', component: fileEdit, name: 'fileEdit'}
                ]
            });

            const app = new Vue({router}).$mount('#ohio-storage');
        }
    }

}