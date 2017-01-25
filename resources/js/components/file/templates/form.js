export default `
    <form role="form">
        <div class="form-group" v-bind:class="{ 'has-error': errors.title }">
            <label for="title">Title</label>
            <input type="name" class="form-control" v-model.trim="item.title"  placeholder="title">
            <span class="help-block" v-show="errors.title">{{ errors.title }}</span>
        </div>
        <div class="form-group" v-bind:class="{ 'has-error': errors.note }">
            <label for="note">Note</label>
            <textarea class="form-control" rows="10" v-model="item.note"></textarea>
            <span class="help-block" v-show="errors.note">{{ errors.note }}</span>
        </div>
        <div class="form-group" v-bind:class="{ 'has-error': errors.credits }">
            <label for="credits">Credits</label>
            <input type="name" class="form-control" v-model.trim="item.credits"  placeholder="credits">
            <span class="help-block" v-show="errors.credits">{{ errors.credits }}</span>
        </div>
        <div class="form-group" v-bind:class="{ 'has-error': errors.alt }">
            <label for="alt">Alt</label>
            <input type="name" class="form-control" v-model.trim="item.alt"  placeholder="alt">
            <span class="help-block" v-show="errors.alt">{{ errors.alt }}</span>
        </div>
        <div class="form-group" v-bind:class="{ 'has-error': errors.target_url }">
            <label for="target_url">Target Url</label>
            <input type="name" class="form-control" v-model.trim="item.target_url"  placeholder="target_url">
            <span class="help-block" v-show="errors.target_url">{{ errors.target_url }}</span>
        </div>
        <div class="text-right">
            <span v-show="saving">saving <i class="fa fa-spinner fa-spin" /></span>
            <span v-show="saved">saved <i class="fa fa-floppy-o" /></span>
            <button type="submit" class="btn btn-primary" @click="submit($event)">Save</button>
        </div>
    </form>
`