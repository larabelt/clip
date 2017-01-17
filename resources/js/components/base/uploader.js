global._ = require('lodash');
//import fileUploaderStore from './store';

export default {
    props: {
        multiple: {default: true},
        disk: {default: ''},
        path: {default: ''},
    },
    data() {
        return {
            fileable_id: '',
            fileable_type: '',
            pending: [],
            uploaded: [],
            progress: [],
        }
    },
    mounted() {
        //this.$store.registerModule('fileUploader', fileUploaderStore);
        this.fileable_id = this.$parent.fileable_id;
        this.fileable_type = this.$parent.fileable_type;
    },
    computed: {
    },
    methods: {
        attach(file_id) {
            if (typeof this.$parent.attach === 'function') {
                this.$parent.attach(file_id);
            }
        },
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

        },
        uploadFiles() {
            for (let i = 0; i < this.pending.length; i++) {
                this.uploadFile(i);
            }
            console.log(this.progress);
        },
        uploadFile(i) {

            let self = this;
            let file = this.pending[i];
            let formData = new FormData();

            this.progress[i] = 0;

            formData.append('file', file);
            formData.append('disk', this.disk);
            formData.append('path', this.path);

            //this.errors = {};

            this.$http.post('/api/v1/files', formData, {
                progress(e) {
                    if (e.lengthComputable) {
                        self.progress[i] = Math.ceil(e.loaded / e.total * 100);
                        file.progress = Math.ceil(e.loaded / e.total * 100);
                    }
                }
            }).then((response) => {
                this.attach(response.data.id);
                self.pending[i] = '';
                delete self.pending[i];

            }, (response) => {
                if (response.status == 422) {
                    //this.errors = response.data.message;
                }
            });
            //this.saving = false;
        },
    },
    template: `
        <div>
            <div class="file-group">
                <label for="file">
                    <input type="file" name="file" id="file-uploader" accept="image/*" @click="onFileClick" @change="onFileChange" v-bind:multiple="multiple">
                    <slot></slot>
                </label>
                <button class="btn btn-default" type="button" v-on:click="uploadFiles">upload</button>
            </div>
            <div v-if="pending">
                <table class="table table-bordered table-hover">
                    <tr v-for="file, i in pending">
                        <td>{{ file.name }}</td>
                        <td>{{ file.progress }}</td>
                        <td>
                            <div class="progress">
                              <div class="progress-bar" role="progressbar" :aria-valuenow=progress[i] aria-valuemin="0" aria-valuemax="100" :style="'width: ' + progress[i] + '%;'">
                                {{ progress[i] }}%
                              </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    `
}