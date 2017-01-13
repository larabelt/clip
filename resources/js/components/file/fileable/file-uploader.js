global._ = require('lodash');
import fileUploaderStore from './store';

export default {
    props: [
        'id',
        'class',
        'name',
        'accept',
        'multiple',
        'buttonText',
    ],
    data() {
        return {
            disk: '',
            path: 'foo',
            fileable_id: '',
            fileable_type: '',
            file: '',
            files: [],
        }
    },
    mounted() {
        this.$store.registerModule('fileUploader', fileUploaderStore);
        this.fileable_id = this.$parent.fileable_id;
        this.fileable_type = this.$parent.fileable_type;
    },
    computed: {},
    methods: {
        attach(file_id) {
            if (typeof this.$parent.attach === 'function') {
                this.$parent.attach(file_id);
            }
        },
        onFileClick: function () {
            // click actually triggers after the file dialog opens
            //this.$dispatch('onFileClick', this.myFiles);
        },
        onFileChange(e) {
            // get the group of files assigned to this field
            //this.$dispatch('onFileChange', this.myFiles);

            this.files = e.target.files || e.dataTransfer.files;

            if (!this.files.length) {
                return;
            }

            console.log('onFileChange');
            console.log(this.$parent.fileable_id);
            console.log(this.$parent.fileable_type);

            for (let i = 0; i < this.files.length; i++) {
                this.uploadFile(this.files.item(i));
            }

        },
        uploadFile(file) {

            // properties: multiple, allow, path, disk
            // progress data...
            // clear progress list
            // update meta data

            let formData = new FormData();

            formData.append('file', file);
            formData.append('disk', this.disk);
            formData.append('path', this.path);

            // //this.errors = {};
            this.$http.post("/api/v1/files", formData, {
                progress(e) {
                    console.log('no progress');
                    if (e.lengthComputable) {
                        console.log('progress');
                        console.log(e.loaded / e.total * 100);
                        console.log('progress done');
                    }
                }
            }).then((response) => {
                this.attach(response.data.id);
            }, (response) => {
                if (response.status == 422) {
                    //this.errors = response.data.message;
                }
            });
            // //this.saving = false;
        },
        _onProgress: function (e) {
            // this is an internal call in XHR to update the progress
            e.percent = (e.loaded / e.total) * 100;
            this.$dispatch('onFileProgress', e);
        },
        _handleUpload: function (file) {
            this.$dispatch('beforeFileUpload', file);
            var form = new FormData();
            var xhr = new XMLHttpRequest();
            try {
                form.append('Content-Type', file.type || 'application/octet-stream');
                // our request will have the file in the ['file'] key
                form.append('file', file);
            } catch (err) {
                this.$dispatch('onFileError', file, err);
                return;
            }

            return new Promise(function (resolve, reject) {

                xhr.upload.addEventListener('progress', this._onProgress, false);

                xhr.onreadystatechange = function () {
                    if (xhr.readyState < 4) {
                        return;
                    }
                    if (xhr.status < 400) {
                        var res = JSON.parse(xhr.responseText);
                        this.$dispatch('onFileUpload', file, res);
                        resolve(file);
                    } else {
                        var err = JSON.parse(xhr.responseText);
                        err.status = xhr.status;
                        err.statusText = xhr.statusText;
                        this.$dispatch('onFileError', file, err);
                        reject(err);
                    }
                }.bind(this);

                xhr.onerror = function () {
                    var err = JSON.parse(xhr.responseText);
                    err.status = xhr.status;
                    err.statusText = xhr.statusText;
                    this.$dispatch('onFileError', file, err);
                    reject(err);
                }.bind(this);

                xhr.open(this.method || "POST", this.action, true);
                if (this.headers) {
                    for (var header in this.headers) {
                        xhr.setRequestHeader(header, this.headers[header]);
                    }
                }
                xhr.send(form);
                this.$dispatch('afterFileUpload', file);
            }.bind(this));
        },
        fileUpload: function () {
            if (this.myFiles.length > 0) {
                // a hack to push all the Promises into a new array
                var arrayOfPromises = Array.prototype.slice.call(this.myFiles, 0).map(function (file) {
                    return this._handleUpload(file);
                }.bind(this));
                // wait for everything to finish
                Promise.all(arrayOfPromises).then(function (allFiles) {
                    this.$dispatch('onAllFilesUploaded', allFiles);
                }.bind(this)).catch(function (err) {
                    this.$dispatch('onFileError', this.myFiles, err);
                }.bind(this));
            } else {
                // someone tried to upload without adding files
                var err = new Error("No files to upload for this field");
                this.$dispatch('onFileError', this.myFiles, err);
            }
        }
    },
    template: `
        <div>
            <div class="file-group">
                <label for="file">
                    <input type="file" name="file" id="file-uploader" accept="image/*" @click="onFileClick" @change="onFileChange" multiple="multiple">
                    <slot></slot>
                </label>
                <button class="btn btn-default" type="button" v-on:click="fileUpload">upload</button>
            </div>
            <div v-if="files" v-for="file in files">
                <p>{{ file.name }}</p>
            </div>
        </div>
    `
}