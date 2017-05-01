import index from './ctlr/index';
import edit  from './ctlr/edit';
import tags  from './ctlr/tags';

export default [
    {path: '/attachments', component: index, canReuse: false, name: 'attachments'},
    {path: '/attachments/edit/:id', component: edit, name: 'attachments.edit'},
    {path: '/attachments/edit/:id/tags', component: tags, name: 'attachments.tags'},
]