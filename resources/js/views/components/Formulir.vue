<template>
  <div>
    <template v-if="!sekolah_pilihan_count">
      <div class="main-card mb-3 card">
        <form @submit.prevent="insertData()" method="post" v-if="profil_pengguna">
          <div class="card-body">
            <input type="hidden" v-model="form.pilihan_ke" class="form-control">
            <div class="row">
              <div class="col-12">
                <div class="alert alert-danger" v-show="errors">
                  <h5><i class="icon fas fa-ban"></i> Isian Tidak Valid!</h5>
                  <ul>
                    <li v-for="(error, key) in errors">
                      {{error}}
                    </li>
                  </ul>
                </div>
                <div class="form-group row" v-if="tautan === 'prestasi'">
                  <label for="jenis_prestasi" class="col-sm-2 col-form-label">Jenis Prestasi</label>
                  <div class="col-sm-10">
                    <v-select :disabled="kunci" label="nama" :options="data_prestasi" v-model="form.jenis_prestasi" id="jenis_prestasi" :class="{'is-invalid': form.errors.has('jenis_prestasi')}" @input="getSekolah"/>
                    <has-error :form="form" field="jenis_prestasi"></has-error>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="sekolah" class="col-sm-2 col-form-label">Sekolah Tujuan</label>
                  <div class="col-sm-10">
                    <v-select :disabled="kunci" label="nama" :options="data_sekolah" v-model="form.sekolah" id="sekolah" :class="{'is-invalid': form.errors.has('sekolah_id')}" @input="getKomponen"/>
                    <has-error :form="form" field="sekolah"></has-error>
                  </div>
                </div>
                <!--div class="form-group row" v-if="tautan === 'prestasi' && form.jenis_prestasi.value === 1">
                  <label for="jenis_prestasi" class="col-sm-2 col-form-label">Nilai Akreditasi Sekolah Asal</label>
                  <div class="col-sm-10">
                    <b-input-group>
                      <b-input-group-prepend>
                        <b-button variant="danger" :disabled="kunci" v-b-modal.modal-akreditasi>Klik disini untuk mencari nilai akreditasi sekolah Anda!</b-button>
                      </b-input-group-prepend>
                      <b-form-input v-model="form.akreditasi" :class="{'is-invalid': form.errors.has('akreditasi')}" :readonly="kunci"></b-form-input>
                    </b-input-group>
                    <has-error :form="form" field="jenis_prestasi"></has-error>
                  </div>
                </div-->
                <div class="form-group row">
                  <label for="sekolah" class="col-sm-2 col-form-label">Kelengkapan Dokumen</label>
                  <div class="col-sm-10">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th width="20%">Komponen</th>
                          <th width="30%">Jenis Dokumen</th>
                          <!--th width="10%">Tanggal Terbit Dokumen</th-->
                          <th width="40%">Form Upload Dokumen</th>
                          <th width="10%">Status Verifikasi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(dokumen, index) in all_dokumen">
                          <td>{{ dokumen.nama }}</td>
                          <td>{{ dokumen.bukti }}</td>
                          <!--td v-if="dokumen.dokumen">{{ dokumen.dokumen.tanggal | tanggalIndo }}</td>
                          <td v-else>
                            <input id="dokumen_id" v-model="form.dokumen_id[dokumen.id]" type="hidden"></input>
                            <template v-if="dokumen.tanggal">
                              <date-picker v-model="form.tanggal[dokumen.id]" valueType="format" autocomplete="off" :class="{'is-invalid': form.errors.has('tanggal[dokumen.id]')}"></date-picker>
                              <has-error :form="form" field="tanggal[dokumen.id]"></has-error>
                            </template>
                            <template v-else>
                              -
                            </template>
                          </td-->
                          <td v-if="dokumen.dokumen">
                            <a :href="'/uploads/' + dokumen.dokumen.berkas" class="btn btn-primary" target="_blank">Lihat Dokumen <i class="fa fa-external-link-alt"></i></a>
                            <button v-if="!kunci" @click="hapusDokumen(dokumen.dokumen.dokumen_id)" type="button" class="btn btn-danger">Hapus Dokumen <i class="fa fa-trash"></i></button>
                          </td>
                          <td v-else>
                            <b-form-file :class="{'is-invalid': form.errors.has('file[dokumen.id]')}" id="upload-dokumen" v-model="form.file[dokumen.id]" accept=".jpg, .png, .jpeg, .pdf" placeholder="Pilih berkas" drop-placeholder="Drop file here..."
                            ></b-form-file>
                            <has-error :form="form" field="file[dokumen.id]"></has-error>
                          </td>
                          <td class="text-center" v-if="dokumen.dokumen">
                            <b-badge variant="secondary" v-if="!dokumen.dokumen.status_id">Belum diverifikasi</b-badge>
                            <b-badge variant="success" v-if="dokumen.dokumen.status_id && dokumen.dokumen.status.nama == 'Terima'">Diterima</b-badge>
                            <b-badge variant="danger" v-if="dokumen.dokumen.status_id && dokumen.dokumen.status.nama == 'Tolak'">Ditolak</b-badge>
                            <b-badge variant="warning" v-if="dokumen.dokumen.status_id && dokumen.dokumen.status.nama == 'Perbaikan'">Perbaikan</b-badge>
                          </td>
                          <td class="text-center" v-else>
                            -
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="form-group row" v-if="formulir_prestasi">
                  <div class="col">
                    <h3>Piagam Prestasi <b-button squared variant="warning" size="sm" v-on:click="addRow" :disabled="kunci || show_spinner_pendaftaran">Tambah Data</b-button></h3>
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th class="text-center">No</th>
                          <th class="text-center">Jenis Kejuaraan</th>
                          <th class="text-center">Tingkat</th>
                          <th class="text-center">Juara Ke-</th>
                          <th class="text-center">Tanggal Terbit Piagam</th>
                          <th class="text-center">Berkas Piagam</th>
                          <th class="text-center">Status Verifikasi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(juara, index) in kejuaraan" class="juara">
                          <td class="text-center">{{index + 1}}</td>
                          <td class="text-center" v-if="juara.id">{{(juara.skor_prestasi) ? juara.skor_prestasi.jenis_kejuaraan.nama : '-'}}</td>
                          <td v-else>
                            <v-select label="nama" :options="jenis_kejuaraan" v-model="form.jenis_kejuaraan_id[index]" id="jenis_kejuaraan_id" />
                          </td>
                          <td class="text-center" v-if="juara.id">{{juara.tingkat_prestasi.nama}}</td>
                          <td v-else>
                            <v-select label="nama" :options="tingkat_prestasi" v-model="form.prestasi_id[index]" id="prestasi_id" />
                          </td>
                          <td class="text-center" v-if="juara.id">{{juara.juara}}</td>
                          <td class="text-center" v-else>
                            <v-select label="nama" :options="[1,2,3]" v-model="form.juara[index]" id="juara" />
                          </td>
                          <td class="text-center" v-if="juara.id">{{juara.tanggal | tanggalIndo}}</td>
                          <td v-else>
                            <datepicker v-bind:language="'id'" v-bind:placeholder="'Tanggal Terbit Piagam'" v-bind:input-class="{'form-control': true}" v-bind:min="'1990-01-01'" v-bind:max="'2020-12-31'" v-bind:data-vv-as="'Masukkan Tanggal Terbit Piagam'" v-model="form.tanggal_juara[index]" v-bind:v-validate="{ required: true, date_format: 'YYYY-MM-DD' }" name="tanggal_juara" id="tanggal_juara"></datepicker>
                          </td>
                          <td class="text-center" v-if="juara.id">
                            <a :href="'/uploads/' + juara.dokumen" class="btn btn-primary" target="_blank">Lihat Dokumen <i class="fa fa-external-link-alt"></i></a>
                            <b-button squared variant="danger" size="sm" @click="hapusJuara(juara.id)" v-if="juara.id && !kunci" :disabled="kunci || show_spinner_pendaftaran">Hapus</b-button>
                            <b-button squared variant="danger" size="sm" @click="removeElement" v-if="!kunci && !juara.id" :disabled="kunci || show_spinner_pendaftaran">Hapus</b-button>
                          </td>
                          <td v-else>
                            <b-form-file v-model="upload_piagam[index]" :state="Boolean(upload_piagam[index])" accept=".jpg, .png, .jpeg, .pdf, .zip" placeholder="Cari berkas Piagam..." drop-placeholder="Letakkan berkas Piagam disini..."></b-form-file>
                          </td>
                          <td class="text-center" v-if="juara.id">
                            <b-badge variant="secondary" v-if="!juara.status_id">Belum diverifikasi</b-badge>
                            <b-badge variant="success" v-if="juara.status_id && juara.status.nama == 'Terima'">Diterima</b-badge>
                            <b-badge variant="danger" v-if="juara.status_id && juara.status.nama == 'Tolak'">Ditolak</b-badge>
                            <b-badge variant="warning" v-if="juara.status_id && juara.status.nama == 'Perbaikan'">Perbaikan</b-badge>
                          </td>
                          <td class="text-center" v-else>
                            -
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!--div class="form-group row" v-if="form.jenis_prestasi && form.jenis_prestasi.value === 1">
                  <label for="sekolah" class="col-sm-2 col-form-label">Nilai Rapor</label>
                  <div class="col-sm-10">
                    <table class="table table-bordered">
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
                          <td><b-form-input v-model="form.nilai[mapel.id]['IV'][1]" size="sm" :placeholder="'Nilai '+mapel.nama" @keypress="isNumber($event)"></b-form-input></td>
                          <td><b-form-input v-model="form.nilai[mapel.id]['IV'][2]" size="sm" :placeholder="'Nilai '+mapel.nama" @keypress="isNumber($event)"></b-form-input></td>
                          <td><b-form-input v-model="form.nilai[mapel.id]['V'][1]" size="sm" :placeholder="'Nilai '+mapel.nama" @keypress="isNumber($event)"></b-form-input></td>
                          <td><b-form-input v-model="form.nilai[mapel.id]['V'][2]" size="sm" :placeholder="'Nilai '+mapel.nama" @keypress="isNumber($event)"></b-form-input></td>
                          <td><b-form-input v-model="form.nilai[mapel.id]['VI'][1]" size="sm" :placeholder="'Nilai '+mapel.nama" @keypress="isNumber($event)"></b-form-input></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div-->
              </div>
            </div>
            <b-progress :value="progressBar" max="100" height="20px" show-progress animated v-if="progressBar"></b-progress>
          </div>
          <div class="card-footer">
            <button v-if="all_komponen" :disabled="kunci || show_spinner_pendaftaran" type="button" class="btn btn-danger btn-lg mr-2" @click="kunciPendaftaran(sekolah_pilihan_id)">
              Kunci Pendaftaran <i class="fa fa-user-lock"></i>
            </button>
            <button class="btn btn-lg btn-primary float-right" :disabled="kunci || show_spinner_pendaftaran">
              <b-spinner small v-show="show_spinner_pendaftaran"></b-spinner>
              <span class="sr-only" v-show="show_spinner_pendaftaran">Sedang menyimpan...</span>
              <span v-show="show_text_pendaftaran">SIMPAN PENDAFTARAN</span>
            </button>
          </div>
        </form>
      </div>
    </template>
    <template v-else>
      <b-alert variant="danger" show class="text-center">
        <h3>Anda sudah terdaftar di 2 (dua) sekolah. Anda tidak dapat melakukan pendaftaran lagi!</h3>
      </b-alert>
    </template>
    <template v-if="!profil_pengguna">
      <b-alert show class="text-center">
          <h3>Pendaftaran bisa dilakukan setelah Anda melengkapi semua data! <b-badge variant="danger" to="/profil">Lengkapi Data Anda Disini</b-badge></h3>
      </b-alert>
    </template>
    <b-modal id="modal-akreditasi" title="Cari nilai akreditasi sekolah" size="lg" ref="akreditasi" hide-footer>
      <div class="form-group row">
        <label for="jenis_prestasi" class="col-sm-3 col-form-label">NPSN/Nama Sekolah</label>
        <div class="col-sm-9">
          <b-input-group>
            <b-form-input v-model="npsn"></b-form-input>
            <b-input-group-append>
              <b-button variant="success" @click="cariAkreditasi" :disabled="!validation || show_spinner_akreditasi">
                <b-spinner small v-show="show_spinner_akreditasi" label="Sedang mencari..."></b-spinner>
                <span class="sr-only" v-show="show_spinner_akreditasi">Sedang mencari...</span>
                <span v-show="show_text_akreditasi">CARI</span>
              </b-button>
            </b-input-group-append>
          </b-input-group>
          <b-form-invalid-feedback :state="validation">
            NPSN/Nama Sekolah minimal 8 karakter
          </b-form-invalid-feedback>
        </div>
      </div>
      <template v-if="sekolah_akreditasi.length">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">NPSN</th>
              <th class="text-center">Sekolah</th>
              <th class="text-center">Tahun Akreditasi</th>
              <th class="text-center">Peringkat</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(sekolah, index) in sekolah_akreditasi">
              <td class="text-center">{{index + 1}}</td>
              <td class="text-center">{{sekolah.npsn}}</td>
              <td>{{sekolah.nama}}</td>
              <td class="text-center">{{sekolah.tahun}}</td>
              <td class="text-center">{{sekolah.nilai}}</td>
              <td class="text-center"><b-button size="sm" variant="danger" type="button" @click="pilihAkreditasi(sekolah.nilai)">PILIH</b-button></td>
            </tr>
          </tbody>
        </table>
      </template>
      <template v-if="akreditasi_kosong">
        <b-alert variant="danger" show class="text-center">
        <h3>Data sekolah tidak ditemukan. Silahkan periksa kembali NPSN/Nama Sekolah!</h3>
      </b-alert>
      </template>
    </b-modal>
  </div>
