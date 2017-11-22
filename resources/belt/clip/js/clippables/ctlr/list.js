import attachmentSummary from 'belt/clip/js/attachments/summary';
import thumb from 'belt/clip/js/attachments/thumb';
import Form from 'belt/clip/js/attachments/form';
import list_html from 'belt/clip/js/clippables/templates/list.html';
//import edit_html from 'belt/clip/js/attachments/templates/form.html';
import edit_html from 'belt/clip/js/clippables/templates/edit.html';

export default {
    data() {
        return {
            item: {
                id: null,
            },
            detached: this.$parent.detached,
            table: this.$parent.table,
            form: new Form({
                morphable_type: this.$parent.morphable_type,
                morphable_id: this.$parent.morphable_id,
            }),
        }
    },
    components: {
        attachmentSummary,
        thumb,
        edit: {
            data() {
                return {
                    form: this.$parent.form,
                }
            },
            components: {
                attachmentSummary,
                thumb,
            },
            template: edit_html
        }
    },
    methods: {
        edit(item) {
            if (this.form.id != item.id) {
                this.form.setData(item);
            } else {
                this.form.reset();
            }
        },
    },
    template: list_html
}