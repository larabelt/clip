export default `
    <div class="row">
        <div class="col-md-12">
           <table class="table table-bordered table-hover">
                <tr>
                    <td><img class="img-thumbnail" :src="item.src" style="max-height: 140px" /></td>
                    <td>
                        <file-form :item="item"></file-form>
                    </td>
                    <td class="text-right">
                        <a class="btn btn-xs btn-danger" @click="detach(item.id)">save</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
`;