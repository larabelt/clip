import index from './ctlr/index';
import create from './ctlr/create';
import edit  from './ctlr/edit';
import attachments  from './ctlr/attachments';

export default [
    {path: '/albums', component: index, canReuse: false, name: 'albums'},
    {path: '/albums/create', component: create, name: 'albums.create'},
    {path: '/albums/edit/:id', component: edit, name: 'albums.edit'},
    {path: '/albums/edit/:id/attachments', component: attachments, name: 'albums.attachments'},
]