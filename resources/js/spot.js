import addressIndex from './components/address/ctlr-index';
import addressCreate from './components/address/ctlr-create';
import addressEdit  from './components/address/ctlr-edit';
import placeIndex from './components/place/ctlr-index';
import placeCreate from './components/place/ctlr-create';
import placeEdit  from './components/place/ctlr-edit';
import store from 'belt/core/js/store/index';

export default class BeltSpot {

    constructor() {

        if ($('#belt-spot').length > 0) {

            const router = new VueRouter({
                mode: 'history',
                base: '/admin/belt/spot',
                routes: [
                    {path: '/addresses', component: addressIndex, canReuse: false, name: 'addressIndex'},
                    {path: '/addresses/create', component: addressCreate, name: 'addressCreate'},
                    {path: '/addresses/edit/:id', component: addressEdit, name: 'addressEdit'},
                    {path: '/places', component: placeIndex, canReuse: false, name: 'placeIndex'},
                    {path: '/places/create', component: placeCreate, name: 'placeCreate'},
                    {path: '/places/edit/:id', component: placeEdit, name: 'placeEdit'},
                ]
            });

            const app = new Vue({router, store}).$mount('#belt-spot');
        }
    }

}