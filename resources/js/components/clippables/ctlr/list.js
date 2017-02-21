import uploader from '../../base/uploader';

// helpers
import Form from '../form';
import Table from '../table';

//import foo from 'belt/clip/js/components/attachments/ctlr/form';

// templates
import list_html from '../templates/list.html';

export default {
    props: {
        uploader_driver: {default: ''},
        uploader_path: {default: ''},
        uploader_multiple: {default: true},
    },
    data() {
        return {
            item: {
                id: null,
            },
            detached: new Table({
                morphable_type: this.$parent.morphable_type,
                morphable_id: this.$parent.morphable_id,
                query: {not: 1},
            }),
            table: new Table({
                morphable_type: this.$parent.morphable_type,
                morphable_id: this.$parent.morphable_id,
            }),
            form: new Form({
                morphable_type: this.$parent.morphable_type,
                morphable_id: this.$parent.morphable_id,
            }),
        }
    },
    components: {
        uploader: uploader,
    },
    mounted() {
        this.table.index();
    },
    methods: {
        edit(item) {
            if (this.item.id != item.id) {
                this.item = item;
            } else {
                this.item = '';
            }
        },
    },
    template: list_html
}