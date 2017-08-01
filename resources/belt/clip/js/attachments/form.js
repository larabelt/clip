import BaseForm from 'belt/core/js/helpers/form';
import BaseService from 'belt/core/js/helpers/service';

class AttachmentForm extends BaseForm {

    constructor(options = {}) {
        super(options);
        this.service = new BaseService({baseUrl: '/api/v1/attachments/'});
        this.routeEditName = 'attachments.edit';
        this.setData({
            id: '',
            title: '',
            note: '',
            credits: '',
            alt: '',
            target_url: '',
            src: '',
            is_image: '',
            mimetype: '',
            size: '',
            readable_size: '',
            nickname: '',
            file: '',
            hasFile: true,
        })
    }

}

export default AttachmentForm;