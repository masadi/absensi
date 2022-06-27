@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard')

@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection
@section('page-style')
  {{-- Page css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/dashboard-ecommerce.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('content')
<!-- Dashboard Ecommerce Starts -->
<section id="dashboard-ecommerce">
  @role('admin')
  @livewire('dashboard-user')
  @endRole
</section>
<!-- Dashboard Ecommerce ends -->
@endsection

@section('vendor-script')
  {{-- vendor files --}}
  <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>
@endsection
@section('page-script')
  {{-- Page js files --}}
  <script>
    var perWilayah = $('.per_wilayah'),
    perAngkatan = $('.per_angkatan'),
    tooltipShadow = 'rgba(0, 0, 0, 0.25)',
    grid_line_color = 'rgba(200, 200, 200, 0.2)',
    labelColor = '#6e6b7b',
    successColorShade = '#28dac6';
    var options = {
        elements: {
          rectangle: {
            borderWidth: 2,
            borderSkipped: 'bottom'
          }
        },
        responsive: true,
        maintainAspectRatio: true,
        responsiveAnimationDuration: 500,
        legend: {
          display: false
        },
        tooltips: {
          // Updated default tooltip UI
          shadowOffsetX: 1,
          shadowOffsetY: 1,
          shadowBlur: 8,
          shadowColor: tooltipShadow,
          backgroundColor: window.colors.solid.white,
          titleFontColor: window.colors.solid.black,
          bodyFontColor: window.colors.solid.black
        },
        scales: {
          xAxes: [
            {
              display: true,
              gridLines: {
                display: true,
                color: grid_line_color,
                zeroLineColor: grid_line_color
              },
              scaleLabel: {
                display: false
              },
              ticks: {
                fontColor: labelColor
              }
            }
          ],
          yAxes: [
            {
              display: true,
              gridLines: {
                color: grid_line_color,
                zeroLineColor: grid_line_color
              },
              ticks: {
                stepSize: 100,
                min: 0,
                max: 400,
                fontColor: labelColor
              }
            }
          ]
        }
      }
    if(perWilayah.length){
      new Chart(perWilayah, {
        type: 'bar',
        options: options,
        data: {
          labels: ['SUMENEP', 'PAMEKASAN', 'SAMPANG', 'BANGKALAN', 'SURABAYA', 'SIDOARJO', 'PASURUAN', 'PROBOLINGGO', 'LUMAJANG', 'JEMBER'],
          datasets: [
            {
              data: [275, 90, 190, 205, 125, 85, 55, 87, 127, 150, 230, 280, 190],
              barThickness: 15,
              backgroundColor: successColorShade,
              borderColor: 'transparent'
            }
          ]
        }
      });
    }
    if(perAngkatan.length){
      new Chart(perAngkatan, {
        type: 'bar',
        options: options,
        data: {
          labels: ['2022', '2021', '2020 ', '2019', '2018', '2017', '2016', '2015', '2014', '2013'],
          datasets: [
            {
              data: [275, 90, 190, 205, 125, 85, 55, 87, 127, 150, 230, 280, 190],
              barThickness: 15,
              backgroundColor: window.colors.solid.info,
              borderColor: 'transparent'
            }
          ]
        }
      });
    }
  </script>
@endsection