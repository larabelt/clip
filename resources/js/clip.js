import attachmentIndex from './components/attachment/ctlr-index';
import attachmentCreate from './components/attachment/ctlr-create';
import attachmentEdit  from './components/attachment/ctlr-edit';
import store from 'belt/core/js/store/index';

export default class BeltClip {

    constructor() {

        if ($('#belt-clip').length > 0) {

            const router = new VueRouter({
                mode: 'history',
                base: '/admin/belt/clip',
                routes: [
                    {path: '/attachments', component: attachmentIndex, canReuse: false, name: 'attachmentIndex'},
                    {path: '/attachments/create', component: attachmentCreate, name: 'attachmentCreate'},
                    {path: '/attachments/edit/:id', component: attachmentEdit, name: 'attachmentEdit'}
                ]
            });

            const app = new Vue({router, store}).$mount('#belt-clip');
        }
    }

}