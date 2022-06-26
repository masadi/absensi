@extends('layouts.app')
@section('title', 'Daftar')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">{{ __('Daftar PPDB') }}</div>

                <div class="card-body">
                    <form id="form">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nama Lengkap') }}</label>

                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nik" class="col-md-4 col-form-label text-md-right">{{ __('NIK') }}</label>

                            <div class="col-md-8">
                                <input id="nik" type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ old('nik') }}" autocomplete="nik">

                                @error('nik')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bentuk_pendidikan_id" class="col-md-4 col-form-label text-md-right">{{ __('Jenjang Pendaftaran') }}</label>
                            <div class="col-md-8">
                                <select name="bentuk_pendidikan_id" id="bentuk_pendidikan_id" class="select2 form-control @error('bentuk_pendidikan_id') is-invalid @enderror">
                                    <option value="">== Pilih Jenjang Pendaftaran ==</option>
                                    <option value="5" {{ (old('bentuk_pendidikan_id') == 5 ) ? 'selected' : '' }}>SD</option>
                                    <option value="6" {{ (old('bentuk_pendidikan_id') == 6 ) ? 'selected' : '' }}>SMP</option>
                                </select>
                                @error('kecamatan_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!--div class="form-group row">
                            <label for="kecamatan_id" class="col-md-4 col-form-label text-md-right">{{ __('Kecamatan') }}</label>
                            <div class="col-md-8">
                                <select name="kecamatan_id" id="kecamatan_id" class="select2 form-control @error('kecamatan_id') is-invalid @enderror">
                                    <option value="">== Pilih Kecamatan ==</option>
                                    @foreach ($data_kecamatan as $kecamatan)
                                    <option value="{{$kecamatan->kode_wilayah}}" {{ (old('kecamatan_id') ==$kecamatan->kode_wilayah ) ? 'selected' : '' }}>{{$kecamatan->nama}}</option>
                                    @endforeach
                                </select>
                                @error('kecamatan_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="desa_id" class="col-md-4 col-form-label text-md-right">{{ __('Desa/Kelurahan') }}</label>
                            <div class="col-md-8">
                                <select name="desa_id" id="desa_id" class="select2 form-control @error('desa_id') is-invalid @enderror">
                                    <option value="">== Pilih Desa/Kelurahan ==</option>
                                </select>
                                @error('desa_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div-->
                        <!--
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-8">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>
                        -->
                        
                    </form>
                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button class="btn btn-primary" onclick="registrasi()">
                                {{ __('DAFTAR SEKARANG') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.all.min.js"></script>
    <script>
        function registrasi(){
            console.log('registrasi');
            var name = $('#name').val();
            var nik = $('#nik').val();
            var password = $('#password').val();
            var bentuk_pendidikan_id = $('#bentuk_pendidikan_id').val();
            if(!name){
                Swal.fire('Gagal', 'Lengkap tidak boleh kosong!', 'error');
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
                console.log(data);
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
                        window.open('cetak/'+data.user.user_id,'_blank');
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
            
            $('.select2').select2();
            $('#kecamatan_id').change(function(e){
                e.preventDefault();
                var ini = $(this).val();
                $("#desa_id").html('<option value="">== Pilih Desa/Kelurahan ==</option>');
                if(ini == ''){
                    return false;
                }
                $.ajax({
                    url: '{{route('api.get_desa')}}',
                    type: 'post',
                    data: $("form#form").serialize(),
                    success: function(response){
                        //var data = $.parseJSON(response);
                        console.log(response);
                        $.each(response.result, function (i, item) {
                            $('#desa_id').append($('<option>', { 
                                value: item.kode_wilayah,
                                text : item.nama
                            }));
                        });
                    }
                });
                
            });
        })
    </script>
@endsection