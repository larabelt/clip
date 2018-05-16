import shared from 'belt/clip/js/albums/ctlr/shared';
import attachment from 'belt/clip/js/clippables/ctlr/attachment';
import form_html from 'belt/clip/js/albums/templates/form.html';

export default {
    mixins: [shared],
    components: {
        tab: {
            data() {
                return {
                    album: this.$parent.album,
                }
            },
            components: {attachment},
            template: form_html,
        },
    },
}