export default `
    <div class="row">
        <div class="col-md-12">
           <div v-for="file, index in attached">
                <div @dragover.prevent @drop="drop">
                    <img class="img-thumbnail pull-left" :src="file.src" :data-index=index style="max-height: 100px" draggable="true" @drag="drag"/>
                </div>
            </div>
        </div>
    </div>
`;