import headingTemplate from 'belt/core/js/templates/base/heading.html';
import addresseservice from './service';
import addressIndexTemplate from './templates/index';

export default {

    components: {
        'heading': {
            data() {
                return {
                    title: 'Address Manager',
                    subtitle: '',
                    crumbs: [],
                }
            },
            'template': headingTemplate
        },
        'address-index': {
            mixins: [addresseservice],
            template: addressIndexTemplate,
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
                <address-index></address-index>
            </section>
        </div>
        `
}