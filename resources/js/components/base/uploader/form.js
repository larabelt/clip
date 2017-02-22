import BaseForm from 'belt/core/js/helpers/form';
import BaseService from 'belt/core/js/helpers/service';

class UploaderForm extends BaseForm {

    constructor(options = {}) {
        super(options);
        this.service = new BaseService({baseUrl: '/api/v1/attachments/'});
        this.reset();
    }

    /**
     * Reset the form fields.
     */
    reset() {
        this.setData({
            id: '',
            driver: '',
            path: '',
            file: '',
        });

        this.errors.clear();
    }

}

export default UploaderForm;