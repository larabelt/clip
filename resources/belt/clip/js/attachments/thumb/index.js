import html from 'belt/clip/js/attachments/thumb/template.html';

export default {
    props: {
        attachment: {
            default: function () {
                return this.$parent.form;
            }
        },
        open_btn: {default: true},
    },
    computed: {
        title() {
            return this.attachment.title ? this.attachment.title : this.attachment.name;
        },
        type() {
            let mimetype = this.attachment.mimetype;

            if (mimetype == 'application/pdf') {
                return 'pdf';
            }

            return mimetype;
        },
    },
    template: html,
}