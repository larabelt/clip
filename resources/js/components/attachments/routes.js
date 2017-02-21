import index from './ctlr/index';
import create from './ctlr/create';
import edit  from './ctlr/edit';

export default [
    {path: '/attachments', component: index, canReuse: false, name: 'attachments'},
    {path: '/attachments/create', component: create, name: 'attachments.create'},
    {path: '/attachments/edit/:id', component: edit, name: 'attachments.edit'},
]