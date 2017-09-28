import shared from 'belt/clip/js/attachments/ctlr/shared';
import thumb from 'belt/clip/js/attachments/thumb';
import attachmentSummary from 'belt/clip/js/attachments/summary';
import uploader from 'belt/clip/js/base/uploader/ctlr';
import form_html from 'belt/clip/js/attachments/templates/form.html';

export default {
    mixins: [shared],
    components: {
        tab: {
            data() {
                return {
                    form: this.$parent.form,
                }
            },
            components: {
                attachmentSummary,
                thumb,
                uploader: {
                    mixins: [uploader],
                    methods: {
                        onUploadSuccess(attachment) {
                            this.$parent.form.show(attachment.id);
                        },
                    },
                },
            },
            template: form_html,
        },
    },
}