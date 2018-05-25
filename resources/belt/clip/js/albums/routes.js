import index from 'belt/clip/js/albums/ctlr/index';
import create from 'belt/clip/js/albums/ctlr/create';
import edit  from 'belt/clip/js/albums/ctlr/edit';
import attachments  from 'belt/clip/js/albums/ctlr/attachments';
import terms  from 'belt/clip/js/albums/ctlr/terms';

export default [
    {path: '/albums', component: index, canReuse: false, name: 'albums'},
    {path: '/albums/create', component: create, name: 'albums.create'},
    {path: '/albums/edit/:id', component: edit, name: 'albums.edit'},
    {path: '/albums/edit/:id/attachments', component: attachments, name: 'albums.attachments'},
    {path: '/albums/edit/:id/terms', component: terms, name: 'albums.terms'},
]