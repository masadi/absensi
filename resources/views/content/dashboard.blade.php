@extends('layouts/contentLayoutMaster')

@section('title', 'Beranda')

@section('vendor-style')
@role('administrator', session('semester_id'))
@else
@mapstyles
@endrole
@endsection
@section('content')
@role('administrator', session('semester_id'))
<livewire:statistik /> 
@else
<livewire:dashboard /> 
@endrole
@endsection
@section('vendor-script')
@role('administrator', session('semester_id'))
@else
@mapscripts
@endrole
@endsection
@section('page-script')
@role('administrator', session('semester_id'))
@else
<script src="{{ asset('leaflet/leaflet-providers.js') }}"></script>
<script>
var map;
var markers;
window.addEventListener('LaravelMaps:MapInitialized', function (event) {
   var element = event.detail.element;
   map = event.detail.map;
   markers = event.detail.markers;
   var service = event.detail.service;
   L.tileLayer.provider('Esri.WorldImagery').addTo(map);
   navigator.geolocation.getCurrentPosition(success, error, options);
});
window.addEventListener('LaravelMaps:MarkerClicked', function (event) {
    var element = event.detail.element;
    var map = event.detail.map;
    var marker = event.detail.marker;
    var service = event.detail.service;

});
const options = {
  enableHighAccuracy: true,
  timeout: 5000,
  maximumAge: 0
};

function success(pos) {
  const crd = pos.coords;

  map.setView([crd.latitude, crd.longitude]);
  var markerFrom = L.circleMarker([markers[0]._latlng.lat, markers[0]._latlng.lng], { color: "#F00", radius: 10 });
  var markerTo =  L.circleMarker([crd.latitude, crd.longitude], { color: "#4AFF00", radius: 10 });
  var from = markerFrom.getLatLng();
  var to = markerTo.getLatLng();
  var jarak = getDistance(from, to);
  Livewire.emit('postAdded', jarak)
  var latlngs = Array();
  latlngs.push(from);
  latlngs.push(to);
  var polyline = L.polyline(latlngs, {color: 'red'}).addTo(map);
  map.fitBounds(polyline.getBounds());
  let hitungAkurasi = L.marker([crd.latitude, crd.longitude]).addTo(map);
  hitungAkurasi.bindPopup("Akurasi: "+crd.accuracy+" meter <br>"+jarak).openPopup();
}

function error(err) {
  console.warn(`ERROR(${err.code}): ${err.message}`);
}
function getDistance(from, to)
{
  return (from.distanceTo(to)).toFixed(0)/1000 * 1000;
  return ("Jarak Anda ke Sekolah: " + (from.distanceTo(to)).toFixed(0)/1000) + ' km';
}
</script>
@endrole
@endsection