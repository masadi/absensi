<template>
  <div>
      <div class="col-12">
        <div class="openstreetmap">
          <l-map style="height: 550px" :zoom="zoom" :center="center" @click="onMapClick">
            <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
            <l-marker ref="marker" :lat-lng="[newLt, newLng]" :icon="icon">
              <l-popup ref="popup" :content="newLoc" :options="{ autoClose: false, closeOnClick: false }"></l-popup>
            </l-marker>
          </l-map>
        </div>
      </div>
  </div>
</template>

<script>
import {LMap, LTileLayer, LMarker, LPopup} from 'vue2-leaflet';
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'
export default {
  name: 'MapLeaflet',
  components: {
		LMap,
		LTileLayer,
		LMarker,
		LPopup,
	},
  data() {
    return {
      zoom:15,
			center: L.latLng(-7.195404, 113.250257),
			url:'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
			attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
			id: 'mapbox/streets-v11',
			newLoc: '',
			newLt : 0, 
			newLng : 0, 
			locations: [],
			icon: L.icon({iconUrl: 'null',}),
      line2coords: [],
      theMarker: {},
    }
  },
  created(){
    this.loadGeojson()
  },
    methods: {
      loadGeojson(){
        axios.get(`/api/sekolah/koordinat`, {
          params: {
            sekolah_id: user.sekolah_id,
            kode_wilayah : (user.sekolah) ? user.sekolah.kode_wilayah.trim() : null,
          }
        }).then((response) => {
          let getData = response.data
          if(!getData.geojson){
            return false
          }
          let centerData = getData.geojson.features[0].geometry.coordinates[0][0]
          this.$nextTick(() => {
            this.$refs.marker.mapObject.openPopup();
          });
          if(getData.data.lintang){
            this.center = L.latLng(getData.data.lintang, getData.data.bujur)
            this.locations = [{ name: getData.geojson.features[0].properties.NM_KEC,position: [centerData[1], centerData[0]] }]
            this.newLoc = 'Lokasi Anda yang tersimpan di database'
            this.newLt = getData.data.lintang
            this.newLng = getData.data.bujur
          } else {
            this.center = L.latLng(centerData[1], centerData[0])
            this.locations = [{ name: getData.geojson.features[0].properties.NM_KEC,position: [centerData[1], centerData[0]] }]
            this.newLoc = this.locations[0].name
            this.newLt = this.locations[0].position[0]
            this.newLng = this.locations[0].position[1]
          }
        })
      },
      onMapClick(e) {
        this.newLt = e.latlng.lat
        this.newLng = e.latlng.lng
        this.newLoc = 'Lokasi ini: '+(e.latlng.lat).toFixed(6)+','+(e.latlng.lng).toFixed(6)
        var markerFrom = L.circleMarker([-7.195404, 113.250257]);
        var markerTo =  L.circleMarker([e.latlng.lat,e.latlng.lng]);
        var from = markerFrom.getLatLng();
        var to = markerTo.getLatLng();
        //var jarak = this.hitungJarak(from, to)
        axios.post(`/api/referensi/simpan-koordinat`, {
          sekolah_id: user.sekolah_id,
          lintang : (e.latlng.lat).toFixed(6),
          bujur : (e.latlng.lng).toFixed(6),
          //jarak: jarak,
        }).then((response) => {
        })
		  },
    },
}
</script>