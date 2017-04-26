import thumb from './thumb';

// helpers
import Form from '../form';

// templates
import search_html from '../templates/search.html';

export default {
    data() {
        return {
            detached: this.$parent.detached,
            table: this.$parent.table,
            form: new Form({
                morphable_type: this.$parent.morphable_type,
                morphable_id: this.$parent.morphable_id,
            }),
        }
    },
    components: {thumb},
    methods: {
        attach(id) {
            this.form.setData({id: id});
            this.form.store()
                .then(() => {
                    this.table.index();
                    this.detached.index();
                })
        }
    },
    template: search_html
}