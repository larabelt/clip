import headingTemplate from 'belt/core/js/templates/base/heading.html';
import addresseservice from './service';
import addressFormTemplate from './templates/form';

export default {
    components: {
        'heading': {
            data() {
                return {
                    title: 'Address Creator',
                    subtitle: '',
                    crumbs: [
                        {route: 'addressIndex', text: 'Addresses'}
                    ],
                }
            },
            'template': headingTemplate
        },
        'address-form': {
            mixins: [addresseservice],
            template: addressFormTemplate,
        },
    },
    template: `
        <div>
            <heading></heading>
            <section class="content">
                <div class="box">
                    <div class="box-body">
                        <address-form></address-form>
                    </div>
                </div>
            </section>
        </div>
        `
}