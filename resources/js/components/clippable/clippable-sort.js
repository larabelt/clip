import fileUploader from '../base/uploader';
import fileService from '../file/service';
import fileFormTemplate from '../file/templates/form';
import clippableService from './service';
import clippableSortTemplate from './templates/sort';

export default {
    mixins: [clippableService],
    components: {
        fileUploader: fileUploader,
    },
    data() {
        return {
            perPage: 999,
            dragged: '',
            dropped: '',
            clippable_type: this.$parent.clippable_type,
            clippable_id: this.$parent.clippable_id,
        }
    },
    mounted() {
        this.paginate();
    },
    methods: {
        drag: function (e) {
            this.dragged = e.target.getAttribute('data-index');
        },
        drop: function (e) {
            this.dropped = e.target.getAttribute('data-index');

            if (!this.dragged || !this.dropped || this.dragged == this.dropped) {
                return false;
            }

            let type = this.dragged < this.dropped ? 'after' : 'before';

            this.move(type, this.dragged, this.dropped);
            this.paginate();
        }
    },
    template: clippableSortTemplate,
}