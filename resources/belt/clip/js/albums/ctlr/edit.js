import shared from 'belt/clip/js/albums/ctlr/shared';

// components
import attachment from 'belt/clip/js/clippables/ctlr/attachment';

// helpers
import Form from 'belt/clip/js/albums/form';

// templates make a change

import tabs_html from 'belt/clip/js/albums/templates/tabs.html';
import edit_html from 'belt/clip/js/albums/templates/edit.html';
import form_html from 'belt/clip/js/albums/templates/form.html';

export default {
    data() {
        return {
            morphable_type: 'albums',
            morphable_id: this.$route.params.id,
            album: new Form(),
        }
    },
    mounted() {
        this.album.show(this.morphable_id);
    },
    components: {

        tabs: {template: tabs_html},
        tab: {
            mixins: [shared],
            components: {attachment},
            template: form_html,
        },
    },
    template: edit_html,
}