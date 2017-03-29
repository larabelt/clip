// components
import shared from 'belt/content/js/components/sectionables/ctlr/panel-shared';

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
            album: new Form(),
        }
    },
    mounted() {
        if (this.section.sectionable_id) {
            this.album.show(this.section.sectionable_id);
        }
    },
    methods: {
        update(id)
        {
            let form = this.panel.form;
            let album = this.album;
            let table = this.table;

            form.sectionable_id = id;

            form.submit()
                .then(function () {
                    table.query.q = '';
                    table.items = [];
                    album.show(form.sectionable_id);
                });
        }
    },
    template: edit_html
}