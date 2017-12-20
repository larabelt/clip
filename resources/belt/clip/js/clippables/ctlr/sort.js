import shared from 'belt/clip/js/clippables/shared';
import Form from 'belt/clip/js/clippables/form';
import listItem from 'belt/clip/js/clippables/list-item';
import html from 'belt/clip/js/clippables/templates/sort.html';

export default {
    mixins: [shared],
    data() {
        return {
            form: new Form({
                morphable_type: this.$parent.morphable_type,
                morphable_id: this.$parent.morphable_id,
            }),
            morphable_type: this.$parent.morphable_type,
            morphable_id: this.$parent.morphable_id,
            //table: this.$parent.table,
        }
    },
    beforeMount() {
        this.$store.dispatch('clippable/set', {morphableType: this.morphable_type, morphableID: this.morphable_id});
        this.$store.dispatch('clippable/construct');
        this.$store.dispatch('clippable/load');
    },
    components: {listItem},
    template: html
}