</template>
<script>
import Mapel from "./Mapel";
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';  
import Datepicker2 from "./TouchDatePicker";
export default {
  components: {
    DatePicker,
    'datepicker' : Datepicker2,
    Mapel
  },
  created() {
    this.loadPostsData();
  },
  computed: {
    validation() {
      return this.npsn.length > 7
    }
  },
  mounted() {
    this.$loading(true)
    this.$root.$on('bv::modal::hide', (bvEvent, modalId) => {
      //this.loadPostsData()
    })
  },
  data() {
    return {
      formulir_prestasi: 0,
      kejuaraan: [],
      tingkat_prestasi: [],
      npsn: '',
      show_spinner_akreditasi: false,
      show_text_akreditasi: true,
      akreditasi_kosong: false,
      sekolah_akreditasi: [],
      show_spinner_pendaftaran: false,
      show_text_pendaftaran: true,
      mata_pelajaran: [],
      pendaftar_id: null,
      profil_pengguna: null,
      form: new Form({
        user_id: user.user_id,
        bentuk_pendidikan_id: "",
        sekolah: { value: "", nama: "== Pilih Sekolah Pilihan ==" },
        jenis_prestasi: '',//{value: 1, nama: 'Prestasi Akademik'},
        jenis_kejuaraan_id: {},
        jalur_id: '',
        file: [],
        tanggal: [],
        dokumen_id: [],
        nilai: {},
        akreditasi: '',
        pilihan_ke: 0,
        prestasi_id: {},
        juara: {},
        tanggal_juara: {},
      }),
      upload_piagam: [],
      data_prestasi: [
        //{value: 1, nama: 'Prestasi Akademik'}, 
        //{value: 2, nama: 'Prestasi Kejuaraan'}
      ],
      data_jenjang: [
        { nama: "SD", bentuk_pendidikan_id: 5 },
        { nama: "SMP", bentuk_pendidikan_id: 6 },
      ],
      data_sekolah: [],
      data_jalur: [],
      sudah_daftar: 0,
      kunci: false,
      komponen: null,
      all_dokumen: [],
      progressBar: 0,
      foto: {
        file: [],
      },
      tombol_finish: 0,
      all_komponen: 0,
      data_pendaftaran: [],
      sekolah_pilihan_id: null,
      jalur: null,
      tanggal: [],
      jenis_kejuaraan: [],
      errors: null,
      sekolah_pilihan_count: false,
      tautan: this.$route.meta,
    };
  },
  methods: {
    disabledBeforeTodayAndAfterAWeek(date) {
      const today = new Date();
      //const mundur = new Date(date.setMonth(date.getMonth() - 3));
      today.setHours(0, 0, 0, 0);
      //mundur.setHours(0, 0, 0, 0);
      //console.log(mundur);
      //return date < today || date > today;
      return date < today || date > new Date(today.getTime() + 7 * 24 * 3600 * 1000);
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
    pilihAkreditasi(nilai){
      this.form.akreditasi = nilai
      this.$refs['akreditasi'].hide()
    },
    cariAkreditasi(){
      this.show_spinner_akreditasi = true
      this.show_text_akreditasi = false
      axios.post(`/api/referensi/akreditasi`, {
        npsn: this.npsn,
      }).then((response) => {
        this.show_spinner_akreditasi = false
        this.show_text_akreditasi = true
        let getData = response.data.data;
        if(getData.length){
          this.akreditasi_kosong = false
        } else {
          this.akreditasi_kosong = true
        }
        this.sekolah_akreditasi = getData
      });
    },
    isNumber: function(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
        evt.preventDefault();
      } else {
        return true;
      }
    },
    loadPostsData() {
      this.npsn = ''
      this.akreditasi_kosong = false
      this.sekolah_akreditasi = []
      this.errors = null
      let route = this.$route.meta
      axios
        .get(`/api/pendaftaran`, {
          params: {
            user_id: user.user_id,
            tautan: route
          },
        })
        .then((response) => {
          let getData = response.data.data;
          this.profil_pengguna = getData.pengguna.bujur
          this.data_prestasi = getData.jenis_prestasi
          this.form.jenis_prestasi = (getData.jenis_prestasi) ? getData.jenis_prestasi[0] : null
          if(this.form.jenis_prestasi){
            this.getSekolah(this.form.jenis_prestasi, getData.pengguna.bentuk_pendidikan_id, user.user_id)
          } else {
            this.getSekolah(null, getData.pengguna.bentuk_pendidikan_id, user.user_id)
          }
          this.form.bentuk_pendidikan_id = getData.pengguna.bentuk_pendidikan_id
          this.form.jalur_id = getData.jalur.id
          this.formulir_prestasi = getData.jalur.prestasi
          if(getData.pendaftar){
            this.pendaftar_id = getData.pendaftar.pendaftar_id
            if(getData.pendaftar.sekolah_pilihan_single){
              this.form.pilihan_ke = (getData.pendaftar.sekolah_pilihan_single.pilihan_ke) ? getData.pendaftar.sekolah_pilihan_single.pilihan_ke : 1
              if(getData.pendaftar.sekolah_pilihan_single.jenis_prestasi){
                this.form.jenis_prestasi = {value:getData.pendaftar.sekolah_pilihan_single.jenis_prestasi.id, nama: getData.pendaftar.sekolah_pilihan_single.jenis_prestasi.nama}
              }
              this.form.akreditasi = getData.pendaftar.sekolah_pilihan_single.akreditasi
              this.form.sekolah = { value: getData.pendaftar.sekolah_pilihan_single.sekolah_id, nama: getData.pendaftar.sekolah_pilihan_single.sekolah.nama }
              this.sekolah_pilihan_id = getData.pendaftar.sekolah_pilihan_single.sekolah_pilihan_id
              this.kunci = (getData.pendaftar.sekolah_pilihan_single.kunci == 1) ? true : false
            } else {
              this.sekolah_pilihan_count = (getData.pendaftar.sekolah_pilihan_count > 1) ? true : false
              this.form.pilihan_ke = getData.pendaftar.sekolah_pilihan_count + 1
            }
          } else {
            this.form.pilihan_ke = 1
          }
          this.getPrestasi(this.pendaftar_id, this.form.jalur_id)
        });
    },
    getSekolah(jenis_prestasi = null, bentuk_pendidikan_id = null, user_id = null) {
      if(!bentuk_pendidikan_id){
        bentuk_pendidikan_id = this.form.bentuk_pendidikan_id
      }
      if(!user_id){
        user_id = user.user_id
      }
      axios.post(`/api/pendaftaran/all-sekolah`, {
        bentuk_pendidikan_id: bentuk_pendidikan_id,
        user_id: user_id,
        tautan: this.$route.meta,
        jenis_prestasi: (jenis_prestasi) ? jenis_prestasi.value : null,
      }).then((response) => {
        let getData = response.data.data;
        this.data_sekolah = getData;
        let set_jenis_prestasi = (jenis_prestasi) ? jenis_prestasi.value : 0
        this.getKomponen()
      });
    },
    getKomponen() {
      axios
        .post(`/api/pendaftaran/all-komponen`, {
          jalur_id: this.form.jalur_id,
          pendaftar_id: this.pendaftar_id,
          jenis_prestasi: (this.form.jenis_prestasi) ? this.form.jenis_prestasi.value : 0,
        })
        .then((response) => {
          let getData = response.data.data;
          this.all_dokumen = getData;
          let tempDokumen = {}
          let tempTanggal = {}
          let tempCekDokumen = 0;
          $.each(getData, function (key, value) {
            if(value.tanggal){
              if(value.dokumen){
                tempTanggal[value.id] = value.dokumen.tanggal
              } else {
                tempTanggal[value.id] = null
              }
            }
            if(!value.dokumen){
              tempDokumen[value.id] = value.id
            }
            if(value.dokumen){
              tempCekDokumen++;
            }
          });
          this.form.tanggal = tempTanggal
          this.form.dokumen_id = tempDokumen
          if(tempCekDokumen){
            this.all_komponen = 1;
          } else {
            this.all_komponen = 0;
          }
          this.jenis_kejuaraan = response.data.jenis_kejuaraan
        });
    },
    objectSize(obj){
      return Object.keys(obj).length
    },
    insertData() {
      this.show_spinner_pendaftaran = true
      this.show_text_pendaftaran = false
      let formData = new FormData();
      let formulir = this.form
      $.each(this.form.dokumen_id, function (key, value) {
        if(value){
          formData.append('files[' + key + ']', formulir.file[key]);
        }
      });
      //$.each(this.form.tanggal, function (key, value) {
        //formData.append('tanggal[' + key + ']', formulir.tanggal[key]);
      //});
      let jenis_prestasi = (this.form.jenis_prestasi) ? this.form.jenis_prestasi.value : ''
      let sekolah_id = (this.form.sekolah) ? this.form.sekolah.value : ''
      //let akreditasi = (this.form.akreditasi) ? this.form.akreditasi : ''
      formData.append("jenis_prestasi", jenis_prestasi);
      //formData.append("akreditasi", akreditasi);
      formData.append("sekolah_id", sekolah_id);
      formData.append("user_id", user.user_id);
      formData.append("jalur_id", this.form.jalur_id);
      formData.append("tautan", this.tautan);
      formData.append("pilihan_ke", this.form.pilihan_ke);
      let vm = this
      if(this.objectSize(this.form.prestasi_id)){
        $.each(this.form.prestasi_id, function(key, value){
          formData.append("prestasi_id["+key+"]", value.id);
          formData.append("juara["+key+"]", formulir.juara[key]);
          formData.append("tanggal_juara["+key+"]", formulir.tanggal_juara[key]);
          formData.append("upload_piagam["+key+"]", vm.upload_piagam[key]);
          formData.append("jenis_kejuaraan_id["+key+"]", value.id);
        })
      }
      axios.post( '/api/pendaftaran',
          formData,
          {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
            onUploadProgress: function( progressEvent ) {
              this.progressBar = parseInt( Math.round( ( progressEvent.loaded / progressEvent.total ) * 100 ));
            }.bind(this)
          }
        ).then((response) => {
          Swal.fire('Berhasil', 'Pendaftaran berhasil disimpan', 'success').then(() => {
            this.progressBar = 0
            this.loadPostsData();
            this.show_spinner_pendaftaran = false
            this.show_text_pendaftaran = true
          });
        })
        .catch((error) => {
          this.progressBar = 0
          this.show_spinner_pendaftaran = false
          this.show_text_pendaftaran = true
          let getData = error.response.data;
          let message = [];
          $.each(getData.errors, function (key, value) {
            message.push(value[0]);
          });
          this.errors = message
        });
    },
    hapusDokumen(dokumen_id) {
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
          return fetch("/api/pendaftaran/hapus-file/" + dokumen_id, {
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
    kunciPendaftaran(pendaftar_id) {
      Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Proses Pendaftaran akan dikunci!!!",
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya!",
        cancelButtonText: "Batal",
      }).then((result) => {
        if (result.value) {
          return fetch("/api/pendaftaran/kunci/" + pendaftar_id)
            .then((response) => response.json())
            .then((data) => {
              Swal.fire(data.title, data.message, data.status).then(() => {
                this.loadPostsData();
              });
            });
        }
      });
    },
    getPrestasi(pendaftar_id, jalur_id){
      axios.post(`/api/pendaftaran/prestasi`, {
        pendaftar_id: pendaftar_id,
        jalur_id: jalur_id,
      }).then((response) => {
        this.$loading(false)
        let getData = response.data.data;
        this.kejuaraan = getData.piagam
        this.tingkat_prestasi = getData.tingkat_prestasi
      })
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
              this.getPrestasi(this.pendaftar_id);
            });
          });
        }
      });
    },
  },
};
</script>
<style>
.vs__dropdown-toggle{padding:2px 0 8px 0;}
.vs__open-indicator{margin-top:5px;}
</style>