<template>
<div>
    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div>Profil Pengguna</div>
        </div>
      </div>
    </div>
    <section class="content">
        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
            <li class="nav-item">
                <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0">
                    <span>Profil Pengguna</span>
                </a>
            </li>
            <li class="nav-item" v-if="hasRole('siswa')">
                <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-1">
                    <span>Lokasi Pengguna</span>
                </a>
            </li>
            <li class="nav-item" v-if="hasRole('sekolah')">
                <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-1">
                    <span>Lokasi Sekolah</span>
                </a>
            </li>
            <li class="nav-item" v-if="hasRole('siswa') && user.data.bentuk_pendidikan_id == 6 && form.nilai">
                <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#tab-content-2">
                    <span>Nilai SKHU</span>
                </a>
            </li>
        </ul>
        <div class="alert alert-danger" v-show="errors">
            <h5><i class="icon fas fa-ban"></i> Isian Tidak Valid!</h5>
            <ul>
                <li v-for="(error, key) in errors">
                    {{error}}
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <template v-if="hasRole('siswa')">
                                <ProfileSiswa :kunci="kunci"></ProfileSiswa>
                            </template>
                            <template v-else>
                                <Profile></Profile>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input v-model="form.user_id" type="hidden" name="user_id" class="form-control" />
                                            <b-form inline>
                                                <label class="mr-sm-2" for="bujur">Bujur</label>
                                                <b-form-input id="bujur" v-model="form.bujur" type="text" class="mb-2" placeholder="-" @change="isiBujur" :disabled="kunci"></b-form-input>
                                            </b-form>
                                        </div>
                                        <div class="col-md-6">
                                            <b-form inline>
                                                <label class="mr-sm-2" for="lintang">Lintang</label>
                                                <b-form-input id="lintang" v-model="form.lintang" type="text" class="mb-2" placeholder="-" @change="isiLintang" :disabled="kunci"></b-form-input>
                                            </b-form>
                                        </div>
                                    </div>
                                </div>
                                <GmapMap :center='center' :zoom='16' :sensor="false" labels:true :mapTypeId="mapTypeId" style='width:100%;  height: 400px;'>
                                    <GmapMarker :key="index" v-for="(m, index) in markers" :position="m.position" @click="center=m.position" :clickable="!kunci" :draggable="!kunci" @dragend="updateCoordinates"/>
                                </GmapMap>
                            </div>
                            <div class="card-footer">
                                <b-button squared variant="success" size="lg" v-on:click="updatePeta" :disabled="kunci">
                                    <b-spinner small v-show="show_spinner"></b-spinner>
                                    <span class="sr-only" v-show="show_spinner">Loading...</span>
                                    <span v-show="show_text">Perbaharui Data</span>
                                </b-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel" v-if="hasRole('siswa') && user.data.bentuk_pendidikan_id == 6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <table class="table table-bordered" v-if="form.nilai">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Mata Pelajaran</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(mapel, index) in mata_pelajaran">
                                            <td class="text-center">{{index + 1}}</td>
                                            <td>{{mapel.nama}}</td>
                                            <td><b-form-input v-model="form.nilai[mapel.id]" size="sm" :placeholder="'Nilai '+mapel.nama" @keypress="isNumber($event)" :disabled="kunci"></b-form-input></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--table class="table table-bordered" v-if="form.nilai">
                                    <thead>
                                        <tr>
                                        <th class="text-center" rowspan="3" style="vertical-align:middle;">No</th>
                                        <th class="text-center" rowspan="3" style="vertical-align:middle;">Mata Pelajaran</th>
                                        <th class="text-center" colspan="5">Nilai</th>
                                        </tr>
                                        <tr>
                                        <th class="text-center" colspan="2">Kelas IV</th>
                                        <th class="text-center" colspan="2">Kelas V</th>
                                        <th class="text-center">Kelas VI</th>
                                        </tr>
                                        <tr>
                                        <th class="text-center">Semester 1</th>
                                        <th class="text-center">Semester 2</th>
                                        <th class="text-center">Semester 1</th>
                                        <th class="text-center">Semester 2</th>
                                        <th class="text-center">Semester 1</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(mapel, index) in mata_pelajaran">
                                        <td class="text-center">{{index + 1}}</td>
                                        <td>{{mapel.nama}}</td>
                                        <td><b-form-input v-model="form.nilai[mapel.id]['IV'][1]" size="sm" :placeholder="'Nilai '+mapel.nama" @keypress="isNumber($event)" :disabled="kunci"></b-form-input></td>
                                        <td><b-form-input v-model="form.nilai[mapel.id]['IV'][2]" size="sm" :placeholder="'Nilai '+mapel.nama" @keypress="isNumber($event)" :disabled="kunci"></b-form-input></td>
                                        <td><b-form-input v-model="form.nilai[mapel.id]['V'][1]" size="sm" :placeholder="'Nilai '+mapel.nama" @keypress="isNumber($event)" :disabled="kunci"></b-form-input></td>
                                        <td><b-form-input v-model="form.nilai[mapel.id]['V'][2]" size="sm" :placeholder="'Nilai '+mapel.nama" @keypress="isNumber($event)" :disabled="kunci"></b-form-input></td>
                                        <td><b-form-input v-model="form.nilai[mapel.id]['VI'][1]" size="sm" :placeholder="'Nilai '+mapel.nama" @keypress="isNumber($event)" :disabled="kunci"></b-form-input></td>
                                        </tr>
                                    </tbody>
                                </table-->
                            </div>
                            <div class="card-footer">
                                <b-button squared variant="success" size="lg" v-on:click="simpanNilai" :disabled="kunci">
                                    <b-spinner small v-show="show_spinner_nilai"></b-spinner>
                                    <span class="sr-only" v-show="show_spinner_nilai">Sedang menyimpan...</span>
                                    <span v-show="show_text_nilai">Simpan Data</span>
                                </b-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane tabs-animation fade" id="tab-content-3" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <b-form-file v-model="upload_ijazah" :state="Boolean(upload_ijazah)" accept=".jpg, .png, .jpeg, .pdf" placeholder="Cari berkas Bukti kelulusan..." drop-placeholder="Letakkan berkas Bukti kelulusan disini..."></b-form-file>
                            </div>
                            <div class="card-footer">
                                <b-button squared variant="success" size="lg" v-on:click="simpanIjazah">
                                    <b-spinner small v-show="show_spinner_ijazah"></b-spinner>
                                    <span class="sr-only" v-show="show_spinner_ijazah">Sedang menyimpan...</span>
                                    <span v-show="show_text_ijazah">Simpan</span>
                                </b-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
