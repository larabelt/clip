import shared from 'belt/core/js/inputs/shared';
import AttachmentTable from 'belt/clip/js/attachments/table';
import AttachmentForm from 'belt/clip/js/attachments/form';
import thumb from 'belt/clip/js/attachments/thumb';
import html from 'belt/clip/js/inputs/attachment/template.html';

export default {
    mixins: [shared],
    data() {
        return {
            attachment: new AttachmentForm(),
            attachments: new AttachmentTable({query: {perPage: 20}}),
        };
    },
    created() {
        this.config.label = _.get(this.config, 'label', 'Attachment');
        this.config.description = _.get(this.config, 'description', 'Use the search field to find attachments that can be linked to this item.');
        this.$watch('form.' + this.column, function (newValue) {
            this.attachment.show(newValue);
        });
    },
    mounted() {
        if (this.value) {
            this.attachment.show(this.value);
        }
    },
    methods: {
        clear() {
            this.attachments.query.q = '';
        },
        update(id) {
            this.form[this.column] = id;
            this.clear();
            this.emitEvent();
        },
    },
    components: {thumb},
    template: html
}