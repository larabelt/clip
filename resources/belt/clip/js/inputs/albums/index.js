import shared from 'belt/core/js/inputs/shared';
import AlbumTable from 'belt/clip/js/albums/table';
import AlbumForm from 'belt/clip/js/albums/form';
import html from 'belt/clip/js/inputs/albums/template.html';

export default {
    mixins: [shared],
    data() {
        return {
            album: new AlbumForm(),
            albums: new AlbumTable({query: {perPage: 20}}),
        };
    },
    created() {
        this.config.label = _.get(this.config, 'label', 'Album');
        this.config.description = _.get(this.config, 'description', 'Use the search field to find albums that can be linked to this item.');
        this.$watch('form.' + this.column, function (newValue) {
            this.album.show(newValue);
        });
    },
    mounted() {
        if (this.value) {
            this.album.show(this.value);
        }
    },
    methods: {
        clear() {
            this.albums.query.q = '';
        },
        update(id) {
            this.form[this.column] = id;
            this.clear();
            this.emitEvent();
        },
    },
    components: {},
    template: html
}