import index from 'belt/clip/js/components/attachments/ctlr/index';
import edit  from 'belt/clip/js/components/attachments/ctlr/edit';
import resizes  from 'belt/clip/js/components/attachments/ctlr/resizes';
import tags  from 'belt/clip/js/components/attachments/ctlr/tags';

export default [
    {path: '/attachments', component: index, canReuse: false, name: 'attachments'},
    {path: '/attachments/edit/:id', component: edit, name: 'attachments.edit'},
    {path: '/attachments/edit/:id/tags', component: tags, name: 'attachments.tags'},
    {path: '/attachments/edit/:id/resizes', component: resizes, name: 'attachments.resizes'},
]