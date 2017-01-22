import fileableIndex from './fileable-index';
import fileableEdit from './fileable-edit';
import fileableSearch from './fileable-search';
import fileableSort from './fileable-sort';
import mode from 'ohio/core/js/mixins/base/mode';

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
            fileable_type: this.$parent.morphable_type,
            fileable_id: this.$parent.morphable_id,
        }
    },
    components: {
        fileableIndex,
        fileableEdit,
        fileableSearch,
        fileableSort,
    },
    methods: {

    },
    template: `
        <div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title pull-left">Files</h3>
                    <div class="pull-right">
                        <a class="btn btn-default" v-bind:class="{ 'btn-primary': isMode('sort') }"    @click="setMode('sort')"><i class="fa fa-random"></i></a>
                        <a class="btn btn-default" v-bind:class="{ 'btn-primary': isMode('search') }"  @click="setMode('search')"><i class="fa fa-search"></i></a>
                        <a class="btn btn-default" v-bind:class="{ 'btn-primary': isMode('default') }" @click="setMode('default')"><i class="fa fa-bars"></i></a>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-body">
                        <div v-if="isMode('default')" >
                            <fileable-index   
                                :uploader_driver=uploader_driver
                                :uploader_path=uploader_path
                                :uploader_multiple=uploader_multiple
                            ></fileable-index>
                        </div>
                        <div v-if="isMode('edit')" >
                            <fileable-edit></fileable-edit>
                        </div>
                        <div v-if="isMode('search')" >
                            <fileable-search></fileable-search>
                        </div>
                        <div v-if="isMode('sort')" >
                            <fileable-sort></fileable-sort>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `
}