import headingTemplate from 'belt/core/js/templates/base/heading.html';
import attachmentService from './service';
import attachmentIndexTemplate from './templates/index';

export default {

    components: {
        'heading': {
            data() {
                return {
                    title: 'Attachment Manager',
                    subtitle: '',
                    crumbs: [],
                }
            },
            'template': headingTemplate
        },
        'attachment-index': {
            mixins: [attachmentService],
            template: attachmentIndexTemplate,
            mounted() {
                this.query = this.getUrlQuery();
                this.paginate();
            },
        },
    },

    template: `
        <div>
            <heading></heading>
            <section class="content">
                <attachment-index></attachment-index>
            </section>
        </div>
        `
}