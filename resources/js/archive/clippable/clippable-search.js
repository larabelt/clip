import clippableService from './service';
import clippableSearchTemplate from './templates/search';

export default {
    mixins: [clippableService],
    data() {
        return {
            perPage: 999,
            clippable_type: this.$parent.clippable_type,
            clippable_id: this.$parent.clippable_id,
        }
    },
    mounted() {
        this.paginate();
    },
    template: clippableSearchTemplate,
}