</div>
</template>

<script>
//import objectToFormData from "./components/objectToFormData";
//import Datepicker from './components/TouchDatePicker.vue';
import ProfileSiswa from './components/ProfileSiswa'
import Profile from './components/Profile'
import axios from 'axios' //IMPORT AXIOS
//import DatePicker from 'vue2-datepicker';
//import 'vue2-datepicker/index.css';
//import VueEnglishdatepicker from 'vue-englishdatepicker';
export default {
    components: {
        ProfileSiswa,
        Profile,
        //Datepicker,
    },
    created() {
        this.$loading(true)
        //MAKA AKAN MENJALANKAN FUNGSI BERIKUT
        this.loadPostsData();
    },
    data() {
        return {
            kunci: true,
            kejuaraan: [],
            tingkat_prestasi: [],
            show_spinner_ijazah: false,
            show_text_ijazah: true,
            show_spinner_juara: false,
            show_text_juara: true,
            form: new Form({
                user_id: user.user_id,
                name: '',
                email: '',
                current_password: '',
                password: '',
                password_confirmation: '',
                wna: '',
                negara_id: '',
                provinsi_id: '',
                kabupaten_id: '',
                kecamatan_id: '',
                desa_id: '',
                alamat: '',
                rt: '',
                rw: '',
                tempat_lahir: '',
                tanggal_lahir: '',
                bujur: '',
                lintang: '',
                jenis_kelamin: '',
                nomor_hp: '',
                photo: null,
                agama_id: '',
                kebutuhan_khusus: '',
                //nilai: [],
                prestasi_id: {},
                juara: {},
                nama_lomba: {},
                penyelenggara: {},
                nilai: null,
            }),
            errors: null,
            photo: '',
            upload_photo: [],
            upload_ijazah: [],
            upload_piagam: [],
            show_spinner: false,
            show_text: true,
            /*data_wna: [{key: 0, nama: 'Warga Negara Indonesia'}, {key: 1, nama: 'Warga Negara Asing'}],
            jenis_kelamin: [{key: 'L', nama: 'Laki-laki'}, {key: 'P', nama: 'Perempuan'}],
            data_negara: [],
            data_provinsi: [],
            data_kabupaten: [],
            data_kecamatan: [],
            data_desa: [],
            data_agama: [],
            data_kebutuhan_khusus: [],*/
            center: { lat: -7.195404, lng: 113.250257 },
            currentPlace: null,
            markers: [{
                position: {
                    lat: -7.195404,
                    lng: 113.250257
                }
            }],
            places: [],
            coordinates: {},
            mapTypeId: 'hybrid',
            mata_pelajaran: [],
            show_spinner_nilai: false,
            show_text_nilai: true,
        }
    },
    methods: {
        isiBujur(val){
            let lintang = Number(this.form.lintang).toFixed(6)
            let bujur = Number(this.form.bujur).toFixed(6)
            this.setPosisi(bujur, lintang);
        },
        isiLintang(val){
            let lintang = Number(this.form.lintang).toFixed(6)
            let bujur = Number(this.form.bujur).toFixed(6)
            this.setPosisi(bujur, lintang);
        },
        setPosisi(bujur, lintang){
            if(bujur && lintang){
                this.markers[0] = {
                    position: {
                        lat: Number(lintang),
                        lng: Number(bujur)
                    }
                }
                this.center = { lat: Number(lintang), lng: Number(bujur) };
                //this.form.bujur = Number(bujur);
                //this.form.lintang = Number(lintang);
            }
        },
        addRow: function() {
            var elem = document.createElement('tr');
            this.kejuaraan.push({
                title: "",
                description: "",
                file: {
                    name: 'Choose File'
                }
            });
        },
        removeElement: function(index) {
            this.kejuaraan.splice(index, 1);
            this.form.prestasi_id[index] = null
            this.form.juara[index] = null
        },
        setFilename: function(event, row) {
            var file = event.target.files[0];
            row.file = file
        },
        objectSize(obj){
            return Object.keys(obj).length
        },
        simpanJuara(){
            let formData = new FormData();
            this.errors = null
            var prestasi_id = this.form.prestasi_id
            var vm = this
            if(this.objectSize(this.form.prestasi_id)){
                var error_prestasi_id = 0;
                var error_juara = 0;
                var error_nama_lomba = 0;
                var error_penyelenggara = 0;
                var error_upload_piagam = 0;
                $.each(this.form.prestasi_id, function(key, value){
                    if(!value){
                        error_prestasi_id++
                    }
                    if(!vm.form.juara[key]){
                        error_juara++
                    }
                    if(!vm.form.nama_lomba[key]){
                        error_nama_lomba++
                    }
                    if(!vm.form.penyelenggara[key]){
                        error_penyelenggara++
                    }
                    if(!vm.upload_piagam[key]){
                        error_upload_piagam++
                    }
                    formData.append("prestasi_id["+key+"]", value.id);
                    formData.append("juara["+key+"]", vm.form.juara[key]);
                    formData.append("nama_lomba["+key+"]", vm.form.nama_lomba[key]);
                    formData.append("penyelenggara["+key+"]", vm.form.penyelenggara[key]);
                    formData.append("upload_piagam["+key+"]", vm.upload_piagam[key]);
                })
                formData.append("user_id", user.user_id);
                if(error_prestasi_id){
                    this.errors = ['Tingkat Juara tidak boleh kosong']
                    return false;
                }
                if(error_juara){
                    this.errors = ['Juara Ke- tidak boleh kosong']
                    return false;
                }
                if(error_nama_lomba){
                    this.errors = ['Nama Lomba tidak boleh kosong']
                    return false;
                }
                if(error_penyelenggara){
                    this.errors = ['Penyelenggara tidak boleh kosong']
                    return false;
                }
                if(error_upload_piagam){
                    this.errors = ['Berkas Piagam tidak boleh kosong']
                    return false;
                }
                axios.post(`/api/users/simpan-prestasi`, formData)
                .then((response) => {
                    this.kejuaraan = []
                    let getData = response.data.data
                    this.kejuaraan = getData
                })
            } else {
                this.errors = ['Tidak ada data disimpan']
            }
        },
        isNumber: function(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();;
            } else {
                return true;
            }
        },
        simpanNilai(){
            this.show_spinner_nilai = true
            this.show_text_nilai = false
            axios.post(`/api/users/simpan-nilai`, {
                user_id: user.user_id,
                nilai: this.form.nilai,
            })
            .then((response) => {
                Toast.fire({
                    icon: "success",
                    title: 'Nilai berhasil disimpan',
                });
                this.errors = null
                this.show_spinner_nilai = false
                this.show_text_nilai = true
                this.getMataPelajaran(user.user_id)
            })
        },
        simpanIjazah(){
            this.show_spinner_ijazah = true
            this.show_text_ijazah = false
            let formData = new FormData();
            formData.append("user_id", user.user_id);
            formData.append("ijazah", this.upload_ijazah);
            axios.post(`/api/users/simpan-ijazah`, formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            })
            .then((response) => {
                Toast.fire({
                    icon: "success",
                    title: 'Bukti kelulusan berhasil disimpan',
                });
                this.errors = null
                this.show_spinner_ijazah = false
                this.show_text_ijazah = true
                this.loadPostsData()
            }).catch(error => {
                if(error.response){
                    var errors = [];
                    $.each(error.response.data.errors, function (key, value) {
                        errors.push(value[0]);
                    })
                    this.errors = errors
                    this.show_spinner_ijazah = false
                    this.show_text_ijazah = true
                }
            })
        },
        loadPostsData() {
            this.$loading(true)
            axios.post(`/api/profile`, {
                user_id: user.user_id,
            })
            .then((response) => {
                this.$loading(false)
                let getData = response.data.data;
                this.kunci = (response.data.kunci) ? true : false
                let getMaps = response.data.maps
                let lintang;
                let bujur;
                if(getData.sekolah_id){
                    lintang = Number(getData.sekolah.lintang).toFixed(6);
                    bujur = Number(getData.sekolah.bujur).toFixed(6);
                } else {
                    lintang = Number(getData.lintang).toFixed(6);
                    bujur = Number(getData.bujur).toFixed(6);
                }
                console.log(getMaps);
                if(getMaps){
                    if(getMaps.results.length){
                        lintang = getMaps.results[0].geometry.location.lat
                        bujur = getMaps.results[0].geometry.location.lng
                        this.markers[0] = {
                            position: {
                                lat: Number(lintang),
                                lng: Number(bujur)
                            }
                        }
                        this.center = { lat: Number(lintang), lng: Number(bujur) };
                    }
                }
                this.form.bujur = Number(bujur);
                this.form.lintang = Number(lintang);
                this.form.user_id = getData.user_id
                this.skhu = (getData.skhu) ? true : false
                this.file_skhu = getData.skhu
                this.getMataPelajaran(getData.user_id)
                this.geolocate(getData)
                //this.getPrestasi(getData.user_id)
            })
        },
        getPrestasi(user_id){
            //
            if(this.hasRole('siswa') && user.data.bentuk_pendidikan_id == 6){
                axios.post(`/api/users/prestasi`, {
                    user_id: user_id,
                })
                .then((response) => {
                    let getData = response.data.data;
                    this.kejuaraan = getData.piagam
                    this.tingkat_prestasi = getData.tingkat_prestasi
                    /*let tempTingkat = {}
                    let tempJuara = {}
                    let tempNamaLomba = {}
                    let tempPenyelenggara = {}
                    $.each(getData.piagam, function (index, value) {
                        tempTingkat[index] = value.tingkat_prestasi
                        tempJuara[index] = value.juara
                        tempNamaLomba[index] = value.nama_lomba
                        tempPenyelenggara[index] = value.penyelenggara
                    });
                    this.form.prestasi_id = tempTingkat
                    this.form.juara = tempJuara
                    this.form.nama_lomba = tempNamaLomba
                    this.form.penyelenggara = tempPenyelenggara*/
                })
            }
        },
        getMataPelajaran(user_id){
            if(this.hasRole('siswa') && user.data.bentuk_pendidikan_id == 6){
                axios.post(`/api/users/mata-pelajaran`, {
                    user_id: user.user_id,
                })
                .then((response) => {
                    this.$loading(false)
                    let getData = response.data.data;
                    this.mata_pelajaran = getData
                    let tempNilai = {}
                    $.each(getData, function (key, value) {
                        /*tempNilai[value.id] = {
                            'IV':{1:0, 2:0},
                            'V':{1:0, 2:0},
                            'VI':{1:0}
                        }*/
                        tempNilai[value.id] = 0
                    });
                    let getNilai = response.data.nilai;
                    if(Object.keys(getNilai).length){
                        this.form.nilai = getNilai
                    } else {
                        this.form.nilai = tempNilai
                    }
                })
            }
        },
        updateCoordinates(location) {
            this.$loading(true)
            let lintang = Number(location.latLng.lat()).toFixed(6)
            let bujur = Number(location.latLng.lng()).toFixed(6)
            axios.post(`/api/users/simpan-koordinat`, {
                user_id: user.user_id,
                lintang: Number(lintang),
                bujur: Number(bujur),
            }).then((response) => {
                this.$loading(false)
                this.form.lintang = Number(lintang)
                this.form.bujur = Number(bujur)
            });
        },
        geolocate(user) {
            if(user.bujur){
                let lintang = Number(user.lintang).toFixed(6)
                let bujur = Number(user.bujur).toFixed(6)
                this.markers[0] = {
                    position: {
                        lat: Number(lintang),
                        lng: Number(bujur)
                    }
                }
                this.center = { lat: Number(lintang), lng: Number(bujur) };
            } else if(user.sekolah_id){
                let lintang = Number(user.sekolah.lintang).toFixed(6)
                let bujur = Number(user.sekolah.bujur).toFixed(6)
                this.markers[0] = {
                    position: {
                        lat: Number(lintang),
                        lng: Number(bujur)
                    }
                }
                this.center = { lat: Number(lintang), lng: Number(bujur) };
            }
        },
        updatePassword(){
            this.form.post(`/api/users/update-password`).then((response) => {
                Swal.fire(response.title, response.text, response.icon).then(() => {
                    this.loadPostsData();
                });
            }).catch(error => {
                if(error.response){
                    var errors = [];
                    $.each(error.response.data.errors, function (key, value) {
                        errors.push(value[0]);
                    })
                    this.errors = errors
                    this.show_spinner = false
                    this.show_text = true
                }
            })
        },
        updatePeta(){
            this.form.post(`/api/users/update-peta`).then((response) => {
                Swal.fire(response.title, response.text, response.icon).then(() => {
                    this.loadPostsData();
                });
            }).catch(error => {
                if(error.response){
                    var errors = [];
                    $.each(error.response.data.errors, function (key, value) {
                        errors.push(value[0]);
                    })
                    this.errors = errors
                    this.show_spinner = false
                    this.show_text = true
                }
            })
        },
        hapusDokumen(user_id) {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Menghapus SKHU akan menghapus nilai yang tersimpan!",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya!",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.value) {
                    return fetch("/api/users/delete-skhu/" + user_id, {
                        method: "DELETE",
                    })
                    .then((response) => response.json())
                    .then((data) => {
                    Swal.fire(data.title, data.message, data.status).then(() => {
                        this.loadPostsData();
                    });
                    });
                }
            });
        },
        hapusJuara(id) {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Tindakan ini tidak dapat dikembalikan!",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya!",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.value) {
                    return fetch("/api/users/delete-piagam/" + id, {
                        method: "DELETE",
                    })
                    .then((response) => response.json())
                    .then((data) => {
                    Swal.fire(data.title, data.message, data.status).then(() => {
                        this.getPrestasi(user.user_id);
                    });
                    });
                }
            });
        },
    }
}
</script>
