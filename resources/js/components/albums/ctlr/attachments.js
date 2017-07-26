import shared from 'belt/clip/js/components/albums/ctlr/shared';

// components
import attachments from 'belt/clip/js/components/clippables/ctlr/index';

export default {
    mixins: [shared],
    components: {
        tab: attachments,
    },
}