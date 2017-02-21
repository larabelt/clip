
// helpers
import Form from '../form';

// templates make a change
import form_html from '../templates/form.html';

export default {
    data() {
        return {
            //morphable_type: 'pages',
            //morphable_id: this.$route.params.id,
        }
    },
    components: {
        edit: {
            data() {
                return {
                    form: new Form(),
                }
            },
            mounted() {
                //this.form.show(this.$route.params.id);
            },
            template: form_html,
        },
        // attachmentForm: {
        //     props: ['index'],
        //     mixins: [attachmentService],
        //     template: attachmentFormTemplate,
        //     mounted() {
        //         this.item = this.$parent.items[this.index];
        //     },
        // },
    },
    template: `<edit></edit>`,
}