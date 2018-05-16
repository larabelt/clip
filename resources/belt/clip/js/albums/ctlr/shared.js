import Form from 'belt/clip/js/albums/form';
import tabs_html from 'belt/clip/js/albums/templates/tabs.html';
import html from 'belt/clip/js/albums/templates/edit.html';

export default {
    data() {
        return {
            morphable_type: 'albums',
            morphable_id: this.$route.params.id,
            album: new Form(),
        }
    },
    mounted() {
        this.album.show(this.morphable_id);
    },
    components: {
        tabs: {template: tabs_html},
    },
    template: html,
}