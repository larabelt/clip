import form from 'ohio/core/js/mixins/base/forms';
import positionable from 'ohio/core/js/mixins/base/positionable';

export default {

    mixins: [form, positionable],

    data() {
        return {
            perPage: 5,
            image: null,
            url: '/api/v1/fileables',
            fileable_type: '',
            fileable_id: null,
        }
    },
    computed: {
        fullUrl() {
            let url = this.url +
                '/' + this.fileable_type +
                '/' + this.fileable_id +
                '/';
            return url;
        }
    },
    methods: {
        paginate(query) {
            this.query = _.merge(this.query, query);
            this.query = _.merge(this.query, {not: 0});
            this.query = _.merge(this.query, {perPage: this.perPage});
            let url = this.fullUrl + '?' + $.param(this.query);
            this.$http.get(url).then(function (response) {
                this.attached = this.items = response.data.data;
                this.paginator = this.setPaginator(response);
            }, function (response) {
                console.log('error');
            });
        },
        paginateNot(query) {

            this.query = _.merge(this.query, query);
            this.query = _.merge(this.query, {not: 1});

            if (this.query.q == undefined || this.query.q.length == 0) {
                //this.paginate();
                return this.detached = [];
            }

            let url = this.fullUrl + '?' + $.param(this.query);
            this.$http.get(url).then(function (response) {
                this.detached = response.data.data;
            }, function (response) {
                console.log('error');
            });
        },
        attach(id) {
            this.errors = {};
            this.$http.post(this.fullUrl, {id: id}).then((response) => {
                this.paginate();
                this.paginateNot({perPage: 5});
            }, (response) => {
                if (response.status == 422) {
                    this.errors = response.data.message;
                }
            });
            this.saving = false;
        },
        detach(id) {
            this.$http.delete(this.fullUrl + id).then(function (response) {
                if (response.status == 204) {
                    this.paginate();
                }
            });
        },
        update(params) {
            this.errors = {};
            this.$http.put(this.fullUrl + this.item.id, params).then((response) => {
                this.item = response.data;
                this.saved = true;
                this.paginate();
            }, (response) => {
                if (response.status == 422) {
                    this.errors = response.data.message;
                }
            });
            this.saving = false;
        },

    }
};