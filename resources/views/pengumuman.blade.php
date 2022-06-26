@extends('layouts.app_statis')
@section('title', 'Pengumuman Hasil')
@section('content')
<section>
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>PENGUMUMAN HASIL PPDB</h2>
            <p>Pengumuman Hasil Penerimaan Peserta Didik Baru (PPDB) Jenjang SD dan SMP Tahun Pelajaran {{ config('ppdb.tahun_pelajaran', '2022/2023') }}</p>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="main-example text-center">
                    <p>Pengumuman akan dibuka pada:</p>
                    <div class="countdown-container" id="main-example"></div>
                </div>
            </div>
        </div>
        <div class="row pengumuman" style="display: none;">
            <div class="col-12">
                <form id="form">
                    <div class="form-group row">
                        <label for="bentuk_pendidikan_id" class="col-sm-2 col-form-label">{{ __('Jenjang Pendaftaran') }}</label>
                        <div class="col-sm-10">
                            <select name="bentuk_pendidikan_id" id="bentuk_pendidikan_id" class="select2 form-control form-select-lg">
                                <option value="">== Pilih Jenjang Pendaftaran ==</option>
                                <option value="5" {{ (old('bentuk_pendidikan_id') == 5 ) ? 'selected' : '' }}>SD
                                </option>
                                <option value="6" {{ (old('bentuk_pendidikan_id') == 6 ) ? 'selected' : '' }}>SMP
                                </option>
                            </select>
                        </div>
                    </div>
                </form>
                <div id="result"></div>
            </div>
        </div>
    </div>
</section><!-- End Team Section -->
@endsection
@section('css')
<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Oswald">
<link href="{{asset('vendor/jquery.countdown-2.1.0/jquery.countdown.css')}}" rel="stylesheet" />
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.1/lodash.min.js"></script>
<script src="{{asset('vendor/jquery.countdown-2.1.0/jquery.countdown.min.js')}}"></script>
<script type="text/template" id="main-example-template">
    <div class="time <%= label %>">
        <span class="count curr top"><%= curr %></span>
        <span class="count next top"><%= next %></span>
        <span class="count next bottom"><%= next %></span>
        <span class="count curr bottom"><%= curr %></span>
        <span class="label"><%= label.length < 6 ? label : label.substr(0, 3)  %></span>
    </div>
</script>
<script>
$(document).ready( function () {
    var add_minutes =  function (dt, minutes) {
        return new Date(dt.getTime() + minutes*5000);
    }
    var dt = add_minutes(new Date(), 0);
    year  = dt.getFullYear();
    month = (dt.getMonth() + 1).toString().padStart(2, "0");
    day   = dt.getDate().toString().padStart(2, "0");
    hour = dt.getHours();
    minutes = dt.getMinutes();
    seconds = dt.getSeconds();
    var labels = ['Pekan', 'Hari', 'Jam', 'Menit', 'Detik'],
      nextYear = '2022/07/04 12:00:01',
      //nextYear = year+'/'+month+'/'+day+' '+hour+':'+minutes+':'+seconds,
      template = _.template($('#main-example-template').html()),
      currDate = '00:00:00:00:00',
      nextDate = '00:00:00:00:00',
      parser = /([0-9]{2})/gi,
      $example = $('#main-example');
      console.log(nextYear);
    // Parse countdown string to an object
    function strfobj(str) {
      var parsed = str.match(parser),
        obj = {};
      labels.forEach(function(label, i) {
        obj[label] = parsed[i]
      });
      return obj;
    }
    // Return the time components that diffs
    function diff(obj1, obj2) {
      var diff = [];
      labels.forEach(function(key) {
        if (obj1[key] !== obj2[key]) {
          diff.push(key);
        }
      });
      return diff;
    }
    // Build the layout
    var initData = strfobj(currDate);
    labels.forEach(function(label, i) {
      $example.append(template({
        curr: initData[label],
        next: initData[label],
        label: label
      }));
    });
    // Starts the countdown
    $example.countdown(nextYear)
    .on('update.countdown', function(event) {
        var newDate = event.strftime('%w:%d:%H:%M:%S'),
            data;
        if (newDate !== nextDate) {
            currDate = nextDate;
            nextDate = newDate;
            // Setup the data
            data = {
            'curr': strfobj(currDate),
            'next': strfobj(nextDate)
            };
            // Apply the new values to each node that changed
            diff(data.curr, data.next).forEach(function(label) {
            var selector = '.%s'.replace(/%s/, label),
                $node = $example.find(selector);
            // Update the node
            $node.removeClass('flip');
            $node.find('.curr').text(data.curr[label]);
            $node.find('.next').text(data.next[label]);
            // Wait for a repaint to then flip
            _.delay(function($node) {
                $node.addClass('flip');
            }, 50, $node);
            });
        }
    }).on('finish.countdown', function(event) {
        $(this).parent().html('');
        $('.pengumuman').show();
    });
    $('#bentuk_pendidikan_id').change(function(e){
        e.preventDefault();
        var ini = $(this).val();
        if(ini == ''){
            $('#result').html('')
            return false;
        }
        $.ajax({
            url: '{{route('api.get_pengumuman')}}',
            type: 'post',
            data: $("form#form").serialize(),
            success: function(response){
                $('#result').html(response)
            }
        });
    });
})
</script>
@endsection