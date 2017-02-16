import headingTemplate from 'belt/core/js/templates/base/heading.html';
import placeService from './service';
import placeFormTemplate from './templates/form';
import clippable from 'belt/clip/js/components/clippable/clippable';
import taggable from 'belt/content/js/components/tag/taggable/ctlr-edit';
import handleable from 'belt/content/js/components/handle/ctlr-edit';

export default {
    data() {
        return {
            morphable_type: 'places',
            morphable_id: this.$route.params.id,
        }
    },
    components: {
        'heading': {
            data() {
                return {
                    title: 'Place Editor',
                    subtitle: '',
                    crumbs: [
                        {route: 'placeIndex', text: 'Places'}
                    ],
                }
            },
            'template': headingTemplate
        },
        'place-form': {
            mixins: [placeService],
            template: placeFormTemplate,
            mounted() {
                this.item.id = this.$route.params.id;
                this.get();
            },
        },
        handleable,
        taggable,
        clippable,
    },
    template: `
        <div>
            <heading></heading>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs pull-right">
                                <li class="active"><a href="#tab_1-1" data-toggle="tab" aria-expanded="false">Main</a></li>
                                <li class=""><a href="#tab_2-2" data-toggle="tab" aria-expanded="false">Attachments</a></li>
                                <li class=""><a href="#tab_3-3" data-toggle="tab" aria-expanded="false">Handles</a></li>
                                <li class=""><a href="#tab_4-4" data-toggle="tab" aria-expanded="false">Tags</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1-1">
                                    <place-form></place-form>
                                </div>
                                <div class="tab-pane" id="tab_2-2">
                                    <clippable uploader_path="places"></clippable>
                                </div>
                                <div class="tab-pane" id="tab_3-3">
                                    <handleable></handleable>
                                </div>
                                <div class="tab-pane" id="tab_4-4">
                                    <taggable></taggable>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        `
}