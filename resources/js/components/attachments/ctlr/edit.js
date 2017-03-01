
// helpers
import Form from '../form';

// templates make a change
import heading_html from 'belt/core/js/templates/heading.html';
import edit_html from '../templates/edit.html';
import form_html from '../templates/form.html';

export default {
    data() {
        return {
            form: new Form(),
        }
    },
    components: {
        heading: {template: heading_html},
        edit: {
            data() {
                return {
                    form: this.$parent.form,
                }
            },
            template: form_html,
        },
    },
    mounted() {
        this.form.show(this.$route.params.id);
    },
    template: edit_html,
}