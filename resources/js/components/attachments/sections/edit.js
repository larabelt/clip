// components
import shared from 'belt/content/js/components/sectionables/ctlr/shared';

// helpers
import Form from '../form';
import Table from '../table';

// templates
import edit_html from './edit.html';

export default {
    mixins: [shared],
    data() {
        return {
            table: new Table({query: {perPage: 20}}),
            attachment: new Form(),
        }
    },
    mounted() {
        if (this.section.sectionable_id) {
            this.attachment.show(this.section.sectionable_id);
        }
    },
    methods: {
        update(id)
        {
            let form = this.active;
            let attachment = this.attachment;
            let table = this.table;

            form.sectionable_id = id;

            form.submit()
                .then(function () {
                    table.query.q = '';
                    table.items = [];
                    attachment.show(form.sectionable_id);
                });
        }
    },
    template: edit_html
}