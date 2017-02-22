import index from './ctlr/index';
import edit  from './ctlr/edit';

export default [
    {path: '/attachments', component: index, canReuse: false, name: 'attachments'},
    {path: '/attachments/edit/:id', component: edit, name: 'attachments.edit'},
]