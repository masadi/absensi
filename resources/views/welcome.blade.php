@extends('layouts.app_statis')
@section('title', 'Beranda')
@section('content')
<section id="jadwal" class="team section-bg">

    <div class="container" data-aos="fade-up">

        <div class="section-title">
            <h2>JADWAL KEGIATAN PPDB</h2>
            <p>Jadwal Pelaksanaan Penerimaan Peserta Didik Baru (PPDB) Jenjang SD dan SMP Tahun Pelajaran {{ config('ppdb.tahun_pelajaran', '2022/2023') }}
            </p>
        </div>

        <div class="row">

            <div class="col-lg-12">
                <div class="member d-flex align-items-start" data-aos="zoom-in" data-aos-delay="100">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Jenis Kegiatan</th>
                                    <th>Jadwal</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td>Pendaftaran</td>
                                    <td>27 Juni s.d 2 Juli 2022</td>
                                    <td>Online via <span class="badge badge-primary"> {{config('ppdb.domain', 'https://ppdb.sampangkab.go.id')}} </span></td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td> Pengumuman</td>
                                    <td>4 Juli 2022</td>
                                    <td>Online via <span class="badge badge-primary"> {{config('ppdb.domain', 'ttps://ppdbsampang.com')}} </span></td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td>Daftar Ulang </td>
                                    <td>5 s/d 12 Juli 2022</td>
                                    <td>- </td>
                                </tr>
                                <tr>
                                    <td>4.</td>
                                    <td>Pra MPLS </td>
                                    <td>13-14 Juli 2022</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>Permulaan Tahun Ajaran</td>
                                    <td>18 Juli 2022</td>
                                    <td>- </td>
                                </tr>
                                <tr>
                                    <td>6.</td>
                                    <td>MPLS </td>
                                    <td>18, 19, 20 Juli 2022</td>
                                    <td>-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</section><!-- End Team Section -->
