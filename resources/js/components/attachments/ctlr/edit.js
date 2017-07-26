import shared from 'belt/clip/js/components/attachments/ctlr/shared';
import attachmentSummary from 'belt/clip/js/components/attachments/ctlr/summary';
import uploader from 'belt/clip/js/components/base/uploader/ctlr';
import form_html from 'belt/clip/js/components/attachments/templates/form.html';

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