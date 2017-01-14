export default `
    <div class="row">
        <div class="col-md-12">
            <form role="form" class="form-inline pull-right">
                <div class="form-group">
                    <input type="text" class="form-control" v-model.trim="query.q" v-on:keyup="paginateNot({perPage:6})" placeholder="search">
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <file-uploader 
                :disk=uploader_disk
                :path=uploader_path
                :multiple=uploader_multiple
            ></file-uploader>
        </div>
        <hr/>
        <div class="col-md-12">
            <div v-if="items" class="clearfix">
                <div v-for="file in detached">
                    <span class="pull-left"><img class="img-thumbnail" :src="file.src" style="max-height: 100px" v-on:click="attach(file.id)" /></span>
                </div>
            </div>
        </div>
        <div class="col-md-12">
           <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>
                            Name
                            <column-sorter :column="'files.name'"></column-sorter>
                        </th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>                
                    <tr v-for="file in attached">
                        <td><img class="img-thumbnail" :src="file.src" style="max-height: 140px" /></td>
                        <td>{{ file.name }}</td>
                        <td class="text-right">
                            <a class="btn btn-xs btn-primary" v-on:click="moveUp(file.id)"><i class="fa fa-arrow-up"></i></a>
                            <a class="btn btn-xs btn-danger" v-on:click="detach(file.id)"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <pagination></pagination>
        </div>
    </div>
`;