<section id="peraturan" class="faq section-bg">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>peraturan ppdb</h2>
            <p>Petunjuk Teknis dan Aturan Penerimaan Peserta Didik Baru (PPDB) Jenjang SD dan SMP Tahun Pelajaran
               {{ config('ppdb.tahun_pelajaran', '2022/2023') }}</p>
        </div>

        <div class="faq-list">
            <ul>
                <li data-aos="fade-up" data-aos-delay="100">
                    <i class="bx bx-plus-circle icon-plus"></i> <a data-toggle="collapse" class="collapse"
                        href="#faq-list-1">SYARAT PENDAFTARAN SD <i class="bx bx-chevron-down icon-show"></i><i
                            class="bx bx-chevron-up icon-close"></i></a>
                    <div id="faq-list-1" class="collapse show" data-parent=".faq-list">
                        <p>
                            Umur 7 Tahun atau paling rendah 6 tahun pada tangal 1 Juli Tahun berjalan dengan Bukti Fisik
                            <span class="badge badge-primary"> Akte Kelahiran</span>
                        </p>
                    </div>
                </li>

                <li data-aos="fade-up" data-aos-delay="200">
                    <i class="bx bx-plus-circle icon-plus"></i> <a data-toggle="collapse" href="#faq-list-2"
                        class="collapsed">SYARAT PENDAFTARAN SMP <i class="bx bx-chevron-down icon-show"></i><i
                            class="bx bx-chevron-up icon-close"></i></a>
                    <div id="faq-list-2" class="collapse" data-parent=".faq-list">
                        <p>
                            1. Berusia paling tinggi 15 (lima belas) tahun pada tanggal 1 Juli tahun berjalan dengan
                            Bukti Fisik <span class="badge badge-primary"> Akte Kelahiran </span><br>
                            2. Telah menyelesaikan kelas 6 (enam) SD dibuktikan dengan <span class="badge badge-primary">
                                Ijazah atau Surat Keterangan Kelulusan</span>
                        </p>
                    </div>
                </li>

                <li data-aos="fade-up" data-aos-delay="300">
                    <i class="bx bx-plus-circle icon-plus"></i> <a data-toggle="collapse" href="#faq-list-3"
                        class="collapsed">JALUR ZONASI <i class="bx bx-chevron-down icon-show"></i><i
                            class="bx bx-chevron-up icon-close"></i></a>
                    <div id="faq-list-3" class="collapse" data-parent=".faq-list">
                        <p>
                            Khusus calon peserta didik yang berdomisili pada radius zona terdekat dari sekolah
                            dibuktikan dengan <span class="badge badge-primary"> Kartu Keluarga [KK]</span>
			          yang diterbitkan paling lambat 1 (satu) tahun sebelum pelaksanaan PPDB.<br>
                        </p>
                    </div>
                </li>

                <li data-aos="fade-up" data-aos-delay="400">
                    <i class="bx bx-plus-circle icon-plus"></i> <a data-toggle="collapse" href="#faq-list-4"
                        class="collapsed">JALUR AFIRMASI <i class="bx bx-chevron-down icon-show"></i><i
                            class="bx bx-chevron-up icon-close"></i></a>
                    <div id="faq-list-4" class="collapse" data-parent=".faq-list">
                        <p>
                            Diperuntukkan bagi peserta didik yang berasal dari keluarga ekonomi tidak mampu dibuktikan
                            dengan bukti
                            keikutsertaan peserta didik dalam program penanganan keluarga tidak mampu dari Pemerintah
                            Pusat
                            atau Pemerintah Daerah berupa kartu <span class="badge badge-primary">KIP, KKS, PKH</span> dan
                            lain-lain.
                        </p>
                    </div>
                </li>

                <li data-aos="fade-up" data-aos-delay="500">
                    <i class="bx bx-plus-circle icon-plus"></i> <a data-toggle="collapse" href="#faq-list-5"
                        class="collapsed">JALUR PERPINDAHAN TUGAS ORANG TUA/WALI <i
                            class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                    <div id="faq-list-5" class="collapse" data-parent=".faq-list">
                        <p>
                            Perpindahan tugas orang tua/wali dibuktikan dengan <span class="badge badge-primary"> surat
                                penugasan dari instansi, lembaga, kantor,
                                atau perusahaan </span> yang mempekerjakan orang tua siswa

                        </p>
                    </div>
                </li>

                <li data-aos="fade-up" data-aos-delay="600">
                    <i class="bx bx-plus-circle icon-plus"></i> <a data-toggle="collapse" href="#faq-list-6"
                        class="collapsed">JALUR PRESTASI <i class="bx bx-chevron-down icon-show"></i><i
                            class="bx bx-chevron-up icon-close"></i></a>
                    <div id="faq-list-6" class="collapse" data-parent=".faq-list">
                        <p>
                            1. Jalur prestasi nilai akademik berdasarkan <span class="badge badge-primary"> rata-rata rapor kelas 4, 5, 6 dan rata-rata ujian sekolah tulis dan praktek</span> <br>
                            2. Jalur prestasi hasil perlombaan atau penghargaan di bidang akademik maupun non-akademik
                            tingkat Internasional, Nasional, Provinsi,
                            atau tingkat kabupaten/kota dibuktikan <span class="badge badge-primary">Piagam juara 1, 2 atau 3</span>

                        </p>
                    </div>
                </li>

                <li data-aos="fade-up" data-aos-delay="700">
                    <i class="bx bx-plus-circle icon-plus"></i> <a data-toggle="collapse" href="#faq-list-7"
                        class="collapsed">PERSENTASE KOUTA PPDB 2022 <i class="bx bx-chevron-down icon-show"></i><i
                            class="bx bx-chevron-up icon-close"></i></a>
                    <div id="faq-list-7" class="collapse" data-parent=".faq-list">
                        <p>
                            <strong>Jenjang SD</strong><br>

                            1. Jalur Zonasi <span class="badge badge-primary">75% </span><br>
                            2. Jalur Afirmasi <span class="badge badge-primary">20% </span><br>
                            3. Jalur Perpindahan Tugas Orang Tua/Wali <span class="badge badge-primary">5% </span>
                            <br><br>
                            <strong>Jenjang SMP</strong><br>

                            1. Jalur Zonasi <span class="badge badge-primary">55% </span><br>
                            2. Jalur Afirmasi <span class="badge badge-primary">15% </span><br>
                            3. Jalur Perpindahan Tugas Orang Tua/Wali <span class="badge badge-primary">5% </span><br>
                            4. Jalur Prestasi <span class="badge badge-primary">25% </span>
                        </p>
                    </div>
                </li>

            </ul>
        </div>

    </div>
