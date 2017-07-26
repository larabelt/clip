import uploader from 'belt/clip/js/components/base/uploader/ctlr';
import uploader_html from 'belt/clip/js/components/base/uploader/template.html';
import Form from 'belt/clip/js/components/resizes/form';
import UploadForm from 'belt/clip/js/components/resizes/form-upload';
import Table from 'belt/clip/js/components/resizes/table';
import edit from 'belt/clip/js/components/resizes/edit';
import html from 'belt/clip/js/components/resizes/templates/index.html';

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