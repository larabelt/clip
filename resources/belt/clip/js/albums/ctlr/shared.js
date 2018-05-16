// templates

import tabs_html from 'belt/clip/js/albums/templates/tabs.html';
import edit_html from 'belt/clip/js/albums/templates/edit.html';

export default {
    data() {
        return {
            morphable_type: 'albums',
            morphable_id: this.$route.params.id,
            album: this.$parent.album,
        }
    },
    components: {

        tabs: {template: tabs_html},
    },
    template: edit_html,
}