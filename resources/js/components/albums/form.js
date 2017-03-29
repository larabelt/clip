import BaseForm from 'belt/core/js/helpers/form';
import BaseService from 'belt/core/js/helpers/service';

class AlbumForm extends BaseForm {

    constructor(options = {}) {
        super(options);
        this.service = new BaseService({baseUrl: '/api/v1/albums/'});
        this.routeEditName = 'albums.edit';
        this.setData({
            id: '',
            user_id: '',
            team_id: '',
            name: '',
            slug: '',
            body: '',
            intro: '',
        })
    }

    getAttachmentId() {
        return this.attachment_id;
    }

}

export default AlbumForm;