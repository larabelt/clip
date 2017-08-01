import Form from 'belt/clip/js/resizes/form';
import html from 'belt/clip/js/resizes/templates/edit.html';

export default {
    props: ['resize'],
    data() {
        return {
            table: this.$parent.table,
            form: new Form({
                morphable_id: this.$parent.morphable_id,
            }),
        }
    },
    mounted() {
        this.form.show(this.resize.id);
    },
    methods: {

    },
    template: html
}