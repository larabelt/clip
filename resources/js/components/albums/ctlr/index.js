// helpers
import Table from 'belt/clip/js/components/albums/table';

// templates make a change
import heading_html from 'belt/core/js/templates/heading.html';
import index_html from 'belt/clip/js/components/albums/templates/index.html';

export default {

    components: {
        heading: {template: heading_html},
        index: {
            data() {
                return {
                    table: new Table({router: this.$router}),
                }
            },
            mounted() {
                this.table.updateQueryFromRouter();
                this.table.index();
            },
            template: index_html,
        },
    },

    template: `
        <div>
            <heading>
                <span slot="title">Album Manager</span>
            </heading>
            <section class="content">
                <index></index>
            </section>
        </div>
        `
}