import fileService from '../file/service';
import fileFormTemplate from '../file/templates/form';
import mode from 'belt/core/js/mixins/base/mode';

export default {
    mixins: [mode, fileService],
    data() {
        return {
            mode: this.$parent.mode,
            item: this.$parent.item,
            clippable_type: this.$parent.clippable_type,
            clippable_id: this.$parent.clippable_id,
        }
    },
    mounted() {

    },
    methods: {

    },
    template: fileFormTemplate,
}