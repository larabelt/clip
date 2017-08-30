import Form from 'belt/clip/js/base/uploader/form';
import Table from 'belt/clip/js/attachments/table';
import html from 'belt/clip/js/base/uploader/template.html';

export default {
    props: {
        accept: {default: 'image/*,application/pdf'},
        path: {default: ''},
        driver: {default: ''},
        multiple: {default: true},
        search: {default: false},
        title: {default: 'upload file'},
        id: {default: ''},
    },
    data() {
        return {
            pending: [],
            uploaded: [],
            progress: [],
            form: new Form({hasFile: true}),
            table: new Table(),
        }
    },
    methods: {
        onFileClick: function () {
            this.$refs.fileinput.click();
        },
        onFileChange(e) {

            this.pending = [];

            let files = e.target.files || e.dataTransfer.files;

            if (!files.length) {
                return;
            }

            for (let i = 0; i < files.length; i++) {
                let file = files.item(i);
                file.progress = 0;
                this.pending[i] = file;
            }

            this.uploadFiles();
        },
        uploadFiles() {
            for (let i = 0; i < this.pending.length; i++) {
                this.uploadFile(i);
            }
        },
        uploadFile(i) {

            let self = this;
            let file = this.pending[i];

            this.progress[i] = 0;

            this.form.reset();
            this.form.file = file;
            this.form.driver = this.driver;
            this.form.path = this.path;

            if (this.id) {
                this.form.id = this.id;
            }

            this.form.submit()
                .then((response) => {
                    self.pending.splice(i, 1);
                    self.$emit('attachment-uploaded', this.form.data());
                    self.onUploadSuccess(response);
                    //self.progress.splice(i, 1);
                });
        },
        onUploadSuccess(attachment) {
            // empty to be overwritten
        },
        attachFile(id) {
            this.table.query.q = '';
            this.table.query.items = [];
            this.attach(id);
        },
        attach(id) {
            // empty to be overwritten
        },
    },
    template: html
}