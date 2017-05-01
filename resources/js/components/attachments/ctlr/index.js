import uploader from '../../base/uploader/ctlr';
import Table from '../table';
import heading_html from 'belt/core/js/templates/heading.html';
import index_html from '../templates/index.html';
import uploader_html from '../../base/uploader/template.html';

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
            </heading>
            <section class="content">
                <index></index>
            </section>
        </div>
        `
}