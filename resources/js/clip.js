import albums  from 'belt/clip/js/components/albums/routes';
import attachments  from 'belt/clip/js/components/attachments/routes';

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

            const app = new Vue({router}).$mount('#belt-clip');
        }
    }

}