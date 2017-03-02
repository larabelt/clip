// components
import uploader from '../../base/uploader/ctlr';

// helpers
import Table from '../table';

// templates make a change
import heading_html from 'belt/core/js/templates/heading.html';
import index_html from '../templates/index.html';
import uploader_html from '../../base/uploader/template.html';

export default {

    components: {
        heading: {template: heading_html},
        index: {
            data() {
                return {
                    table: new Table({router: this.$router, query: {sortBy: 'desc'}}),
                }
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
                <span slot="title">Attachment Manager</span>
            </heading>
            <section class="content">
                <index></index>
            </section>
        </div>
        `
}