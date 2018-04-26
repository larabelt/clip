import listItem from 'belt/clip/js/clippables/ctlr/list-item';
//import Form from 'belt/clip/js/attachments/form';
import Form from 'belt/clip/js/clippables/form';
import html from 'belt/clip/js/clippables/templates/list.html';

export default {
    data() {
        return {
            item: {
                id: null,
            },
            detached: this.$parent.detached,
            table: this.$parent.table,
            form: new Form({
                morphable_type: this.$parent.morphable_type,
                morphable_id: this.$parent.morphable_id,
            }),
        }
    },
    components: {
        listItem,
    },
    template: html
}