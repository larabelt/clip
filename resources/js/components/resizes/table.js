import BaseTable from 'belt/core/js/helpers/table';
import BaseService from 'belt/core/js/helpers/service';

class ResizeTable extends BaseTable {

    constructor(options = {}) {
        super(options);
        let baseUrl = `/api/v1/attachments/${this.morphable_id}/resizes/`;
        this.service = new BaseService({baseUrl: baseUrl});
        this.query.perPage = 999;
    }

}

export default ResizeTable;