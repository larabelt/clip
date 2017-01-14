import fileService from '../service';
import fileableService from './service';
import fileableIndexTemplate from './templates/index';
import fileUploader from './file-uploader';

export default {
    props: {
        uploader_disk: {default: ''},
        uploader_path: {default: ''},
        uploader_multiple: {default: true},
    },
    data() {
        return {
            fileable_type: this.$parent.morphable_type,
            fileable_id: this.$parent.morphable_id,
        }
    },
    components: {
        'fileable-index': {
            props: {
                uploader_disk: {default: ''},
                uploader_path: {default: ''},
                uploader_multiple: {default: true},
            },
            mixins: [fileService, fileableService],
            template: fileableIndexTemplate,
            components: {
                fileUploader: fileUploader,
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
        },
    },
    methods: {

    },
    template: `
        <div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Files</h3>
                </div>
                <div class="box box-primary">
                    <div class="box-body">
                        <fileable-index 
                            :uploader_disk=uploader_disk
                            :uploader_path=uploader_path
                            :uploader_multiple=uploader_multiple
                        ></fileable-index>
                    </div>
                </div>
            </div>
        </div>
        `
}