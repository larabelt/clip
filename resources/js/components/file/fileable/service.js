window.$ = window.jQuery = require('jquery');

import form from 'ohio/core/js/mixins/base/forms';

export default {

    mixins: [form],

    data() {
        return {
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
            let url = this.fullUrl + '?' + $.param(this.query);
            this.$http.get(url).then(function (response) {
                this.attached = response.data.data;
                this.paginator = this.setPaginator(response);
            }, function (response) {
                console.log('error');
            });
        },
        paginateNot(query) {

            this.query = _.merge(this.query, query);
            this.query = _.merge(this.query, {not: 1});

            if (this.query.q.length == 0) {
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
                this.paginateNot();
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

        onFileChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.createImage(files[0]);
        },
        createImage(file) {
            var image = new Image();
            var reader = new FileReader();
            var vm = this;

            reader.onload = (e) => {
                vm.image = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        removeImage: function (e) {
            this.image = '';
        }


    }
};