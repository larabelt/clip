// components
import search from './search';
import uploader from '../../base/uploader/ctlr';

// helpers
import Tabs from 'belt/core/js/helpers/tabs';
import Table from '../table';
import Form from '../form';

// templates
import index_html from '../templates/index.html';
import uploader_html from '../../base/uploader/template.html';

export default {
    props: {
        path: {default: ''},
        driver: {default: ''},
        multiple: {default: true},
    },
    data() {

        let morphable_type = this.$parent.morphable_type;
        let morphable_id = this.$parent.morphable_id;

        return {
            morphable_type: morphable_type,
            morphable_id: morphable_id,
            tabs: new Tabs({router: this.$router, default: 'list'}),
            detached: new Table({
                morphable_type: morphable_type,
                morphable_id: morphable_id,
                query: {not: 1},
            }),
            table: new Table({
                morphable_type: morphable_type,
                morphable_id: morphable_id,
            }),
            form: new Form({
                morphable_type: this.$parent.morphable_type,
                morphable_id: this.$parent.morphable_id,
            }),
        }
    },
    components: {
        search,
        uploader: {
            mixins: [uploader],
            methods: {
                onUploadSuccess(attachment) {
                    this.$parent.form.setData({id: attachment.id});
                    this.$parent.form.store()
                        .then(response => {
                            this.$parent.backToEdit();
                        })
                },
            },
            template: uploader_html
        },
    },
    methods: {
        backToEdit() {
            this.$parent.$router.push({
                name: this.morphable_type + '.edit',
                params: {id: this.$parent.$route.params.id}
            })
        }
    },
    mounted() {
        this.table.index();
    },
    template: index_html
}