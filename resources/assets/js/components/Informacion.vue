<template>
<main class="main">
    <div class="container-fluid">              
        <div class="card">
            <div class="card-header">
                <div id = app>
                    <GmapMap
                    :center="{lat: inicio , lng:fin}"
                    :zoom="8"
                    map-type-id="terrain"
                    style="width: 1300px; height:500px"
>
                    <GmapMarker
                    :key="index"
                    v-for="(m, index) in markers"
                    :position="m.position"
                    :clickable="true"
                    :draggable="false"
                    
                    @click="center=m.position"
                    />
                    </GmapMap>
                    
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
        markers:[{
            position: {lat:19.830073498894144,lng:-90.53314707610431}
        },{
            position: {lat:20.96910880930881, lng: -89.60340489390482}
        }]
        }
    },
 
    computed:
    {
        get_my_position: function()
        {
           
            navigator.geolocation.getCurrentPosition(function(position)
            {
                var geolocate = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                console.log();
            });
            
        },

        polylines: function()
        {
            const flightPath = new google.maps.polylines({
                path: this.markers,
                geodesic: true,
                strokeColor: "#FF0000",
                strokeOpacity: 1.0,
                strokeWeight: 2,
            });
            
        }
    }
}
</script>