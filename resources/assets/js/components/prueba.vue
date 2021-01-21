<template>
<main class="main">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
 <div id = app>
                    <GmapMap
                    :center="{lat: inicio , lng:fin}"
                    :zoom="8"
                    map-type-id="hybrid"
                    style="width: 500px; height:500px"
>
                    <GmapMarker
                    :key="index"
                    v-for="(m, index) in markers"
                    :position="m.position"
               
                    :clickable="true"
                    :draggable="true"
                    :mousewheel="true"
                    @click="openWindow"
                    

                    />
                    <GmapInfoWindow
                    @closeclick="window_open=false" 
                    :opened="window_open" 
                    :position="infowindow"
                    
                   :options="{
                  pixelOffset: {
                    width: 10,
                    height: 10
                  } 
                }"
                    />
                  <GmapInfoWindow/>
                    
                    </GmapMap>
                    
                </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</main>
</template>
<script>

export default {

    data()
    {
        return{
       inicio:20.182380492250974,
       fin:-90.13451586456678,
       markers:[
        {
            position: {lat:19.830073498894144,lng:-90.53314707610431}
        }
       ], 
       info_marker: null,
            infowindow: {lat: 10, lng: 10.0},
            window_open: false,
            
        }
    },
 
    computed:
    {
      marcadores: function()
        {
          this.getPosition().lat()+ " "+ this.getPosition().lng();
        }

    },
    methods:{
openWindow () {
            this.window_open = true
        },
        marcadores()
        {
          this.getPosition().lat()+ " "+ this.getPosition().lng();
        }
    }
}
</script>