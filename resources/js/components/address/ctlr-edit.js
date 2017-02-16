import headingTemplate from 'belt/core/js/templates/base/heading.html';
import addressService from './service';
import addressFormTemplate from './templates/form';

export default {
    components: {
        'heading': {
            data() {
                return {
                    title: 'Address Editor',
                    subtitle: '',
                    crumbs: [
                        {route: 'addressIndex', text: 'Addresses'}
                    ],
                }
            },
            'template': headingTemplate
        },
        'address-form': {
            mixins: [addressService],
            template: addressFormTemplate,
            mounted() {
                this.item.id = this.$route.params.id;
                this.get();
            },
        },
    },
    template: `
        <div>
            <heading></heading>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs pull-right">
                                <li class="active"><a href="#tab_1-1" data-toggle="tab" aria-expanded="false">Main</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1-1">
                                    <address-form></address-form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        `
}