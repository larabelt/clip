export default `
    <form place="form">
        <div class="form-group" v-bind:class="{ 'has-error': errors.name }">
            <label for="name">Name</label>
            <input type="name" class="form-control" v-model.trim="item.name"  placeholder="name">
            <span class="help-block" v-show="errors.name">{{ errors.name }}</span>
        </div>
        <div v-if="item.id" class="form-group" v-bind:class="{ 'has-error': errors.slug }">
            <label for="slug">Slug</label>
            <input type="slug" class="form-control" v-model.trim="item.slug"  placeholder="slug">
            <span class="help-block" v-show="errors.slug">{{ errors.slug }}</span>
        </div>
        <div class="form-group" v-bind:class="{ 'has-error': errors.intro }">
            <label for="intro">Intro</label>
            <textarea class="form-control" rows="10" v-model="item.intro"></textarea>
            <span class="help-block" v-show="errors.intro">{{ errors.intro }}</span>
        </div>
        <div class="form-group" v-bind:class="{ 'has-error': errors.body }">
            <label for="body">Body</label>
            <textarea class="form-control" rows="10" v-model="item.body"></textarea>
            <span class="help-block" v-show="errors.body">{{ errors.body }}</span>
        </div>
        <div class="form-group" v-bind:class="{ 'has-error': errors.hours }">
            <label for="hours">hours</label>
            <textarea class="form-control" rows="10" v-model="item.hours"></textarea>
            <span class="help-block" v-show="errors.hours">{{ errors.hours }}</span>
        </div>
        <div class="form-group" v-bind:class="{ 'has-error': errors.phone }">
            <label for="phone">Phone</label>
            <input type="phone" class="form-control" v-model.trim="item.phone"  placeholder="phone">
            <span class="help-block" v-show="errors.phone">{{ errors.phone }}</span>
        </div>
        <div class="form-group" v-bind:class="{ 'has-error': errors.email }">
            <label for="email">Email</label>
            <input type="email" class="form-control" v-model.trim="item.email"  placeholder="email">
            <span class="help-block" v-show="errors.email">{{ errors.email }}</span>
        </div>
        <div class="form-group" v-bind:class="{ 'has-error': errors.url }">
            <label for="url">Url</label>
            <input type="url" class="form-control" v-model.trim="item.url"  placeholder="url">
            <span class="help-block" v-show="errors.url">{{ errors.url }}</span>
        </div>
        <div class="form-group" v-bind:class="{ 'has-error': errors.meta_title }">
            <label for="meta_title">Meta Title</label>
            <input type="meta_title" class="form-control" v-model.trim="item.meta_title"  placeholder="meta_title">
            <span class="help-block" v-show="errors.meta_title">{{ errors.meta_title }}</span>
        </div>
        <div class="form-group" v-bind:class="{ 'has-error': errors.meta_keywords }">
            <label for="meta_keywords">Meta Keywords</label>
            <textarea class="form-control" rows="10" v-model="item.meta_keywords"></textarea>
            <span class="help-block" v-show="errors.meta_keywords">{{ errors.meta_keywords }}</span>
        </div>
        <div class="form-group" v-bind:class="{ 'has-error': errors.meta_keywords }">
            <label for="meta_keywords">Meta Keywords</label>
            <textarea class="form-control" rows="10" v-model="item.meta_keywords"></textarea>
            <span class="help-block" v-show="errors.meta_keywords">{{ errors.meta_keywords }}</span>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-primary" v-on:click="submit($event)">Save</button>
            <span v-show="saving">saving <i class="fa fa-spinner fa-spin" /></span>
            <span v-show="saved">saved <i class="fa fa-floppy-o" /></span>
        </div>
    </form>
`