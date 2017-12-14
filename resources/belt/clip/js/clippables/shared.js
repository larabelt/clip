export default {
    computed: {
        active() {
            return this.$store.getters['clippable/active'];
        },
        attachments() {
            return this.table.items;
        },
        hasattachments() {
            return this.table.items.length;
        },
        hasHighlighted() {
            let highlighted = this.$store.getters['highlighted/data'];
            return !_.isEmpty(highlighted);
        },
        mode() {
            return this.$store.getters['clippable/mode'];
        },
        morphID() {
            return this.$store.getters['clippable/morphID'];
        },
        morphType() {
            return this.$store.getters['clippable/morphType'];
        },
        table() {
            return this.$store.getters['clippable/table'];
        },
    },
    methods: {
        attach(payload) {
            this.$store.dispatch('clippable/attach', payload)
                .then(() => {
                    this.$store.dispatch('clippable/load');
                    this.$store.dispatch('uploading/search_attachments/load');
                });
        },
        detachHighlighted() {
            let highlighted = this.$store.getters['highlighted/data'];
            for (let id in highlighted) {
                this.$store.dispatch('clippable/detach', id)
                    .then(() => {
                        this.$store.dispatch('clippable/load');
                        this.$store.dispatch('highlighted/forget', id);
                    });
            }
        },
        setEdit(attachment) {
            this.$store.dispatch('clippable/active', attachment);
            this.$store.dispatch('clippable/set', {mode: 'edit'});
            this.$router.push({name: 'clippables.edit', params: {attachment_id: attachment.id}});
        },
    },
};