import uploader from 'belt/clip/js/base/uploader/ctlr';
import Table from 'belt/clip/js/attachments/table';

import index_html from 'belt/clip/js/attachments/templates/index.html';
import uploader_html from 'belt/clip/js/base/uploader/template.html';

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
            components: {
                uploader: {
                    mixins: [uploader],
                    methods: {
                        onUploadSuccess(attachment) {
                            this.$router.push({name: 'attachments.edit', params: {id: attachment.id}});
                        },
                    },
                    template: uploader_html
                },
            },
            template: index_html,
        },
    },

    template: `
        <div>
            <heading>
                <span slot="title">Attachment Manager</span>
                <li><router-link :to="{ name: 'attachments' }">Attachment Manager</router-link></li>
            </heading>
            <section class="content">
                <index></index>
            </section>
        </div>
        `
}