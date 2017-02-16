//import attachmentUploaderStore from './store';

export default {
    props: {
        multiple: {default: true},
        driver: {default: ''},
        path: {default: ''},
    },
    data() {
        return {
            clippable_id: '',
            clippable_type: '',
            pending: [],
            uploaded: [],
            progress: [],
        }
    },
    mounted() {
        //this.$store.registerModule('attachmentUploader', attachmentUploaderStore);
        this.clippable_id = this.$parent.clippable_id;
        this.clippable_type = this.$parent.clippable_type;
    },
    computed: {
    },
    methods: {
        attach(attachment_id) {
            if (typeof this.$parent.attach === 'function') {
                this.$parent.attach(attachment_id);
            }
        },
        onAttachmentClick: function () {
            // click actually triggers after the attachment dialog opens
        },
        onAttachmentChange(e) {

            this.pending = [];

            let attachments = e.target.attachments || e.dataTransfer.attachments;

            if (!attachments.length) {
                return;
            }

            for (let i = 0; i < attachments.length; i++) {
                let attachment = attachments.item(i);
                attachment.progress = 0;
                this.pending[i] = attachment;
            }

            this.uploadAttachments();
        },
        uploadAttachments() {
            for (let i = 0; i < this.pending.length; i++) {
                this.uploadAttachment(i);
            }
            console.log(this.progress);
        },
        uploadAttachment(i) {

            let self = this;
            let attachment = this.pending[i];
            let formData = new FormData();

            this.progress[i] = 0;

            formData.append('attachment', attachment);
            formData.append('driver', this.driver);
            formData.append('path', this.path);

            //this.errors = {};

            this.$http.post('/api/v1/attachments', formData, {
                progress(e) {
                    if (e.lengthComputable) {
                        self.progress[i] = Math.ceil(e.loaded / e.total * 100);
                        attachment.progress = Math.ceil(e.loaded / e.total * 100);
                    }
                }
            }).then((response) => {
                this.attach(response.data.id);
                self.pending.splice(i, 1);

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
            <div class="attachment-group">
                <label for="attachment">
                    <input type="attachment" name="attachment" id="attachment-uploader" accept="image/*" @click="onAttachmentClick" @change="onAttachmentChange" v-bind:multiple="multiple">
                    <slot></slot>
                </label>
                <button class="btn btn-default hide" type="button" v-on:click="uploadAttachments">upload</button>
            </div>
            <div v-if="pending">
                <table class="table">
                    <tr v-for="attachment, i in pending">
                        <td>{{ attachment.name }}</td>
                        <td>{{ attachment.progress }}</td>
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