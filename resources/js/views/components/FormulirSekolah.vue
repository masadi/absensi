<template>
  <div>
    <template>
      <div class="main-card mb-3 card">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-download mr-1"></i>
            Formulir Pendaftaran PPDB
          </h3>
        </div>
        <form @submit.prevent="insertData()" method="post">
          <div class="card-body">
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
                <div class="form-group row">
                  <label for="sekolah" class="col-sm-2 col-form-label">Sekolah Tujuan</label>
                  <div class="col-sm-10">
                    <v-select label="nama" :options="data_sekolah" v-model="form.sekolah" id="sekolah" :class="{'is-invalid': form.errors.has('sekolah')}" @input="getSiswa"/>
                    <has-error :form="form" field="sekolah"></has-error>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="siswa" class="col-sm-2 col-form-label">Nama Siswa</label>
                  <div class="col-sm-10">
                    <v-select label="name" :options="data_siswa" v-model="form.siswa" id="siswa" :class="{'is-invalid': form.errors.has('siswa')}" @input="getKomponen"/>
                    <has-error :form="form" field="siswa"></has-error>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="sekolah" class="col-sm-2 col-form-label">Kelengkapan Dokumen</label>
                  <div class="col-sm-10">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th width="20%">Komponen</th>
                          <th width="40%">Jenis Dokumen</th>
                          <th width="10%">Tanggal Terbit Dokumen</th>
                          <th width="30%">Form Upload Dokumen</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(dokumen, index) in all_dokumen">
                          <td>{{ dokumen.nama }}</td>
                          <td>{{ dokumen.bukti }}</td>
                          <td v-if="dokumen.dokumen">{{ dokumen.dokumen.tanggal | tanggalIndo }}</td>
                          <td v-else>
                            <input id="dokumen_id" v-model="form.dokumen_id[dokumen.id]" type="hidden"></input>
                            <template v-if="dokumen.tanggal">
                              <date-picker v-model="form.tanggal[dokumen.id]" valueType="format" autocomplete="off" :class="{'is-invalid': form.errors.has('tanggal[dokumen.id]')}"></date-picker>
                              <has-error :form="form" field="tanggal[dokumen.id]"></has-error>
                            </template>
                            <template v-else>
                              -
                            </template>
                          </td>
                          <td v-if="dokumen.dokumen">
                            <a :href="'/uploads/' + dokumen.dokumen.berkas" class="btn btn-primary" target="_blank">Lihat Dokumen <i class="fa fa-external-link-alt"></i></a>
                            <button v-if="!kunci" @click="hapusDokumen(dokumen.dokumen.dokumen_id)" class="btn btn-danger">Hapus Dokumen <i class="fa fa-trash"></i></button>
                          </td>
                          <td v-else>
                            <b-form-file :class="{'is-invalid': form.errors.has('file[dokumen.id]')}" id="upload-dokumen" v-model="form.file[dokumen.id]" accept=".jpg, .png, .jpeg, .pdf" placeholder="Pilih berkas" drop-placeholder="Drop file here..."
                            ></b-form-file>
                            <has-error :form="form" field="file[dokumen.id]"></has-error>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button v-if="all_komponen" type="button" class="btn btn-danger btn-lg mr-2" @click="kunciPendaftaran(sekolah_pilihan_id)">
              Kunci Pendaftaran <i class="fa fa-user-lock"></i>
            </button>
            <button class="btn btn-lg btn-primary float-right">
              SIMPAN PENDAFTARAN
            </button>
          </div>
        </form>
      </div>
    </template>
  </div>
</template>
<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';  
export default {
  components: {
    DatePicker
  },
  created() {
    //this.loadPostsData();
  },
  mounted() {
    this.$root.$on('bv::modal::hide', (bvEvent, modalId) => {
      this.loadPostsData()
    })
  },
  data() {
    return {
      pendaftar_id: null,
      form: new Form({
        user_id: user.user_id,
        siswa: '',
        bentuk_pendidikan_id: "",
        sekolah: { sekolah_id: "", nama: "== Pilih Sekolah Pilihan ==" },
        jalur: '',
        file: [],
        tanggal: [],
        dokumen_id: [],
      }),
      data_jenjang: [
        { nama: "SD", bentuk_pendidikan_id: 5 },
        { nama: "SMP", bentuk_pendidikan_id: 6 },
      ],
      data_sekolah: [],
      data_jalur: [],
      data_siswa: [],
      sudah_daftar: 0,
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
      errors: null,
    };
  },
  methods: {
    getJalur(val){
      axios
        .post(`/api/pendaftaran/all-jalur`, {
          bentuk_pendidikan_id: val.bentuk_pendidikan_id,
        })
        .then((response) => {
          let getData = response.data.data;
          this.data_jalur = getData;
        });
    },
    getSiswa(){
      let sekolah_id = this.form.sekolah
      let jalur_id = this.form.jalur
      axios
        .get(`/api/pendaftaran/siswa`, {
          params: {
            jalur_id: jalur_id.id,
            sekolah_id: sekolah_id.sekolah_id,
            user_id: user.user_id,
          },
        })
        .then((response) => {
          let getData = response.data.data;
          this.data_siswa = getData
        });
    },
    loadPostsData() {
      axios
        .get(`/api/pendaftaran/sekolah`, {
          params: {
            user_id: user.user_id,
          },
        })
        .then((response) => {
          let getData = response.data.data;
          //this.data_jalur = getData
        });
    },
    getSekolah(val) {
      let bentuk_pendidikan_id = this.form.bentuk_pendidikan_id.bentuk_pendidikan_id;
      axios
        .post(`/api/pendaftaran/all-sekolah`, {
          bentuk_pendidikan_id: bentuk_pendidikan_id,
          jalur_id: val.id,
          user_id: user.user_id,
        })
        .then((response) => {
          let getData = response.data.data;
          this.data_sekolah = getData;
        });
    },
    getKomponen(pendaftar_id = null) {
      axios
        .post(`/api/pendaftaran/all-komponen`, {
          jalur_id: this.form.jalur_id,
          pendaftar_id: pendaftar_id,
        })
        .then((response) => {
          let getData = response.data.data;
          this.all_dokumen = getData;
          let tempDokumen = {}
          let tempTanggal = {}
          $.each(getData, function (key, value) {
            if(value.tanggal){
              tempTanggal[value.id] = null
            }
            tempDokumen[value.id] = value.id
          });
          this.form.tanggal = tempTanggal
          this.form.dokumen_id = tempDokumen
        });
    },
    insertData() {
      let formData = new FormData();
      let formulir = this.form
      $.each(this.form.dokumen_id, function (key, value) {
        if(value){
          formData.append('files[' + key + ']', formulir.file[key]);
        }
      });
      $.each(this.form.tanggal, function (key, value) {
        formData.append('tanggal[' + key + ']', formulir.tanggal[key]);
      });
      formData.append("sekolah_id", this.form.sekolah['sekolah_id']);
      formData.append("user_id", user.user_id);
      formData.append("jalur_id", this.form.jalur_id);
      axios.post( '/api/pendaftaran',
          formData,
          {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
          }
        ).then((response) => {
          Swal.fire('Berhasil', 'Pendaftaran berhasil disimpan', 'success').then(() => {
            this.loadPostsData();
          });
        })
        .catch((error) => {
          let getData = error.response.data;
          let message = [];
          $.each(getData.errors, function (key, value) {
            message.push(value);
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
  },
};
</script>
