// templates
import heading_html from 'belt/core/js/templates/heading.html';
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
        heading: {template: heading_html},
        tabs: {template: tabs_html},
    },
    template: edit_html,
}