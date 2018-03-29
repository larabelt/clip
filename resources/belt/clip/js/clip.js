import albums from 'belt/clip/js/albums/routes';
import attachments from 'belt/clip/js/attachments/routes';
import store from 'belt/core/js/store/index';

import inputAttachment from 'belt/clip/js/inputs/attachment';
Vue.component('input-attachment', inputAttachment);

window.larabelt.clip = _.get(window, 'larabelt.clip', {});

export default class BeltClip {

    constructor() {

        if ($('#belt-clip').length > 0) {

            const router = new VueRouter({
                mode: 'history',
                base: '/admin/belt/clip',
                routes: []
            });

            router.addRoutes(albums);
            router.addRoutes(attachments);

            const app = new Vue({router, store}).$mount('#belt-clip');
        }
    }

}