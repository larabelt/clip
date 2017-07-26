import thumb from 'belt/clip/js/components/clippables/ctlr/thumb';

// components
import shared from 'belt/content/js/components/sectionables/ctlr/shared';

// helpers
import Form from 'belt/clip/js/components/attachments/form';
import Table from 'belt/clip/js/components/attachments/table';

// templates
import edit_html from 'belt/clip/js/components/attachments/sections/edit.html';

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
    components: {thumb},
    template: edit_html
}