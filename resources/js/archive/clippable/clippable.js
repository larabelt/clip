import clippableIndex from './clippable-index';
import clippableEdit from './clippable-edit';
import clippableSearch from './clippable-search';
import clippableSort from './clippable-sort';
import mode from 'belt/core/js/mixins/base/mode';

export default {
    mixins: [mode],
    props: {
        uploader_driver: {default: ''},
        uploader_path: {default: ''},
        uploader_multiple: {default: true},
    },
    data() {
        return {
            mode: 'default',
            clippable_type: this.$parent.morphable_type,
            clippable_id: this.$parent.morphable_id,
        }
    },
    components: {
        clippableIndex,
        clippableEdit,
        clippableSearch,
        clippableSort,
    },
    methods: {

    },
    template: `
        <div>
            <div class="box-body">
                <div class="pull-right">
                    <a class="btn btn-default" v-bind:class="{ 'btn-primary': isMode('sort') }"    @click="setMode('sort')"    title="sort"><i class="fa fa-random"></i></a>
                    <a class="btn btn-default" v-bind:class="{ 'btn-primary': isMode('search') }"  @click="setMode('search')"  title="search"><i class="fa fa-search"></i></a>
                    <a class="btn btn-default" v-bind:class="{ 'btn-primary': isMode('default') }" @click="setMode('default')" title="upload/edit"><i class="fa fa-bars"></i></a>
                </div>
            </div>
            <div class="box-body">
                <div v-if="isMode('default')" >
                    <clippable-index   
                        :uploader_driver=uploader_driver
                        :uploader_path=uploader_path
                        :uploader_multiple=uploader_multiple
                    ></clippable-index>
                </div>
                <div v-if="isMode('edit')" >
                    <clippable-edit></clippable-edit>
                </div>
                <div v-if="isMode('search')" >
                    <clippable-search></clippable-search>
                </div>
                <div v-if="isMode('sort')" >
                    <clippable-sort></clippable-sort>
                </div>
            </div>
        </div>
        `
}