// helpers
import Form from 'belt/clip/js/albums/form';

// templates make a change
import heading_html from 'belt/core/js/templates/heading.html';
import form_html from 'belt/clip/js/albums/templates/form.html';
import create_html from 'belt/clip/js/albums/templates/create.html';

export default {
    components: {
        heading: {template: heading_html},
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