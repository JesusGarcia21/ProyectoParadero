<template>
<main class="main">
    <div class="container-fluid">              
        <div class="card">
            <div class="card-header">
                
                <div class="google-map" ref="googleMap"></div>
                    <template v-if="Boolean(this.google) && Boolean(this.map)">
                    <slot
                        :google="google"
                        :map="map"
                    />
             </template>
               
            </div>
        </div>
    </div>
</main>
</template>
<script>
import GoogleMapsApiLoader from 'google-maps-api-loader'
export default {
    
     props: {
                mapConfig: Object,
                apiKey: String,
            },
     data(){
        return {
                    google: null,
                    map: null
                }
            },
    async mounted() {
    const googleMapApi = await GoogleMapsApiLoader({
      apiKey: this.apiKey
    })
    this.google = googleMapApi
    this.initializeMap()
  },
  
    methods:
    {
        initializeMap() {
      const mapContainer = this.$refs.googleMap
      this.map = new this.google.maps.Map(
        mapContainer, this.mapConfig
      )
    }
    }

}
</script>
