export default `
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>
                                ID
                                <column-sorter :route="'addressIndex'" :column="'addresses.id'"></column-sorter>
                            </th>
                            <th>
                                Name
                                <column-sorter :route="'addressIndex'" :column="'addresses.name'"></column-sorter>
                            </th>
                            <th>Line1</th>
                            <th>
                                City
                                <column-sorter :route="'addressIndex'" :column="'addresses.locality'"></column-sorter>
                            </th>
                            <th>
                                State
                                <column-sorter :route="'addressIndex'" :column="'addresses.region'"></column-sorter>
                            </th>
                            <th>
                                Post Code
                                <column-sorter :route="'addressIndex'" :column="'addresses.postcode'"></column-sorter>
                            </th>
                            <th>
                                Country
                                <column-sorter :route="'addressIndex'" :column="'addresses.country'"></column-sorter>
                            </th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>                
                        <tr v-for="item in items">
                            <td>{{ item.id }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.line1 }}</td>
                            <td>{{ item.locality }}</td>
                            <td>{{ item.region }}</td>
                            <td>{{ item.postcode }}</td>
                            <td>{{ item.country }}</td>
                            <td class="text-right">
                                <router-link :to="{ name: 'addressEdit', params: { id: item.id } }" v-bind:class="'btn btn-xs btn-warning'">
                                    <i class="fa fa-edit"></i>
                                </router-link>
                                <a class="btn btn-xs btn-danger" v-on:click="destroy(item.id)"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Line1</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Post Code</th>
                            <th>Country</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <pagination :route="'addressIndex'"></pagination>
        </div>
    </div>
`;