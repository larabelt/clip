import thumb from 'belt/clip/js/attachments/thumb';

// helpers
import Form from 'belt/clip/js/clippables/form';
import positionable from 'belt/core/js/mixins/base/positionable';

// templates
import sort_html from 'belt/clip/js/clippables/templates/sort.html';

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
    components: {thumb},
    template: sort_html
}