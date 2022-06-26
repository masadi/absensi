<template>
  <div>
    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div>Tambah Data Pendaftar</div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="main-card mb-3 card" v-if="daftarOpen">
        <div class="card-body">
          <form-wizard @on-complete="onComplete" @on-loading="setLoading" @on-validate="handleValidation" @on-error="handleErrorMessage" shape="circle" color="#e74c3c" error-color="#8b0000" title="Formulir Pendaftaran" subtitle="Silahkan lengkapi formulir dibawah ini!" nextButtonText="Selanjutnya" backButtonText="Sebelumnya" finishButtonText="Simpan Data" ref="wizard">
            <tab-content title="Detail Siswa" :before-change="validateAsync" icon="fas fa-user"> 
              <div class="row">
                <div class="col-md-6">
                  <label for="name" class="col-form-label">Nama Lengkap</label>
                  <div class="form-group">
                    <input
                      v-model="form.sekolah_id"
                      type="hidden"
                      name="sekolah_id"
                      class="form-control"
                    />
                    <input
                      v-model="form.titipan"
                      type="hidden"
                      name="titipan"
                      class="form-control"
                    />
                    <input
                      v-model="form.name"
                      type="text"
                      name="name"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('name') }"
                    />
                    <has-error :form="form" field="name"></has-error>
                  </div>
                  <label for="nik" class="col-form-label">NIK</label>
                  <div class="form-group">
                    <input
                      v-model="form.nik"
                      type="text"
                      id="nik"
                      name="nik"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('nik') }"
                    />
                    <has-error :form="form" field="nik"></has-error>
                  </div>
                  <label for="alamat" class="col-form-label">Alamat Lengkap</label>
                  <div class="form-group">
                    <input
                      v-model="form.alamat"
                      type="text"
                      id="alamat"
                      name="alamat"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('alamat') }"
                    />
                    <has-error :form="form" field="alamat"></has-error>
                  </div>
                  <label for="rt" class="col-form-label">RT</label>
                  <div class="form-group">
                    <input
                      v-model="form.rt"
                      type="text"
                      id="rt"
                      name="rt"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('rt') }"
                    />
                    <has-error :form="form" field="rt"></has-error>
                  </div>
                  <label for="rw" class="col-form-label">RW</label>
                  <div class="form-group">
                    <input
                      v-model="form.rw"
                      type="text"
                      id="rw"
                      name="rw"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('rw') }"
                    />
                    <has-error :form="form" field="rw"></has-error>
                  </div>
                  <label for="jenis_kelamin" class="col-form-label">Jenis Kelamin</label>
                  <div class="form-group">
                    <v-select
                      label="nama"
                      :options="jenis_kelamin"
                      v-model="form.jenis_kelamin"
                      id="jenis_kelamin"
                      :class="{ 'is-invalid': form.errors.has('jenis_kelamin') }"
                    />
                    <has-error :form="form" field="jenis_kelamin"></has-error>
                  </div>
                  <label for="agama_id" class="col-form-label">Agama</label>
                  <div class="form-group">
                    <v-select
                      label="nama"
                      :options="data_agama"
                      v-model="form.agama_id"
                      id="jenis_kelamin"
                      :class="{ 'is-invalid': form.errors.has('agama_id') }"
                    />
                    <has-error :form="form" field="agama_id"></has-error>
                  </div>
                  <label for="nomor_hp" class="col-form-label">Nomor HP</label>
                  <div class="form-group">
                    <input
                      v-model="form.nomor_hp"
                      type="text"
                      id="nomor_hp"
                      name="nomor_hp"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('nomor_hp') }"
                    />
                    <has-error :form="form" field="nomor_hp"></has-error>
                  </div>
                  <label for="nomor_hp" class="col-form-label">Nama Orang Tua/Wali</label>
                  <div class="form-group">
                    <input
                      v-model="form.nama_ortu"
                      type="text"
                      id="nama_ortu"
                      name="nama_ortu"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('nama_ortu') }"
                    />
                    <has-error :form="form" field="nama_ortu"></has-error>
                  </div>
                  <label for="kebutuhan_khusus" class="col-form-label"
                    >Kebutuhan Khusus</label
                  >
                  <div class="form-group">
                    <v-select
                      multiple
                      label="nama"
                      :options="data_kebutuhan_khusus"
                      v-model="form.kebutuhan_khusus"
                      id="kebutuhan_khusus"
                      :class="{ 'is-invalid': form.errors.has('kebutuhan_khusus') }"
                    />
                    <has-error :form="form" field="kebutuhan_khusus"></has-error>
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="wna" class="col-form-label">Tempat Tinggal</label>
                  <div class="form-group">
                    <v-select
                      label="nama"
                      :options="jenis_tinggal"
                      v-model="form.jenis_tinggal_id"
                      id="jenis_tinggal_id"
                      :class="{ 'is-invalid': form.errors.has('jenis_tinggal_id') }"
                    />
                    <has-error :form="form" field="jenis_tinggal_id"></has-error>
                  </div>
                  <label for="wna" class="col-form-label">Warga Negara</label>
                  <div class="form-group">
                    <v-select
                      label="nama"
                      :options="data_wna"
                      v-model="form.wna"
                      id="wna"
                      @input="getNegara"
                      :class="{ 'is-invalid': form.errors.has('wna') }"
                    />
                    <has-error :form="form" field="wna"></has-error>
                  </div>
                  <label for="negara_id" class="col-form-label">Negara</label>
                  <div class="form-group">
                    <v-select
                      label="nama"
                      :options="data_negara"
                      v-model="form.negara_id"
                      id="provinsi_id"
                      @input="getProvinsi"
                      :class="{ 'is-invalid': form.errors.has('negara_id') }"
                    />
                    <has-error :form="form" field="negara_id"></has-error>
                  </div>
                  <label for="provinsi_id" class="col-form-label">Provinsi</label>
                  <div class="form-group" v-if="select_provinsi">
                    <v-select
                      label="nama"
                      :options="data_provinsi"
                      v-model="form.provinsi_id"
                      id="provinsi_id"
                      @input="getKabupaten"
                      :class="{ 'is-invalid': form.errors.has('provinsi_id') }"
                    />
                    <has-error :form="form" field="provinsi_id"></has-error>
                  </div>
                  <div class="form-group" v-else>
                    <input
                      v-model="form.provinsi_id"
                      type="text"
                      id="provinsi_id"
                      name="provinsi_id"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('provinsi_id') }"
                    />
                    <has-error :form="form" field="provinsi_id"></has-error>
                  </div>
                  <label for="kabupaten_id" class="col-form-label">Kabupaten/Kota</label>
                  <div class="form-group" v-if="select_kabupaten">
                    <v-select
                      label="nama"
                      :options="data_kabupaten"
                      v-model="form.kabupaten_id"
                      id="kabupaten_id"
                      @input="getKecamatan"
                      :class="{ 'is-invalid': form.errors.has('kabupaten_id') }"
                    />
                    <has-error :form="form" field="kabupaten_id"></has-error>
                  </div>
                  <div class="form-group" v-else>
                    <input
                      v-model="form.kabupaten_id"
                      type="text"
                      id="kabupaten_id"
                      name="kabupaten_id"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('kabupaten_id') }"
                    />
                    <has-error :form="form" field="kabupaten_id"></has-error>
                  </div>
                  <label for="kecamatan_id" class="col-form-label">Kecamatan</label>
                  <div class="form-group" v-if="select_kecamatan">
                    <v-select
                      label="nama"
                      :options="data_kecamatan"
                      v-model="form.kecamatan_id"
                      id="kecamatan_id"
                      @input="getDesa"
                      :class="{ 'is-invalid': form.errors.has('kecamatan_id') }"
                    />
                    <has-error :form="form" field="kecamatan_id"></has-error>
                  </div>
                  <div class="form-group" v-else>
                    <input
                      v-model="form.kecamatan_id"
                      type="text"
                      id="kecamatan_id"
                      name="kecamatan_id"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('kecamatan_id') }"
                    />
                    <has-error :form="form" field="kecamatan_id"></has-error>
                  </div>
                  <label for="desa_id" class="col-form-label">Desa/Kelurahan</label>
                  <div class="form-group" v-if="select_desa">
                    <v-select
                      label="nama"
                      :options="data_desa"
                      v-model="form.desa_id"
                      id="desa_id"
                      :class="{ 'is-invalid': form.errors.has('desa_id') }"
                    />
                    <has-error :form="form" field="desa_id"></has-error>
                  </div>
                  <div class="form-group" v-else>
                    <input
                      v-model="form.desa_id"
                      type="text"
                      id="desa_id"
                      name="desa_id"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('desa_id') }"
                    />
                    <has-error :form="form" field="desa_id"></has-error>
                  </div>
                  <label for="tempat_lahir" class="col-form-label">Tempat Lahir</label>
                  <div class="form-group">
                    <input
                      v-model="form.tempat_lahir"
                      type="text"
                      id="tempat_lahir"
                      name="tempat_lahir"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('tempat_lahir') }"
                    />
                    <has-error :form="form" field="tempat_lahir"></has-error>
                  </div>
                  <label for="tanggal_lahir" class="col-form-label">Tanggal Lahir</label>
                  <div class="form-group">
                    <datepicker
                      v-bind:language="'id'"
                      v-bind:placeholder="'Tanggal Lahir'"
                      v-bind:input-class="{
                        'form-control': true,
                        'is-invalid': form.errors.has('tanggal_lahir'),
                      }"
                      v-bind:min="'1990-01-01'"
                      v-bind:max="'2020-12-31'"
                      v-bind:data-vv-as="'Masukkan Tanggal Lahir Anda'"
                      v-model="form.tanggal_lahir"
                      v-bind:v-validate="{ required: true, date_format: 'YYYY-MM-DD' }"
                      name="tanggal_lahir"
                      id="tanggal_lahir"
                    ></datepicker>
                    <has-error :form="form" field="tanggal_lahir"></has-error>
                  </div>
                  <label for="password" class="col-form-label">Password</label>
                  <div class="form-group">
                    <input
                      v-model="form.password"
                      type="password"
                      id="password"
                      name="password"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('password') }"
                    />
                    <has-error :form="form" field="password"></has-error>
                  </div>
                </div>
              </div>
            </tab-content>
            <tab-content title="Lokasi Siswa" icon="fas fa-map-marked-alt" :before-change="validateLokasi">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <b-form inline>
                      <label class="mr-sm-2" for="bujur">Bujur</label>
                      <b-form-input id="bujur" v-model="form.bujur" type="text" class="mb-2" placeholder="-" :class="{ 'is-invalid': form.errors.has('bujur') }" @change="isiBujur"></b-form-input>
                    </b-form>
                  </div>
                  <div class="col-md-6">
                    <b-form inline>
                      <label class="mr-sm-2" for="lintang">Lintang</label>
                      <b-form-input id="lintang" v-model="form.lintang" type="text" class="mb-2" placeholder="-" :class="{ 'is-invalid': form.errors.has('lintang') }" @change="isiLintang"></b-form-input>
                    </b-form>
                  </div>
                </div>
              </div>
              <GmapMap :center='center' :zoom='16' :sensor="false" labels:true :mapTypeId="mapTypeId" style='width:100%;  height: 400px;'>
                <GmapMarker :key="index" v-for="(m, index) in markers" :position="m.position" @click="center=m.position" :clickable="true" :draggable="true" @dragend="updateCoordinates"/>
              </GmapMap>
            </tab-content>
            <tab-content title="Pendaftaran PPDB" icon="fas fa-building" :before-change="validateAsyncSekolah">
              <div class="form-group row">
                <label for="sekolah" class="col-sm-2 col-form-label">Jenjang Sekolah</label>
                <div class="col-sm-10">
                  <v-select label="nama" :options="data_jenjang" v-model="form.bentuk_pendidikan_id" id="bentuk_pendidikan_id" :class="{'is-invalid': form.errors.has('bentuk_pendidikan_id')}" @input="getJalur"/>
                  <has-error :form="form" field="bentuk_pendidikan_id"></has-error>
                </div>
              </div>
              <div class="form-group row">
                <label for="sekolah" class="col-sm-2 col-form-label">Jalur Pendaftaran</label>
                <div class="col-sm-10">
                  <v-select label="nama" :options="data_jalur" v-model="form.jalur" id="jalur" :class="{'is-invalid': form.errors.has('jalur')}" @input="getSekolah"/>
                  <has-error :form="form" field="jalur"></has-error>
                </div>
              </div>
              <div class="form-group row" v-if="form.jalur.nama === 'Prestasi'">
                <label for="jenis_prestasi" class="col-sm-2 col-form-label">Jenis Prestasi</label>
                <div class="col-sm-10">
                  <v-select label="nama" :options="data_prestasi" v-model="form.jenis_prestasi" id="jenis_prestasi" :class="{'is-invalid': form.errors.has('jenis_prestasi')}"/>
                  <has-error :form="form" field="jenis_prestasi"></has-error>
                </div>
              </div>
              <div class="form-group row">
                <label for="sekolah" class="col-sm-2 col-form-label">Sekolah Tujuan</label>
                <div class="col-sm-10">
                  <v-select label="nama" :options="data_sekolah" v-model="form.sekolah" id="sekolah" :class="{'is-invalid': form.errors.has('sekolah')}" />
                  <has-error :form="form" field="sekolah"></has-error>
                </div>
              </div>
            </tab-content>
            <tab-content title="Periksa Data" icon="fas fa-check">
              <div class="row">
                <div class="col-6">
                  <h3>Detil Siswa</h3>
                  <table class="table">
                    <tr>
                      <td>Nama Lengkap</td>
                      <td>: {{form.name}}</td>
                    </tr>
                    <tr>
                      <td>Tempat, Tanggal Lahir</td>
                      <td>: {{form.tempat_lahir}}, {{form.tanggal_lahir | tanggalIndo}}</td>
                    </tr>
                    <tr>
                      <td>NIK</td>
                      <td>: {{form.nik}}</td>
                    </tr>
                    <tr>
                      <td>Alamat Lengkap</td>
                      <td>: {{form.alamat}}</td>
                    </tr>
                    <tr>
                      <td>RT/RW</td>
                      <td>: {{form.rt}}/{{form.rw}}</td>
                    </tr>
                    <tr>
                      <td>Jenis Kelamin</td>
                      <td>: {{form.jenis_kelamin.nama}}</td>
                    </tr>
                    <tr>
                      <td>Agama</td>
                      <td>: {{form.agama_id.nama}}</td>
                    </tr>
                    <tr>
                      <td>Nomor HP</td>
                      <td>: {{form.nomor_hp}}</td>
                    </tr>
                    <tr>
                      <td>Nama Orang Tua/Wali</td>
                      <td>: {{form.nama_ortu}}</td>
                    </tr>
                    <tr>
                      <td>Kebutuhan Khusus</td>
                      <td>: {{detil.kebutuhan_khusus}}</td>
                    </tr>
                    <tr>
                      <td>Tempat Tinggal</td>
                      <td>: {{form.jenis_tinggal_id.nama}}</td>
                    </tr>
                    <tr>
                      <td>Warga Negara</td>
                      <td>: {{form.wna.nama}}</td>
                    </tr>
                    <tr>
                      <td>Negara</td>
                      <td>: {{form.negara_id.nama}}</td>
                    </tr>
                    <tr>
                      <td>Provinsi</td>
                      <td>: {{detil.provinsi}}</td>
                    </tr>
                    <tr>
                      <td>Kabupaten Kota</td>
                      <td>: {{detil.kabupaten}}</td>
                    </tr>
                    <tr>
                      <td>Kecamatan</td>
                      <td>: {{detil.kecamatan}}</td>
                    </tr>
                    <tr>
                      <td>Desa/Kelurahan</td>
                      <td>: {{detil.desa}}</td>
                    </tr>
                    <tr>
                      <td>Lintang</td>
                      <td>: {{form.lintang}}</td>
                    </tr>
                    <tr>
                      <td>Bujur</td>
                      <td>: {{form.bujur}}</td>
                    </tr>
                  </table>
                </div>
                <div class="col-6">
                  <h3>Detil Pendaftaran</h3>
                  <table class="table">
                    <tr>
                      <td>Jenjang Sekolah</td>
                      <td>: {{form.bentuk_pendidikan_id.nama}}</td>
                    </tr>
                    <tr>
                      <td>Jalur Pendaftaran</td>
                      <td>: {{form.jalur.nama}}</td>
                    </tr>
                    <tr>
                      <td>Sekolah Tujuan</td>
                      <td>: {{form.sekolah.nama}}</td>
                    </tr>
                  </table>
                </div>
              </div>
            </tab-content>
            <div class="loader" v-if="loadingWizard"></div>
            <div v-if="errorMsg">
              <b-alert show variant="danger">
                <span v-html="errorMsg"></span>
              </b-alert>
            </div>
            <template slot="finish" slot-scope="props">
              <b-button squared variant="success" size="lg" :disabled="kunciTombol">
                <b-spinner small v-show="show_spinner"></b-spinner>
                <span class="sr-only" v-show="show_spinner">Sedang menyimpan...</span>
                <span v-show="show_text">Simpan Data</span>
              </b-button>
            </template>
          </form-wizard>
        </div>
      </div>
      <div class="main-card mb-3 card" v-else>
        <div class="card-body">
          <h1 class="text-center">PENDAFTARAN DITUTUP</h1>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
