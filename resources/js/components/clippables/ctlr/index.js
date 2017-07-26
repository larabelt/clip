// components
import list from 'belt/clip/js/components/clippables/ctlr/list';
import search from 'belt/clip/js/components/clippables/ctlr/search';
import sort from 'belt/clip/js/components/clippables/ctlr/sort';
import uploader from 'belt/clip/js/components/base/uploader/ctlr';

// helpers
import Tabs from 'belt/core/js/helpers/tabs';
import Table from 'belt/clip/js/components/clippables/table';
import Form from 'belt/clip/js/components/clippables/form';

// templates
import index_html from 'belt/clip/js/components/clippables/templates/index.html';
import uploader_html from 'belt/clip/js/components/base/uploader/template.html';

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
        list,
        search,
        sort,
        uploader: {
            mixins: [uploader],
            methods: {
                onUploadSuccess(attachment) {
                    this.$parent.form.setData({id: attachment.id});
                    this.$parent.form.store()
                        .then(response => {
                            this.$parent.table.index();
                        })
                },
            },
            template: uploader_html
        },
    },
    mounted() {
        this.table.index();
    },
    methods: {
        setTab(tab)
        {
            this.tabs.set(tab);
            this.table.query.perPage = 10;
            if (tab == 'sort') {
                this.table.query.perPage = 9999;
            }
            this.table.index();
        }
    },
    template: index_html
}