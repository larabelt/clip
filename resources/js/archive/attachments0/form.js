import BaseForm from 'belt/core/js/helpers/form';
import BaseService from 'belt/core/js/helpers/service';

class AttachmentForm extends BaseForm {

    constructor(options = {}) {
        super(options);
        this.service = new BaseService({baseUrl: '/api/v1/attachments/'});
        //this.routeEditName = 'pages.edit';
        this.setData({
            id: '',
            title: '',
            note: '',
            credits: '',
            alt: '',
            target_url: '',
        })
    }

}

export default AttachmentForm;