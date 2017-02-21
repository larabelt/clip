import uploader from '../../base/uploader';

// helpers
//import Form from '../form';
import Form from 'belt/clip/js/components/attachments/form';
import Table from '../table';

// templates
import list_html from '../templates/list.html';
import edit_html from 'belt/clip/js/components/attachments/templates/form.html';

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
        edit: {
            data() {
                return {
                    form: this.$parent.form,
                }
            },
            template: edit_html
        }
    },
    mounted() {
        this.table.index();
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