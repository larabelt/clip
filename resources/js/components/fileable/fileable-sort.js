import fileUploader from '../base/uploader';
import fileService from '../file/service';
import fileFormTemplate from '../file/templates/form';
import fileableService from './service';
import fileableSortTemplate from './templates/sort';

export default {
    mixins: [fileableService],
    components: {
        fileUploader: fileUploader,
    },
    data() {
        return {
            perPage: 999,
            dragged: '',
            dropped: '',
            fileable_type: this.$parent.fileable_type,
            fileable_id: this.$parent.fileable_id,
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
    template: fileableSortTemplate,
}