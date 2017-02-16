import attachmentUploader from '../base/uploader';
import attachmentService from '../attachment/service';
import attachmentFormTemplate from '../attachment/templates/form';
import clippableService from './service';
import clippableIndexTemplate from './templates/index';
import clippableEdit from './clippable-edit';

export default {
    mixins: [clippableService],
    components: {
        clippableEdit,
        attachmentUploader: attachmentUploader,
        attachmentForm: {
            props: ['index'],
            mixins: [attachmentService],
            template: attachmentFormTemplate,
            mounted() {
                this.item = this.$parent.items[this.index];
            },
        },
    },
    props: {
        uploader_driver: {default: ''},
        uploader_path: {default: ''},
        uploader_multiple: {default: true},
    },
    data() {
        return {
            clippable_type: this.$parent.clippable_type,
            clippable_id: this.$parent.clippable_id,
        }
    },
    mounted() {
        this.paginate();
    },
    methods: {
        edit(item) {
            if (this.item.id != item.id) {
                this.item = item;
            } else {
                this.item = '';
            }

            console.log(this.item);

            //this.$parent.item = item;
            //return this.$parent.mode = 'edit';
        },
    },
    template: clippableIndexTemplate,
}