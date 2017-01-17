export default `
    <div class="row">
        <div class="col-md-6">
            <form role="form" class="form-inline">
                <div class="form-group">
                    <input type="text" class="form-control" v-model.trim="query.q" v-on:keyup="paginateNot({perPage:6})" placeholder="search">
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <div v-if="items" class="clearfix">
                <div v-for="file in detached">
                    <span class="pull-left"><img class="img-thumbnail" :src="file.src" style="max-height: 100px" v-on:click="attach(file.id)" /></span>
                </div>
            </div>
        </div>
        <div class="col-md-12">
           <h1>Attached Images</h1>
           <div v-for="file, index in attached">
                <img class="img-thumbnail pull-left" :src="file.src" :data-index=index style="max-height: 100px" />
            </div>
        </div>
    </div>
`;