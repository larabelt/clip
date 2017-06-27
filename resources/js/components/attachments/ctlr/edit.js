import shared from './shared';
import attachmentSummary from './summary';
import uploader from '../../base/uploader/ctlr';
import form_html from '../templates/form.html';

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