</section><!-- End Frequently Asked Questions Section -->
<section id="register" class="register">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Form Pendaftaran</h2>
            <p>Silahkan isi formulir dibawah ini untuk melakukan pendaftaran!</p>
        </div>
        @if(strtotime(date('Y-m-d')) <= strtotime('2022-07-04'))
        <div class="row">
            <div class="col-12">
                <div class="main-example text-center">
                    <p>Pendaftaran akan dibuka pada:</p>
                    <div class="countdown-container" id="main-example"></div>
                </div>
            </div>
        </div>
        <div class="row pendaftaran" style="display: none;">
            <div class="col-12">
                <form id="form">
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap Sesuai Akta Lahir">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nik" class="col-sm-2 col-form-label">NIK</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nik" placeholder="Nomor Induk Kependudukan (16 Digit)" name="nik">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">{{ __('Password') }}</label>
                        <div class="col-sm-10">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                autocomplete="password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bentuk_pendidikan_id"
                            class="col-sm-2 col-form-label">{{ __('Jenjang Pendaftaran') }}</label>
                        <div class="col-sm-10">
                            <select name="bentuk_pendidikan_id" id="bentuk_pendidikan_id"
                                class="select2 form-control form-select-lg">
                                <option value="">== Pilih Jenjang Pendaftaran ==</option>
                                <option value="5" {{ (old('bentuk_pendidikan_id') == 5 ) ? 'selected' : '' }}>SD
                                </option>
                                <option value="6" {{ (old('bentuk_pendidikan_id') == 6 ) ? 'selected' : '' }}>SMP
                                </option>
                            </select>
                        </div>
                    </div>
                </form>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary" onclick="registrasi()">DAFTAR
                        SEKARANG</button>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">PENDAFTARAN DITUTUP</h1>
            </div>
        </div>
        @endif
    </div>
</section><!-- End register Section -->
@endsection
@section('css')
<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Oswald">
<link href="{{asset('vendor/jquery.countdown-2.1.0/jquery.countdown.css')}}" rel="stylesheet" />
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.all.min.js"></script>
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
    function registrasi(){
        console.log('registrasi');
        var name = $('#name').val();
        var nik = $('#nik').val();
        var password = $('#password').val();
        var bentuk_pendidikan_id = $('#bentuk_pendidikan_id').val();
        if(!name){
            Swal.fire('Gagal', 'Nama Lengkap tidak boleh kosong!', 'error');
            return false;
        }
        if(!nik){
            Swal.fire('Gagal', 'NIK tidak boleh kosong', 'error');
            return false;
        } else if(nik.length !== 16){
            Swal.fire('Gagal', 'NIK harus 16 digit', 'error');
            return false;
        }
        if(!password){
            Swal.fire('Gagal', 'Password tidak boleh kosong', 'error');
            return false;
        }
        if(!bentuk_pendidikan_id){
            Swal.fire('Gagal', 'Jenjang Pendaftaran tidak boleh kosong', 'error');
            return false;
        }
        $.ajax({
            url: '{{route('api.register')}}',
            type: 'post',
            data: $("form#form").serialize(),
        }).done(function( data ) {
            Swal.fire({
                title: 'Berhasil',
                text: 'Silahkan cetak informasi Akun Anda dibawah ini!',
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: `Cetak`,
                denyButtonText: `Login`,
                icon: 'success',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open('cetak/akun/'+data.user.user_id,'_blank');
                } else if (result.isDenied) {
                    window.open('login')
                }
            })
        }).fail(function(error) {
            var errors = [];
            $.each(error.responseJSON.errors, function( i, val ) {
                errors.push(val[0]);
            })
            Swal.fire('Gagal', errors.join("<br>"), 'error');
        });
        return false;
    }
    $(document).ready( function () {
        var add_minutes =  function (dt, minutes) {
            return new Date(dt.getTime() + minutes*5000);
            //return new Date(dt.getTime() - minutes*5000);
        }
        var dt = add_minutes(new Date(), 0);
        year  = dt.getFullYear();
        month = (dt.getMonth() + 1).toString().padStart(2, "0");
        day   = dt.getDate().toString().padStart(2, "0");
        hour = dt.getHours();
        minutes = dt.getMinutes();
        seconds = dt.getSeconds();
        var labels = ['Pekan', 'Hari', 'Jam', 'Menit', 'Detik'],
        nextYear = '2022/06/27 00:00:00',
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
            $('.pendaftaran').show();
        });
    })
</script>
@endsection