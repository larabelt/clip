export default `
    <div>
        <div class="row">
            <div class="col-md-12">
                <file-uploader 
                :driver=uploader_driver
                :path=uploader_path
                :multiple=uploader_multiple
                ></file-uploader>
            </div>
        </div>
        <div class="row" v-for="file, index in attached">
            <div class="col-sm-2">
                <img class="img-thumbnail" :src="file.src" style="max-height: 140px;" />                
            </div>
            <div class="col-sm-9">
                <div v-if="item.id == file.id">
                    <fileable-edit></fileable-edit>
                </div>
                <div v-else>
                    <div class="row">
                        <div class="col-md-3">
                            <table class="table table-bordered table-condensed">
                                <tbody>
                                    <tr>
                                        <td><strong>ID</strong></td>
                                        <td>{{ file.id }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Driver</strong></td>
                                        <td>{{ file.driver }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Mimetype</strong></td>
                                        <td>{{ file.mimetype }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Size</strong></td>
                                        <td>{{ file.readable_size }}</td>
                                    </tr>
                                    <tr v-if=file.width>
                                        <td><strong>W x H</strong></td>
                                        <td>{{ file.width }} x {{ file.height }}</td>
                                    </tr>
                                    <tr v-if="file.resizes.length > 0">
                                        <td><strong>Files</strong></td>
                                        <td>
                                            <div v-for="resize in file.resizes">
                                                <a :href=resize.secure>{{ resize.preset }}</a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-9">
                            <table>
                                <tr v-if=file.title>
                                    <td colspan="100%"><strong>{{ file.title }}</strong></td>
                                </tr>
                                <tr v-if=file.note>
                                    <td colspan="100%">{{ file.note }}</td>
                                </tr>
                                <tr v-if=file.credits>
                                    <td><em>Credits:</em> </td>
                                    <td>{{ file.credits }}</td>
                                </tr>
                                <tr v-if=file.alt>
                                    <td><em>Alt:</em> </td>
                                    <td>{{ file.alt }}</td>
                                </tr>
                                <tr v-if=file.target_url>
                                    <td><em>Target Url:</em> </td>
                                    <td>{{ file.target_url }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-1">
                <div class="btn-group pull-right">
                    <a class="btn btn-xs btn-primary" @click="edit(file)"><i class="fa fa-edit"></i></a>
                    <a class="btn btn-xs btn-danger" @click="detach(file.id)"><i class="fa fa-trash"></i></a>
                </div>
            </div>
        </div>
        <pagination></pagination>
    </div>
`;