// helpers
import Form from '../form';
import positionable from 'belt/core/js/mixins/base/positionable';

// templates
import sort_html from '../templates/sort.html';

export default {
    mixins: [positionable],
    data() {
        return {
            table: this.$parent.table,
            dragged: '',
            dropped: '',
            form: new Form({
                morphable_type: this.$parent.morphable_type,
                morphable_id: this.$parent.morphable_id,
            }),
        }
    },
    template: sort_html
}