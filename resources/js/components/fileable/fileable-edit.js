import fileService from '../file/service';
import fileFormTemplate from '../file/templates/form';
import mode from 'belt/core/js/mixins/base/mode';

export default {
    mixins: [mode, fileService],
    data() {
        return {
            mode: this.$parent.mode,
            item: this.$parent.item,
            fileable_type: this.$parent.fileable_type,
            fileable_id: this.$parent.fileable_id,
        }
    },
    mounted() {

    },
    methods: {

    },
    template: fileFormTemplate,
}