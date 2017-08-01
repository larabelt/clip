import shared from 'belt/clip/js/attachments/ctlr/shared';

// components
import resizes from 'belt/clip/js/resizes/index';

export default {
    mixins: [shared],
    components: {
        tab: resizes,
    },
}