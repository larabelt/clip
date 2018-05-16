// helpers
import Form from 'belt/clip/js/albums/form';

// templates make a change

import form_html from 'belt/clip/js/albums/templates/form.html';
import create_html from 'belt/clip/js/albums/templates/create.html';

export default {
    components: {

        create: {
            data() {
                return {
                    album: new Form({router: this.$router}),
                }
            },
            template: form_html,
        },
    },
    template: create_html
}