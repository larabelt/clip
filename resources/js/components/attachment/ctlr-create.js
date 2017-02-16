import headingTemplate from 'belt/core/js/templates/base/heading.html';
import attachmentService from './service';
import attachmentFormTemplate from './templates/form';

export default {
    components: {
        'heading': {
            data() {
                return {
                    title: 'Attachment Creator',
                    subtitle: '',
                    crumbs: [
                        {route: 'attachmentIndex', text: 'Attachments'}
                    ],
                }
            },
            'template': headingTemplate
        },
        'attachment-form': {
            mixins: [attachmentService],
            template: attachmentFormTemplate,
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
                                <h3 class="box-title">Create Attachment</h3>
                            </div>
                            <attachment-form></attachment-form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        `
}