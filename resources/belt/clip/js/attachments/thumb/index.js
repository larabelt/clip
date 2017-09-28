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
    template: html,
}