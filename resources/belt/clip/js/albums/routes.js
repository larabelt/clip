import index from 'belt/clip/js/albums/ctlr/index';
import create from 'belt/clip/js/albums/ctlr/create';
import edit  from 'belt/clip/js/albums/ctlr/edit';
import attachments  from 'belt/clip/js/albums/ctlr/attachments';
import tags  from 'belt/clip/js/albums/ctlr/tags';

export default [
    {path: '/albums', component: index, canReuse: false, name: 'albums'},
    {path: '/albums/create', component: create, name: 'albums.create'},
    {path: '/albums/edit/:id', component: edit, name: 'albums.edit'},
    {path: '/albums/edit/:id/attachments', component: attachments, name: 'albums.attachments'},
    {path: '/albums/edit/:id/tags', component: tags, name: 'albums.tags'},
]