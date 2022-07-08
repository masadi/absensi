@extends('layouts/contentLayoutMaster')

@section('title', 'Beranda')

@section('vendor-style')
@mapstyles
@endsection
@section('vendor-script')
@mapscripts
@endsection
@section('content')
<livewire:dashboard /> 
<!-- Kick start -->

<!--/ Kick start -->

<!-- Page layout -->
<div class="card">
  <div class="card-header">
    <h4 class="card-title">What is page layout?</h4>
  </div>
  <div class="card-body">
    <div id="distance">ini</div>
    <div class="card-text">
      <p>
        Starter kit includes pages with different layouts, useful for your next project to start development process
        from scratch with no time.
      </p>
      <ul>
        <li>Each layout includes required only assets only.</li>
        <li>
          Select your choice of layout from starter kit, customize it with optional changes like colors and branding,
          add required dependency only.
        </li>
      </ul>
      <div class="alert alert-primary" role="alert">
        <div class="alert-body">
          <strong>Info:</strong> Please check the &nbsp;<a
            class="text-primary"
            href="https://pixinvent.com/demo/vuexy-html-bootstrap-admin-template/documentation/documentation-layouts.html#layout-collapsed-menu"
            target="_blank"
            >Layout documentation</a
          >&nbsp; for more layout options i.e collapsed menu, without menu, empty & blank.
        </div>
      </div>
    </div>
  </div>
</div>
<!--/ Page layout -->
@endsection
@section('page-script')
<script>
var map;
var markers;
window.addEventListener('LaravelMaps:MapInitialized', function (event) {
   var element = event.detail.element;
   map = event.detail.map;
   markers = event.detail.markers;
   var service = event.detail.service;
   L.tileLayer.provider('Esri.WorldImagery').addTo(map);
   //map.locate({setView: true, maxZoom: 16});
   //console.log(markers[0]._latlng.lng);
   //map.setView([48.8584, 2.2945], 16);
   //console.log('map initialized', element, map, markers, service);
});
window.addEventListener('LaravelMaps:MarkerClicked', function (event) {
    var element = event.detail.element;
    var map = event.detail.map;
    var marker = event.detail.marker;
    var service = event.detail.service;
    //console.log('marker clicked', element, map, marker, service);
});
const options = {
  enableHighAccuracy: true,
  timeout: 5000,
  maximumAge: 0
};

function success(pos) {
  const crd = pos.coords;

  console.log('Your current position is:');
  console.log(`Latitude : ${crd.latitude}`);
  console.log(`Longitude: ${crd.longitude}`);
  console.log(`More or less ${crd.accuracy} meters.`);
  map.setView([crd.latitude, crd.longitude], 26);
  var markerFrom = L.circleMarker([markers[0]._latlng.lat, markers[0]._latlng.lng], { color: "#F00", radius: 10 });
  var markerTo =  L.circleMarker([crd.latitude, crd.longitude], { color: "#4AFF00", radius: 10 });
  var from = markerFrom.getLatLng();
  var to = markerTo.getLatLng();
  var jarak = getDistance(from, to);
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
navigator.geolocation.getCurrentPosition(success, error, options);
function getDistance(from, to)
{
  return ("Jarak Anda ke Sekolah: " + (from.distanceTo(to)).toFixed(0)/1000) + ' km';
}
</script>
@endsection