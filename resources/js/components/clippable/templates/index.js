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
        <div class="row" v-for="attachment, index in attached">
            <div class="col-sm-2">
                <img class="img-thumbnail" :src="attachment.src" style="max-height: 140px;" />                
            </div>
            <div class="col-sm-9">
                <div v-if="item.id == attachment.id">
                    <clippable-edit></clippable-edit>
                </div>
                <div v-else>
                    <div class="row">
                        <div class="col-md-3">
                            <table class="table table-bordered table-condensed">
                                <tbody>
                                    <tr>
                                        <td><strong>ID</strong></td>
                                        <td>{{ attachment.id }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Driver</strong></td>
                                        <td>{{ attachment.driver }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Mimetype</strong></td>
                                        <td>{{ attachment.mimetype }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Size</strong></td>
                                        <td>{{ attachment.readable_size }}</td>
                                    </tr>
                                    <tr v-if=attachment.width>
                                        <td><strong>W x H</strong></td>
                                        <td>{{ attachment.width }} x {{ attachment.height }}</td>
                                    </tr>
                                    <tr v-if="attachment.resizes.length > 0">
                                        <td><strong>Attachments</strong></td>
                                        <td>
                                            <div v-for="resize in attachment.resizes">
                                                <a :href=resize.secure>{{ resize.preset }}</a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-9">
                            <table>
                                <tr v-if=attachment.title>
                                    <td colspan="100%"><strong>{{ attachment.title }}</strong></td>
                                </tr>
                                <tr v-if=attachment.note>
                                    <td colspan="100%">{{ attachment.note }}</td>
                                </tr>
                                <tr v-if=attachment.credits>
                                    <td><em>Credits:</em> </td>
                                    <td>{{ attachment.credits }}</td>
                                </tr>
                                <tr v-if=attachment.alt>
                                    <td><em>Alt:</em> </td>
                                    <td>{{ attachment.alt }}</td>
                                </tr>
                                <tr v-if=attachment.target_url>
                                    <td><em>Target Url:</em> </td>
                                    <td>{{ attachment.target_url }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-1">
                <div class="btn-group pull-right">
                    <a class="btn btn-xs btn-primary" @click="edit(attachment)"><i class="fa fa-edit"></i></a>
                    <a class="btn btn-xs btn-danger" @click="detach(attachment.id)"><i class="fa fa-trash"></i></a>
                </div>
            </div>
        </div>
        <pagination></pagination>
    </div>
`;