import uploader from 'belt/clip/js/components/base/uploader/ctlr';
import uploader_html from 'belt/clip/js/components/base/uploader/template.html';
import Form from './form';
import UploadForm from './form-upload';
import Table from './table';
import edit from './edit';
import html from './templates/index.html';

export default {
    data() {
        return {
            morphable_id: this.$parent.morphable_id,
            table: new Table({
                morphable_id: this.$parent.morphable_id,
            }),
        }
    },
    mounted() {
        this.table.index();
    },
    components: {
        uploader: {
            mixins: [uploader],
            data() {
                return {
                    table: this.$parent.table,
                    form: new UploadForm({
                        morphable_id: this.$parent.morphable_id,
                    }),
                }
            },
            methods: {
                onUploadSuccess() {
                    this.table.index();
                },
            },
            template: uploader_html
        },
        edit
    },
    template: html
}