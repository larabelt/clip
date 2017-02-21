// components
import list from './list';

// helpers
import Tabs from 'belt/core/js/helpers/tabs';

// templates
import index_html from '../templates/index.html';

export default {
    data() {
        return {
            morphable_type: this.$parent.morphable_type,
            morphable_id: this.$parent.morphable_id,
            tabs: new Tabs({router: this.$router})
        }
    },
    components: {
        list: list,
    },
    mounted() {
        this.tabs.set('list');
    },
    template: index_html
}