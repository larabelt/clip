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
            <hr/>
            <div class="col-md-12" v-for="file, index in attached">
                <div class="col-sm-2">
                    <img class="img-thumbnail" :src="file.src" style="max-height: 140px;" />
                </div>
                <div class="col-sm-8">
                    <div v-if="item.id == file.id">
                        <fileable-edit></fileable-edit>
                    </div>
                    <div v-else>
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
                <div class="col-sm-2">
                    <div class="btn-group pull-right">
                        <a class="btn btn-xs btn-primary" @click="edit(file)"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-xs btn-danger" @click="detach(file.id)"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <pagination></pagination>
    </div>
`;