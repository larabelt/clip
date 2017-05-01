import shared from './shared';
import attachmentSummary from './summary';

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
                edit: {
                    mixins: [shared],
                    template: form_html,
                },
            },
            template: `
<div class="row">
    <div class="col-md-4">
        <attachment-summary></attachment-summary>
    </div>
    <div class="col-md-8">
        <edit></edit>
    </div>
</div>`,
        },
    },
}