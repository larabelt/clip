import shared from './shared';

// components
import resizes from 'belt/clip/js/components/resizes/index';

export default {
    mixins: [shared],
    components: {
        tab: resizes,
    },
}