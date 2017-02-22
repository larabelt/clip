// helpers
import Form from './form';

// templates
import html from './template.html';

export default {
    props: {
        path: {default: ''},
        driver: {default: ''},
        multiple: {default: true},
    },
    data() {
        return {
            pending: [],
            uploaded: [],
            progress: [],
            form: new Form({hasFile: true}),
        }
    },
    methods: {
        onFileClick: function () {
            // click actually triggers after the file dialog opens
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

            this.form.submit()
                .then((response) => {
                    self.pending.splice(i, 1);
                    this.onUploadSuccess(response);
                    //self.progress.splice(i, 1);
                });

            // this.$http.post('/api/v1/attachments', formData, {
            //     progress(e) {
            //         if (e.lengthComputable) {
            //             self.progress[i] = Math.ceil(e.loaded / e.total * 100);
            //             file.progress = Math.ceil(e.loaded / e.total * 100);
            //         }
            //     }
            // }).then((response) => {
            //     this.attach(response.data.id);
            //     self.pending.splice(i, 1);
            //
            // }, (response) => {
            //     if (response.status == 422) {
            //         //this.errors = response.data.message;
            //     }
            // });
            // this.saving = false;
        },
        onUploadSuccess(attachment) {

        },
    },
    template: html
}