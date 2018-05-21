import Table from 'belt/clip/js/albums/table';
import Form from 'belt/clip/js/albums/form';

import index_html from 'belt/clip/js/albums/templates/index.html';

export default {

    components: {

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
            methods: {
                filter: _.debounce(function (query) {
                    if (query) {
                        query.page = 1;
                        this.table.updateQuery(query);
                    }
                    this.table.index()
                        .then(() => {
                            //this.table.pushQueryToHistory();
                            this.table.pushQueryToRouter();
                        });
                }, 750),
                copy(id) {
                    let form = new Form();
                    form.service.baseUrl = '/api/v1/albums/?source=' + id;
                    form.router = this.$router;
                    form.submit();
                }
            },
            template: index_html,
        },
    },

    template: `
        <div>
            <heading>
                <span slot="title">Album Manager</span>
                <li><router-link :to="{ name: 'albums' }">Album Manager</router-link></li>
            </heading>
            <section class="content">
                <index></index>
            </section>
        </div>
        `
}