//import AddUser from "./components/AddUser"
//import Formulir from "./components/FormulirSekolah";
import Datepicker from "./components/TouchDatePicker";
import {FormWizard, TabContent} from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
export default {
  components: {
    //AddUser,
    //Formulir,
    FormWizard,
    TabContent,
    Datepicker
  },
  created() {
    this.loadPostsData();
  },
  data() {
    return {
      daftarOpen: true,
      kunciTombol: false,
      show_spinner: false,
      show_text: true,
      data_prestasi: [],
      detil: {
        provinsi: '',
        kabupaten: '',
        kecamatan: '',
        desa: '',
        kebutuhan_khusus: '-',
      },
      form: new Form({
        sekolah_id: user.sekolah_id,
        titipan: '',
        name: "",
        nik: "",
        wna: '',
        //this.form.wna = getData.wna === 0 || getData.wna ? { key: getData.wna, nama: nama_wna } : { key: 0, nama: 'Warga Negara Indonesia' };
        negara_id: '',
        provinsi_id: '',
        kabupaten_id: '',
        kecamatan_id: '',
        desa_id: '',
        alamat: "",
        rt: "",
        rw: "",
        tempat_lahir: "",
        tanggal_lahir: "",
        nomor_hp: "",
        nama_ortu: "",
        kebutuhan_khusus: null,
        password: '',
        jenis_kelamin: '',
        agama_id: '',
        jenis_tinggal_id : '',
        bentuk_pendidikan_id: '',
        sekolah: '',
        jalur: '',
        bujur: '',
        lintang: '',
        jenis_prestasi: {value: '', nama: '== Pilih Jenis Prestasi =='},
      }),
      jenis_tinggal: [],
      data_wna: [
        { value: 0, nama: "Warga Negara Indonesia" },
        { value: 1, nama: "Warga Negara Asing" },
      ],
      jenis_kelamin: [
        { value: "L", nama: "Laki-laki" },
        { value: "P", nama: "Perempuan" },
      ],
      data_negara: [],
      data_provinsi: [],
      data_kabupaten: [],
      data_kecamatan: [],
      data_desa: [],
      data_agama: [],
      data_kebutuhan_khusus: [],
      select_provinsi: true,
      select_kabupaten: true,
      select_kecamatan: true,
      select_desa: true,
      data_jenjang: [
        { nama: "SD", value: 5 },
        { nama: "SMP", value: 6 },
      ],
      data_sekolah: [],
      data_jalur: [],
      loadingWizard: false,
      errorMsg: null,
      count: 0,
      center: { lat: -7.195404, lng: 113.250257 },
      currentPlace: null,
      markers: [{
        position: {
          lat: -7.195404,
          lng: 113.250257
        }
      }],
      mapTypeId: 'hybrid',
    }
  },
  methods: {
    isiBujur(val){
      this.setPosisi(this.form.bujur, this.form.lintang);
    },
    isiLintang(val){
      this.setPosisi(this.form.bujur, this.form.lintang);
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
      }
    },
    updateCoordinates(location) {
      let lintang = Number(location.latLng.lat()).toFixed(6)
      let bujur = Number(location.latLng.lng()).toFixed(6)
      this.form.lintang = Number(lintang)
      this.form.bujur = Number(bujur)
    },
    loadPostsData() {
      this.form.wna                   = { key: 0, nama: 'Warga Negara Indonesia' }//{ value: '', nama: "== Pilih Warga Negara ==" }
      this.form.negara_id             = {value: 'ID', nama: 'Indonesia'}//{ value: '', nama: "== Pilih Negara ==" }
      this.form.provinsi_id           = {value: '050000  ', nama: 'Prov. Jawa Timur'}//{ value: '', nama: "== Pilih Provinsi ==" }
      this.form.kabupaten_id          = {value: '052700  ', nama: 'Kab. Sampang'}//{ value: '', nama: "== Pilih Kabupaten/Kota ==" }
      this.form.kecamatan_id          = { value: '', nama: "== Pilih Kecamatan ==" }
      this.form.desa_id               = { value: '', nama: "== Pilih Desa Kelurahan ==" }
      this.form.jenis_kelamin         = { value: "", nama: "== Pilih Jenis Kelamin" }
      this.form.agama_id              = { value: "", nama: "== Pilih Agama ==" },
      this.form.jenis_tinggal_id      = { value: "", nama: "== Pilih Tempat Tinggal ==" }
      this.form.bentuk_pendidikan_id  = {value: '', nama: "== Pilih Jenjang ==" }
      this.form.sekolah               = { value: "", nama: "== Pilih Sekolah Tujuan ==" }
      this.form.jalur                 = { value: "", nama: "== Pilih Jalur Pendaftaran ==" }
      this.form.titipan               = (this.hasRole('admin') && user.data.bentuk_pendidikan_id) ? 1 : 0
      this.select_provinsi = true
      this.select_kabupaten = true
      this.select_kecamatan = true
      this.select_desa = true
      this.getNegara(this.form.wna);
      this.getProvinsi(this.form.negara_id);
      this.getKabupaten(this.form.provinsi_id);
      this.getKecamatan(this.form.kabupaten_id);
      this.getDesa(this.form.kecamatan_id);
      this.getAgama()
      this.getNegara()
      this.getJenisTinggal()
      this.getKebutuhan()
    },
    getPrestasi(){
      axios.get(`/api/referensi/prestasi`)
      .then((response) => {
        let getData = response.data.data;
        this.data_prestasi = getData
      })
    },
    onComplete: function(){
      this.kunciTombol = true
      this.show_spinner = true
      this.show_text = false
      this.form.post(`/api/pendaftaran/siswa`)
      .then((response) => {
        console.log(response);
        Toast.fire({
          icon: "success",
          title: response.message,
        });
        this.loadPostsData();
        setTimeout(() => {
          this.$refs.wizard.navigateToTab(0)
          this.kunciTombol = false
          this.show_spinner = false
          this.show_text = true
        }, 1000)
      })
    },
    setLoading: function(value) {
      this.loadingWizard = value
    },
    handleValidation: function(isValid, tabIndex){
      console.log('Tab: '+tabIndex+ ' valid: '+isValid)
    },
    handleErrorMessage: function(errorMsg){
      this.errorMsg = errorMsg
    },
    validateLokasi:function() {
      let errorMessage = []
      var keys = ['lintang', 'bujur']
      var values = ["Lintang", 'Bujur']
      var obj = {};
      for(var i = 0; i < keys.length; i++){
          obj[keys[i]] = values[i];
      }
      let vm = this
      let inputan = null
      console.log(obj);
      $.each(obj, function(index, item){
        inputan = vm.form[index].value
        if(!vm.form[index]){
          errorMessage.push(obj[index]+ ': Tidak boleh kosong')  
        }
      })
      return new Promise((resolve, reject) => {
        setTimeout(() => {
          if(errorMessage.length){
            reject(errorMessage.join("<br>"))
          }else{
            this.count = 0
            resolve(true)
          }   
        }, 1000)
      })
    },
    validateAsyncSekolah:function() {
      let errorMessage = []
      var keys = null
      var values = null
      if(this.form.jalur.nama === 'Prestasi'){
        keys = ['bentuk_pendidikan_id', 'jalur', 'sekolah', 'jenis_prestasi']
        values = ['Jenjang Sekolah', 'Jalur Pendaftaran', 'Sekolah Tujuan', 'Jenis Prestasi']
      } else {
        keys = ['bentuk_pendidikan_id', 'jalur', 'sekolah']
        values = ['Jenjang Sekolah', 'Jalur Pendaftaran', 'Sekolah Tujuan']
      }
      var obj = {};
      for(var i = 0; i < keys.length; i++){
          obj[keys[i]] = values[i];
      }
      let vm = this
      let inputan = null
      var nama_inputan = null
      $.each(obj, function(index, item){
        inputan = vm.form[index].value
        nama_inputan = vm.form[index].nama
        console.log(nama_inputan);
        if(inputan === ''){
          errorMessage.push(obj[index]+ ': Tidak boleh kosong')  
        }
      })
      return new Promise((resolve, reject) => {
        setTimeout(() => {
          if(errorMessage.length){
            reject(errorMessage.join("<br>"))
          }else{
            this.count = 0
            resolve(true)
          }   
        }, 1000)
      })
    },
    validateAsync:function() {
      let errorMessage = []
      var keys = ['name', 'nik', 'wna', 'negara_id', 'provinsi_id', 'kabupaten_id', 'kecamatan_id', 'desa_id', 'alamat', 'rt', 'rw', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'nomor_hp', 'nama_ortu', 'agama_id', 'jenis_tinggal_id', 'password'];
      var values = ["Nama Lengkap", "NIK", "Warga Negara", "Negara", "Provinsi", "Kabupaten", "Kecamatan", "Desa/Kelurahan", "Alamat Lengkap", "RT", "RW", "Tempat Lahir", "Tanggal Lahir", "Jenis Kelamin", "Nomor HP", "Nama Orang Tua/Wali", "Agama", "Tempat Tinggal", 'Password'];
      var obj = {};
      for(var i = 0; i < keys.length; i++){
          obj[keys[i]] = values[i];
      }
      let vm = this
      let inputan = null
      /*
      detil: {
        provinsi: '',
        kabupaten: '',
        kecamatan: '',
        desa: '',
      },
      */
      if(typeof this.form['provinsi_id'] === 'object'){
        this.detil.provinsi = this.form['provinsi_id'].nama
      } else {
        this.detil.provinsi  = this.form['provinsi_id']
      }
      if(typeof this.form['kabupaten_id'] === 'object'){
        this.detil.kabupaten = this.form['kabupaten_id'].nama
      } else {
        this.detil.kabupaten  = this.form['kabupaten_id']
      }
      if(typeof this.form['kecamatan_id'] === 'object'){
        this.detil.kecamatan = this.form['kecamatan_id'].nama
      } else {
        this.detil.kecamatan  = this.form['kecamatan_id']
      }
      if(typeof this.form['desa_id'] === 'object'){
        this.detil.desa = this.form['desa_id'].nama
      } else {
        this.detil.desa  = this.form['desa_id']
      }
      let kebutuhan_khusus = []
      if(this.form.kebutuhan_khusus){
        $.each(this.form.kebutuhan_khusus, function(index, item){
          kebutuhan_khusus.push(item.nama)
        })
      }
      this.detil.kebutuhan_khusus =  (kebutuhan_khusus.length) ? kebutuhan_khusus.join(', ') : '-'
      $.each(obj, function(index, item){
        if(typeof vm.form[index] === 'object'){
          inputan = vm.form[index].value
        } else {
          inputan = vm.form[index]
        }
        if(inputan === ''){
          errorMessage.push(obj[index]+ ': Tidak boleh kosong')  
        }
        if(index === 'nik'){
          if(inputan.length > 16){
            errorMessage.push(obj['nik']+ ': NIK maksimal harus 16 angka')  
          } else
          if(inputan.length < 16){
            errorMessage.push(obj['nik']+ ': NIK minimal harus 16 angka')
          } else
          if(inputan.length === 16){
            axios.post(`/api/users/check-nik`, {nik: inputan}).then((response) => {
              if(response.data){
                if(response.data.user){
                  errorMessage.push(obj['nik']+ ': Sudah terdaftar di database!')
                }
              }
            });
          }
        }
      })
      return new Promise((resolve, reject) => {
        setTimeout(() => {
          if(errorMessage.length){
            reject(errorMessage.join("<br>"))
          }else{
            this.count = 0
            resolve(true)
          }   
        }, 1000)
      })
    },
    getJenisTinggal() {
      axios.post(`/api/users/jenis-tinggal`).then((response) => {
        let getData = response.data.data;
        this.jenis_tinggal = getData;
        let formulir = this.form;
        $.each(getData, function (key, value) {
          if (user.data.jenis_tinggal_id === value.id) {
            formulir.jenis_tinggal_id = value;
          }
        });
      });
    },
    getKebutuhan() {
      axios.post(`/api/users/kebutuhan-khusus`).then((response) => {
        let getData = response.data.data;
        this.data_kebutuhan_khusus = getData;
        //this.form.kebutuhan_khusus = user.data.kebutuhan_khusus;
      });
    },
    getAgama() {
      axios.post(`/api/users/agama`).then((response) => {
        let getData = response.data.data;
        this.data_agama = getData;
        let formulir = this.form;
        $.each(getData, function (key, value) {
          if (user.data.agama_id && user.data.agama_id === value.id) {
            formulir.agama_id = value;
          }
        });
      });
    },
    getNegara(val = null) {
      let negara = null;
      if (val === null) {
        return false;
      } else {
        negara = val.value;
      }
      axios
        .post(`/api/users/negara`, {
          negara: negara,
        })
        .then((response) => {
          let getData = response.data.data;
          if(!this.hasRole('admin')){
            this.daftarOpen = response.data.open
          }
          this.data_negara = getData;
          let formulir = this.form;
          $.each(getData, function (key, value) {
            if (user.data.negara_id && user.data.negara_id === value.negara_id) {
              formulir.negara_id = { negara_id: value.negara_id, nama: value.nama };
            }
          });
        });
    },
    getProvinsi(val) {
      let negara_id;
      if (!val) {
        return false;
      } else {
        negara_id = val.value;
      }
      axios
        .post(`/api/users/provinsi`, {
          negara_id: negara_id,
        })
        .then((response) => {
          let getData = response.data.data;
          if (getData.length) {
            this.select_provinsi = true;
            this.data_provinsi = getData;
          } else {
            this.form.provinsi_id = "";
            this.form.kabupaten_id = "";
            this.form.kecamatan_id = "";
            this.form.desa_id = "";
            this.select_provinsi = false;
            this.select_kabupaten = false;
            this.select_kecamatan = false;
            this.select_desa = false;
          }
          if (user.data.provinsi_id) {
            let formulir = this.form;
            $.each(getData, function (key, value) {
              if (
                user.data.provinsi_id &&
                user.data.provinsi_id === value.kode_wilayah.trim()
              ) {
                formulir.provinsi_id = value;
              }
            });
            if (!this.form.provinsi_id) {
              this.select_provinsi = false;
              this.form.provinsi_id = user.data.provinsi;
            }
          }
        });
    },
    getKabupaten(val) {
      let provinsi_id;
      if (!val) {
        return false;
      } else {
        provinsi_id = val.value;
      }
      axios
        .post(`/api/users/kabupaten`, {
          provinsi_id: provinsi_id,
        })
        .then((response) => {
          let getData = response.data.data;
          this.data_kabupaten = getData;
          if (getData.length) {
            this.select_kabupaten = true;
          }
          if (user.data.kabupaten_id) {
            let formulir = this.form;
            $.each(getData, function (key, value) {
              if (
                user.data.kabupaten_id &&
                user.data.kabupaten_id === value.kode_wilayah.trim()
              ) {
                formulir.kabupaten_id = value;
              }
            });
            if (!this.form.kabupaten_id) {
              this.select_kabupaten = false;
              this.form.kabupaten_id = user.data.kabupaten;
            }
          }
        });
    },
    getKecamatan(val) {
      let kabupaten_id;
      if (!val) {
        return false;
      } else {
        kabupaten_id = val.value;
      }
      axios
        .post(`/api/users/kecamatan`, {
          kabupaten_id: kabupaten_id,
        })
        .then((response) => {
          let getData = response.data.data;
          this.data_kecamatan = getData;
          if (getData.length) {
            this.select_kecamatan = true;
          }
          if (user.data.kecamatan_id) {
            let formulir = this.form;
            $.each(getData, function (key, value) {
              if (
                user.data.kecamatan_id &&
                user.data.kecamatan_id === value.kode_wilayah.trim()
              ) {
                formulir.kecamatan_id = value;
              }
            });
            if (!this.form.kecamatan_id) {
              this.select_kecamatan = false;
              this.form.kecamatan_id = user.data.kecamatan;
            }
          }
        });
    },
    getDesa(val) {
      let kecamatan_id;
      if (!val) {
        return false;
      } else {
        kecamatan_id = val.value;
      }
      axios
        .post(`/api/users/desa`, {
          kecamatan_id: kecamatan_id,
        })
        .then((response) => {
          let getData = response.data.data;
          this.data_desa = getData;
          if (getData.length) {
            this.select_desa = true;
          }
          if (user.data.desa_id) {
            let formulir = this.form;
            $.each(getData, function (key, value) {
              if (user.data.desa_id && user.data.desa_id === value.kode_wilayah.trim()) {
                formulir.desa_id = value;
              }
            });
            if (!this.form.desa_id) {
              this.select_desa = false;
              this.form.desa_id = user.data.desa;
            }
          }
        });
    },
    getJalur(val){
      axios
        .post(`/api/pendaftaran/all-jalur`, {
          bentuk_pendidikan_id: val.value,
        })
        .then((response) => {
          let getData = response.data.data;
          this.data_jalur = getData;
        });
    },
    getSekolah(val) {
      let bentuk_pendidikan_id = this.form.bentuk_pendidikan_id.value;
      axios
        .post(`/api/pendaftaran/all-sekolah`, {
          bentuk_pendidikan_id: bentuk_pendidikan_id,
          jalur_id: val.id,
          user_id: user.user_id,
        })
        .then((response) => {
          let getData = response.data.data;
          this.data_sekolah = getData;
          this.getPrestasi()
        });
    },
  },
};
</script>
<style>
/* This is a css loader. It's not related to vue-form-wizard */
.loader,
.loader:after {
  border-radius: 50%;
  width: 10em;
  height: 10em;
}
.loader {
  margin: 60px auto;
  font-size: 10px;
  position: relative;
  text-indent: -9999em;
  border-top: 1.1em solid rgba(255, 255, 255, 0.2);
  border-right: 1.1em solid rgba(255, 255, 255, 0.2);
  border-bottom: 1.1em solid rgba(255, 255, 255, 0.2);
  border-left: 1.1em solid #e74c3c;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
  -webkit-animation: load8 1.1s infinite linear;
  animation: load8 1.1s infinite linear;
}
@-webkit-keyframes load8 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes load8 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
</style>