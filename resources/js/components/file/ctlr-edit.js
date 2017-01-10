import headingTemplate from 'ohio/core/js/templates/base/heading';
import fileService from './service';
import fileFormTemplate from './templates/form';

export default {
    components: {
        'heading': {
            data() {
                return {
                    title: 'File Editor',
                    subtitle: '',
                    crumbs: [
                        {route: 'fileIndex', text: 'Manager'}
                    ],
                }
            },
            'template': headingTemplate
        },
        'file-form': {
            mixins: [fileService],
            template: fileFormTemplate,
            mounted() {
                this.item.id = this.$route.params.id;
                this.get();
            },
        },
    },
    template: `
        <div>
            <heading></heading>
            <section class="storage">
                <div class="row">
                    <div class="col-md-9">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit File</h3>
                            </div>
                            <file-form></file-form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        `
}