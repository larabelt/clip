import html from 'belt/clip/js/attachments/templates/summary.html';

export default {
    data() {
        return {
            attachment: this.$parent.form,
        }
    },
    methods: {
        test() {
            console.log('test2');
        }
    },
    template: html,
}