export default {
    data() {
        return {
            morphable_type: 'albums',
            morphable_id: this.$parent.morphable_id,
            album: this.$parent.album,
        }
    },
}