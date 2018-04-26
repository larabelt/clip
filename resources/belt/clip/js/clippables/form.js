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

        let baseUrl = `/api/v1/${this.morphable_type}/${this.morphable_id}/attachments/`;

        this.service = new BaseService({baseUrl: baseUrl});
        this.setData({
            id: '',

            move: '',
            position_entity_id: '',

            team_id: '',
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
        });
    }

}

export default Form;