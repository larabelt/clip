import fileUploader from '../base/uploader';
import fileService from '../file/service';
import fileFormTemplate from '../file/templates/form';
import fileableService from './service';
import fileableIndexTemplate from './templates/index';
import fileableEdit from './fileable-edit';

export default {
    mixins: [fileableService],
    components: {
        fileableEdit,
        fileUploader: fileUploader,
        fileForm: {
            props: ['index'],
            mixins: [fileService],
            template: fileFormTemplate,
            mounted() {
                this.item = this.$parent.items[this.index];
            },
        },
    },
    props: {
        uploader_disk: {default: ''},
        uploader_path: {default: ''},
        uploader_multiple: {default: true},
    },
    data() {
        return {
            fileable_type: this.$parent.fileable_type,
            fileable_id: this.$parent.fileable_id,
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

            //this.$parent.item = item;
            //return this.$parent.mode = 'edit';
        },
    },
    template: fileableIndexTemplate,
}