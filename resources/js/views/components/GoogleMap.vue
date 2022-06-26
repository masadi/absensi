<template>
  <div>
    <GmapMap :center='center' :zoom='15' style='width:100%;  height: 400px;' @place_changed='setPlace'>
      <GmapMarker :key="index" v-for="(m, index) in markers" :position="m.position" @click="center=m.position" :clickable="true" :draggable="true" @dragend="updateCoordinates(m)"/>
    </GmapMap>
  </div>
</template>
<script>
  
export default {
  name: 'GoogleMap',
  data() {
    return {
      form: new Form({
        bujur: '',
        lintang: '',
      }),
      center: { lat: -7.195, lng: 113.250 },
      currentPlace: null,
      markers: [{
        position: {
          lat: -7.195,
          lng: 113.250
        }
      }],
      places: [],
    }
  },
  mounted() {
    this.geolocate();
  },
  methods: {
    setPlace(place) {
      this.currentPlace = place;
    },
    addMarker() {
      console.log(this.currentPlace);
      if (this.currentPlace) {
        const marker = {
          lat: this.currentPlace.geometry.location.lat(),
          lng: this.currentPlace.geometry.location.lng(),
        };
        this.markers.push({ position: marker });
        this.places.push(this.currentPlace);
        this.center = marker;
        this.currentPlace = null;
      }
    },
    updateCoordinates(location) {
      console.log(location);
      /*this.coordinates = {
        lat: location.latLng.lat(),
        lng: location.latLng.lng(),
      };*/
      axios.post(`/api/users/simpan-koordinat`, {
        user_id: user.user_id,
        lintang: location.position.lng,
        bujur: location.position.lat,
      }).then((response) => {
        this.form.bujur = location.position.lng
        this.form.lintang = location.position.lat
      });
    },
    geolocate: function() {
      console.log(this.currentPlace);
      navigator.geolocation.getCurrentPosition(position => {
        this.center = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
      });
    },
  },
};
</script>