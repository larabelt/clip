import fileableService from './service';
import fileableIndexTemplate from './templates/index';
import fileUploader from './file-uploader';

export default {
    data() {
        return {
            fileable_type: this.$parent.morphable_type,
            fileable_id: this.$parent.morphable_id,
        }
    },
    components: {
        'fileable-index': {
            mixins: [fileableService],
            template: fileableIndexTemplate,
            components: { fileUploader: fileUploader },
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
    template: `
        <div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Files</h3>
                </div>
                <div class="box box-primary">
                    <div class="box-body">
                        <fileable-index></fileable-index>
                    </div>
                </div>
            </div>
        </div>
        `
}