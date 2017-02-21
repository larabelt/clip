import uploader from '../../base/uploader';

// helpers
import Form from '../form';

// templates make a change
import heading_html from 'belt/core/js/templates/heading.html';
import form_html from '../templates/form.html';
import create_html from '../templates/create.html';

export default {
    props: {
        uploader_driver: {default: ''},
        uploader_path: {default: ''},
        uploader_multiple: {default: true},
    },
    components: {
        heading: {template: heading_html},
        uploader,
    },
    template: create_html
}