// components
import shared from 'belt/content/js/sectionables/ctlr/shared';

// helpers
import Form from 'belt/clip/js/albums/form';
import Table from 'belt/clip/js/albums/table';

// templates
import edit_html from 'belt/clip/js/albums/sections/edit.html';

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
            let form = this.active;
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