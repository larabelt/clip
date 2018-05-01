import attachmentSummary from 'belt/clip/js/attachments/summary';
import thumb from 'belt/clip/js/attachments/thumb';
import edit_html from 'belt/clip/js/clippables/templates/edit.html';
import html from 'belt/clip/js/clippables/templates/list-item.html';

export default {
    props: ['attachment'],
    data() {
        return {
            form: this.$parent.form,
            table: this.$parent.table,
        }
    },
    computed: {
        canEdit() {
            if (this.adminMode == 'admin') {
                return true;
            }
            if (_.get(this.activeTeam, 'id') == _.get(this.attachment, 'team_id')) {
                return true;
            }
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
    template: html,
}