import headingTemplate from 'belt/core/js/templates/base/heading.html';
import placeService from './service';
import placeFormTemplate from './templates/form';

export default {
    components: {
        'heading': {
            data() {
                return {
                    title: 'Place Creator',
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
        },
    },
    template: `
        <div>
            <heading></heading>
            <section class="content">
                <div class="box">
                    <div class="box-body">
                        <place-form></place-form>
                    </div>
                </div>
            </section>
        </div>
        `
}