import BaseForm from 'belt/core/js/helpers/form';
import BaseService from 'belt/core/js/helpers/service';

class Form extends BaseForm {

    /**
     * Create a new Form instance.
     *
     * @param {object} options
     */
    constructor(options = {}) {
        super(options);
        let baseUrl = `/api/v1/attachments/${this.morphable_id}/resizes/`;
        this.service = new BaseService({baseUrl: baseUrl});
        this.reset();
    }

    /**
     * Reset the form fields.
     */
    reset() {
        this.setData({
            hasFile: false,
            id: '',
            driver: '',
            path: '',
            file: '',
            nickname: '',
        });

        this.errors.clear();
    }

}

export default Form;