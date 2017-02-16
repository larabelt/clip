export default `
<form role="form">

    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group" v-bind:class="{ 'has-error': errors.name }">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" v-model.trim="item.name" placeholder="name">
                        <span class="help-block" v-show="errors.name">{{ errors.name }}</span>
                    </div>
                    <div class="form-group" v-bind:class="{ 'has-error': errors.line1 }">
                        <label for="line1">Address, Line 1</label>
                        <input type="text" class="form-control" v-model.trim="item.line1" placeholder="line 1">
                        <span class="help-block" v-show="errors.line1">{{ errors.line1 }}</span>
                    </div>
                    <div class="form-group" v-bind:class="{ 'has-error': errors.line2 }">
                        <label for="line2">Address, Line 2</label>
                        <input type="text" class="form-control" v-model.trim="item.line2" placeholder="line 2">
                        <span class="help-block" v-show="errors.line2">{{ errors.line2 }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div v-if="item.id" class="form-group" v-bind:class="{ 'has-error': errors.nickname }">
                        <label for="nickname">Nickname</label>
                        <input type="text" class="form-control" v-model.trim="item.nickname" placeholder="nickname">
                        <span class="help-block" v-show="errors.nickname">{{ errors.nickname }}</span>
                    </div>
                    <div class="form-group" v-bind:class="{ 'has-error': errors.lat }">
                        <label for="lat">Latitude</label>
                        <input type="text" class="form-control" v-model.trim="item.lat" placeholder="latitude">
                        <span class="help-block" v-show="errors.lat">{{ errors.lat }}</span>
                    </div>
                    <div class="form-group" v-bind:class="{ 'has-error': errors.lng }">
                        <label for="lng">Longitude</label>
                        <input type="text" class="form-control" v-model.trim="item.lng" placeholder="longitude">
                        <span class="help-block" v-show="errors.lng">{{ errors.lng }}</span>
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group" v-bind:class="{ 'has-error': errors.locality }">
                        <label for="locality">City</label>
                        <input type="text" class="form-control" v-model.trim="item.locality" placeholder="city">
                        <span class="help-block" v-show="errors.locality">{{ errors.locality }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group" v-bind:class="{ 'has-error': errors.region }">
                        <label for="region">State</label>
                        <input type="text" class="form-control" v-model.trim="item.region" placeholder="state">
                        <span class="help-block" v-show="errors.region">{{ errors.region }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group" v-bind:class="{ 'has-error': errors.postcode }">
                        <label for="postcode">Postcode</label>
                        <input type="text" class="form-control" v-model.trim="item.postcode" placeholder="postcode">
                        <span class="help-block" v-show="errors.postcode">{{ errors.postcode }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group" v-bind:class="{ 'has-error': errors.country }">
                        <label for="country">Country</label>
                        <input type="text" class="form-control" v-model.trim="item.country" placeholder="country">
                        <span class="help-block" v-show="errors.country">{{ errors.country }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <p v-if="item.id" class="bg-primary">Geo Bounding Box</p>
            <div v-if="item.id" class="row">
                <div class="col-md-6">
                    <div class="form-group" v-bind:class="{ 'has-error': errors.north_lat }">
                        <label for="north_lat">North Latitude</label>
                        <input type="text" class="form-control" v-model.trim="item.north_lat" placeholder="">
                        <span class="help-block" v-show="errors.north_lat">{{ errors.north_lat }}</span>
                    </div>
                    <div class="form-group" v-bind:class="{ 'has-error': errors.south_lat }">
                        <label for="south_lat">South Latitude</label>
                        <input type="text" class="form-control" v-model.trim="item.south_lat" placeholder="">
                        <span class="help-block" v-show="errors.south_lat">{{ errors.south_lat }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" v-bind:class="{ 'has-error': errors.west_lng }">
                        <label for="west_lng">West Longitude</label>
                        <input type="text" class="form-control" v-model.trim="item.west_lng" placeholder="">
                        <span class="help-block" v-show="errors.west_lng">{{ errors.west_lng }}</span>
                    </div>
                    <div class="form-group" v-bind:class="{ 'has-error': errors.east_lng }">
                        <label for="east_lng">East Longitude</label>
                        <input type="text" class="form-control" v-model.trim="item.east_lng" placeholder="">
                        <span class="help-block" v-show="errors.east_lng">{{ errors.east_lng }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div v-if="item.id == null">
        <div class="form-group" v-bind:class="{ 'has-error': errors.addressable_id }">
            <label for="addressable_id">Addressable Id</label>
            <input type="text" class="form-control" v-model.trim="item.addressable_id" placeholder="addressable_id">
            <span class="help-block" v-show="errors.addressable_id">{{ errors.addressable_id }}</span>
        </div>
        <div v-bind:class="{ 'has-error': errors.addressable_type }">
            <label for="addressable_type">Addressable Type</label>
            <input type="text" class="form-control" v-model.trim="item.addressable_type" placeholder="addressable_type">
            <span class="help-block" v-show="errors.addressable_type">{{ errors.addressable_type }}</span>
        </div>
        <br/>
    </div>
    
    <div class="text-right">
        <button type="submit" class="btn btn-primary" v-on:click="submit($event)">Save</button>
        <span v-show="saving">saving <i class="fa fa-spinner fa-spin"/></span>
        <span v-show="saved">saved <i class="fa fa-floppy-o"/></span>
    </div>
</form>
`