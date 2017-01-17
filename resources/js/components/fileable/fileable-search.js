import fileableService from './service';
import fileableSearchTemplate from './templates/search';

export default {
    mixins: [fileableService],
    data() {
        return {
            perPage: 999,
            fileable_type: this.$parent.fileable_type,
            fileable_id: this.$parent.fileable_id,
        }
    },
    mounted() {
        this.paginate();
    },
    template: fileableSearchTemplate,
}