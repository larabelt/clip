import shared from 'belt/clip/js/components/albums/ctlr/shared';

// components
import attachment from 'belt/clip/js/components/clippables/ctlr/attachment';

// helpers
import Form from 'belt/clip/js/components/albums/form';

// templates make a change
import heading_html from 'belt/core/js/templates/heading.html';
import tabs_html from 'belt/clip/js/components/albums/templates/tabs.html';
import edit_html from 'belt/clip/js/components/albums/templates/edit.html';
import form_html from 'belt/clip/js/components/albums/templates/form.html';

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
        heading: {template: heading_html},
        tabs: {template: tabs_html},
        tab: {
            mixins: [shared],
            components: {attachment},
            template: form_html,
        },
    },
    template: edit_html,
}