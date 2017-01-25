import headingTemplate from 'ohio/core/js/templates/base/heading';
import fileService from './service';
import fileIndexTemplate from './templates/index';

export default {

    components: {
        'heading': {
            data() {
                return {
                    title: 'File Manager',
                    subtitle: '',
                    crumbs: [],
                }
            },
            'template': headingTemplate
        },
        'file-index': {
            mixins: [fileService],
            template: fileIndexTemplate,
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
                <file-index></file-index>
            </section>
        </div>
        `
}