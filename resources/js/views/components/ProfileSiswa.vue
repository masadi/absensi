<template>
  <div>
    <div class="card-body">
      <div class="row">
        <div class="col-12">
          <div class="alert alert-danger" v-show="errors">
            <h5><i class="icon fas fa-ban"></i> Isian Tidak Valid!</h5>
            <ul>
              <li v-for="(error, key) in errors">
                {{ error }}
              </li>
            </ul>
          </div>
        </div>
        <div class="col-md-6">
          <label for="name" class="col-form-label">Nama Lengkap</label>
          <div class="form-group">
            <input
              v-model="form.user_id"
              type="hidden"
              name="user_id"
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
          <label for="email" class="col-form-label">Email</label>
          <div class="form-group">
            <input
              v-model="form.email"
              type="email"
              id="email"
              name="email"
              class="form-control"
              :class="{ 'is-invalid': form.errors.has('email') }"
            />
            <has-error :form="form" field="email"></has-error>
          </div>
          <template v-if="hasRole('siswa')">
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
            <label for="kebutuhan_khusus" class="col-form-label">Kebutuhan Khusus</label>
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
          </template>
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
              v-bind:min="'2007-07-01'"
              v-bind:max="'2016-07-01'"
              v-bind:data-vv-as="'Masukkan Tanggal Lahir Anda'"
              v-model="form.tanggal_lahir"
              v-bind:v-validate="{ required: true, date_format: 'YYYY-MM-DD' }"
              name="tanggal_lahir"
              id="tanggal_lahir"
            ></datepicker>
            <has-error :form="form" field="tanggal_lahir"></has-error>
          </div>
          <label for="current-password" class="col-form-label">Foto 3x4</label>
          <div class="form-group">
            <div class="custom-file">
              <label class="custom-file-label" for="image">Cari Berkas</label>
              <b-form-file
                v-model="upload_photo"
                :state="Boolean(upload_photo)"
                accept=".jpg, .png, .jpeg"
                placeholder="Cari berkas foto..."
                drop-placeholder="Letakkan berkas foto disini..."
              ></b-form-file>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <b-button squared variant="success" size="lg" v-on:click="updateProfile" :disabled="kunci">
        <b-spinner small v-show="show_spinner"></b-spinner>
        <span class="sr-only" v-show="show_spinner">Loading...</span>
        <span v-show="show_text">Perbaharui Data</span>
      </b-button>
    </div>
  </div>
</template>

<script>
import Datepicker from "./TouchDatePicker";
export default {
  props: {
    kunci: {
      type: Boolean,
      required: true
    },
  },
  components: {
    Datepicker,
  },
  data() {
    return {
      form: new Form({
        user_id: "",
        name: "",
        email: "",
        current_password: "",
        password: "",
        password_confirmation: "",
        wna: "",
        negara_id: "",
        provinsi_id: "",
        kabupaten_id: "",
        kecamatan_id: "",
        desa_id: "",
        alamat: "",
        rt: "",
        rw: "",
        tempat_lahir: "",
        tanggal_lahir: "",
        bujur: "",
        lintang: "",
        jenis_kelamin: "",
        nomor_hp: "",
        nama_ortu: "",
        photo: null,
        agama_id: "",
        kebutuhan_khusus: "",
        jenis_tinggal_id : null,
      }),
      data_wna: [
        { key: 0, nama: "Warga Negara Indonesia" },
        { key: 1, nama: "Warga Negara Asing" },
      ],
      jenis_kelamin: [
        { key: "L", nama: "Laki-laki" },
        { key: "P", nama: "Perempuan" },
      ],
      data_negara: [],
      data_provinsi: [],
      data_kabupaten: [],
      data_kecamatan: [],
      data_desa: [],
      data_agama: [],
      data_kebutuhan_khusus: [],
      jenis_tinggal: [],
      select_provinsi: true,
      select_kabupaten: true,
      select_kecamatan: true,
      select_desa: true,
      upload_photo: [],
      show_spinner: false,
      show_text: true,
      errors: null,
    };
  },
  created() {
    //MAKA AKAN MENJALANKAN FUNGSI BERIKUT
    this.loadPostsData();
  },
  methods: {
    getJenisTinggal(){
      axios.post(`/api/users/jenis-tinggal`).then((response) => {
        let getData = response.data.data;
        this.jenis_tinggal = getData;
        let formulir = this.form;
        $.each(getData, function (key, value) {
          if (user.data.jenis_tinggal_id === value.value) {
            formulir.jenis_tinggal_id = value;
          }
        });
      });
    },
    getKebutuhan() {
      axios.post(`/api/users/kebutuhan-khusus`).then((response) => {
        let getData = response.data.data;
        this.data_kebutuhan_khusus = getData;
        this.form.kebutuhan_khusus = user.data.kebutuhan_khusus
      });
    },
    getAgama() {
      axios.post(`/api/users/agama`).then((response) => {
        let getData = response.data.data;
        this.data_agama = getData;
        let formulir = this.form;
        $.each(getData, function (key, value) {
          if (user.data.agama_id && user.data.agama_id === value.value) {
            formulir.agama_id = value;
          }
        });
      });
    },
    getNegara(val) {
      let negara = null;
      if (val === null) {
        return false;
      } else {
        negara = val.key;
      }
      axios
        .post(`/api/users/negara`, {
          negara: negara,
        })
        .then((response) => {
          let getData = response.data.data;
          this.data_negara = getData;
          let formulir = this.form;
          $.each(getData, function (key, value) {
            if (user.data.negara_id && user.data.negara_id === value.value) {
              formulir.negara_id = { value: value.value, nama: value.nama };
            }
          });
          if(!this.form.negara_id){
            this.form.negara_id = {value: 'ID', nama: 'Indonesia'}
          }
        });
    },
    getProvinsi(val) {
      let negara_id;
      if (!val.value) {
        negara_id = 'ID';
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
                user.data.provinsi_id === value.value.trim()
              ) {
                formulir.provinsi_id = value;
              }
            });
          }
          if (!this.form.provinsi_id) {
            if(user.data.provinsi){
              this.form.provinsi_id = user.data.provinsi;
            } else {
              this.form.provinsi_id = {value: '050000  ', nama: 'Prov. Jawa Timur'}
            }
          }
        });
    },
    getKabupaten(val) {
      let provinsi_id;
      if (!val.value) {
        provinsi_id = '050000  ';
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
          } else {
            this.select_kabupaten = false;
          }
          if (user.data.kabupaten_id) {
            let formulir = this.form;
            $.each(getData, function (key, value) {
              if (
                user.data.kabupaten_id &&
                user.data.kabupaten_id === value.value.trim()
              ) {
                formulir.kabupaten_id = value;
              }
            });
          }
          if (!this.form.kabupaten_id) {
            if(user.data.kabupaten){
              this.form.kabupaten_id = user.data.kabupaten;
            } else {
              this.form.kabupaten_id = {value: '052700  ', nama: 'Kab. Sampang'}
            }
          }
        });
    },
    getKecamatan(val) {
      let kabupaten_id;
      if (!val.value) {
        kabupaten_id = '052700  ';
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
          } else {
            this.select_kecamatan = false;
          }
          if (user.data.kecamatan_id) {
            let formulir = this.form;
            $.each(getData, function (key, value) {
              if (
                user.data.kecamatan_id &&
                user.data.kecamatan_id === value.value.trim()
              ) {
                formulir.kecamatan_id = value;
              }
            });
          }
          if (!this.form.kecamatan_id) {
            if(user.data.kecamatan){
              this.form.kecamatan_id = user.data.kecamatan;
            } else {
              this.form.kecamatan_id = {value: '052703  ', nama: 'Kec. Sampang'}
            }
          }
        });
    },
    getDesa(val) {
      let kecamatan_id;
      if (!val.value) {
        kecamatan_id = '052703  ';
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
          } else {
            this.select_desa = false;
          }
          if (user.data.desa_id) {
            let formulir = this.form;
            $.each(getData, function (key, value) {
              if (user.data.desa_id && user.data.desa_id === value.value.trim()) {
                formulir.desa_id = value;
              }
            });
          }
          if (!this.form.desa_id) {
            if(user.data.desa){
              this.form.desa_id = user.data.desa;
            } else {
              this.form.desa_id = {value: '052703AA', nama: 'Pulau Mandangin'}
            }
          }
        });
    },
    scrollToTop() {
      window.scrollTo(0, 0);
    },
    validasi(field, text) {
      var errors = [];
      if (!field) {
        errors.push(text);
        this.errors = errors;
        this.show_spinner = false;
        this.show_text = true;
        this.scrollToTop();
        return false;
      }
    },
    updateProfile() {
      this.show_spinner = true;
      this.show_text = false;
      this.errors = null;
      let formData = new FormData();
      let setKelamin = this.form.jenis_kelamin ? this.form.jenis_kelamin.key : "";
      let setAgama = this.form.agama_id ? this.form.agama_id.value : "";
      let setWna = this.form.wna ? this.form.wna.key : "";
      let setNegara;
      let setProvinsi;
      let setKabupaten;
      let setKecamatanID;
      let setDesaID;
      let setJenisTinggal;
      if (this.hasRole("siswa")) {
        this.validasi(this.form.alamat, "Alamat tidak boleh kosong");
        this.validasi(this.form.tempat_lahir, "Tempat Lahir tidak boleh kosong");
        this.validasi(this.form.tanggal_lahir, "Tanggal Lahir tidak boleh kosong");
        if (typeof this.form.negara_id === "object") {
          setNegara = this.form.negara_id ? this.form.negara_id.value : "";
          this.validasi(setNegara, "Negara tidak boleh kosong");
        } else {
          setNegara = this.form.negara_id;
        }
        if (typeof this.form.provinsi_id === "object") {
          setProvinsi = this.form.provinsi_id ? this.form.provinsi_id.value : "";
          this.validasi(setProvinsi, "Provinsi tidak boleh kosong");
        } else {
          setProvinsi = this.form.provinsi_id;
        }
        if (typeof this.form.kabupaten_id === "object") {
          setKabupaten = this.form.kabupaten_id
            ? this.form.kabupaten_id.value
            : "";
          this.validasi(setKabupaten, "Kabupaten tidak boleh kosong");
        } else {
          setKabupaten = this.form.kabupaten_id;
        }
        if (typeof this.form.kecamatan_id === "object") {
          setKecamatanID = this.form.kecamatan_id
            ? this.form.kecamatan_id.value
            : "";
          this.validasi(setKecamatanID, "Kecamatan tidak boleh kosong");
        } else {
          setKecamatanID = this.form.kecamatan_id;
        }
        if (typeof this.form.desa_id === "object") {
          setDesaID = this.form.desa_id ? this.form.desa_id.value : "";
          this.validasi(setDesaID, "Desa/Kelurahan tidak boleh kosong");
        } else {
          setDesaID = this.form.desa_id;
        }
        if (typeof this.form.jenis_tinggal_id === "object") {
          setJenisTinggal = this.form.jenis_tinggal_id ? this.form.jenis_tinggal_id.value : "";
          this.validasi(setJenisTinggal, "Tempat Tinggal tidak boleh kosong");
        } else {
          setJenisTinggal = this.form.jenis_tinggal_id;
        }
        this.validasi(setKelamin, "Jenis Kelamin tidak boleh kosong");
        this.validasi(setAgama, "Agama tidak boleh kosong");
        this.validasi(this.form.nomor_hp, "Nomor HP tidak boleh kosong");
        this.validasi(this.form.nama_ortu, "Nama Orang Tua/Wali tidak boleh kosong");
      }
      formData.append("image", this.upload_photo);
      formData.append("user_id", this.form.user_id ? this.form.user_id : "");
      formData.append("name", this.form.name ? this.form.name : "-");
      formData.append("email", this.form.email ? this.form.email : "");
      formData.append("wna", setWna);
      formData.append("negara_id", setNegara);
      formData.append("provinsi_id", setProvinsi);
      formData.append("kabupaten_id", setKabupaten);
      formData.append("kecamatan_id", setKecamatanID);
      formData.append("desa_id", setDesaID);
      formData.append("alamat", this.form.alamat ? this.form.alamat : "");
      formData.append("rt", this.form.rt ? this.form.rt : "");
      formData.append("rw", this.form.rw ? this.form.rw : "");
      formData.append("nama_ortu", this.form.nama_ortu ? this.form.nama_ortu : "");
      formData.append("tempat_lahir", this.form.tempat_lahir ? this.form.tempat_lahir : "");
      formData.append("tanggal_lahir", this.form.tanggal_lahir ? this.form.tanggal_lahir : "");
      formData.append("jenis_kelamin", setKelamin);
      formData.append("agama_id", setAgama);
      formData.append("jenis_tinggal_id", setJenisTinggal);
      formData.append("nomor_hp", this.form.nomor_hp ? this.form.nomor_hp : "");
      formData.append("kebutuhan_khusus", JSON.stringify(this.form.kebutuhan_khusus));
      axios
        .post("/api/update-profile", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          Toast.fire({
            icon: "success",
            title: response.data.message,
          });
          this.loadPostsData();
        })
        .catch((error) => {
          var errors = [];
          $.each(error.response.data.errors, function (key, value) {
            errors.push(value[0]);
          });
          this.errors = errors;
          this.show_spinner = false;
          this.show_text = true;
          this.scrollToTop();
        });
    },
    loadPostsData() {
      axios
        .post(`/api/profile`, {
          //KIRIMKAN PARAMETER BERUPA PAGE YANG SEDANG DILOAD, PENCARIAN, LOAD PERPAGE DAN SORTING.
          user_id: user.user_id,
        })
        .then((response) => {
          //JIKA RESPONSENYA DITERIMA
          let getData = response.data.data;
          //this.geolocate(getData)
          this.getNegara({ key: getData.wna });
          this.getProvinsi({ value: getData.negara_id });
          this.getKabupaten({ value: getData.provinsi_id });
          this.getKecamatan({ value: getData.kabupaten_id });
          this.getDesa({ value: getData.kecamatan_id });
          this.getAgama();
          this.form.user_id = getData.user_id;
          this.form.name = getData.name;
          this.form.email = getData.email;
          this.form.current_password = "";
          this.form.password = "";
          this.form.password_confirmation = "";
          let nama_wna = getData.wna === 0 ? "Warga Negara Indonesia" : getData.wna === 1 ? "Warga Negara Asing" : "";
          this.form.wna = getData.wna === 0 || getData.wna ? { key: getData.wna, nama: nama_wna } : { key: 0, nama: 'Warga Negara Indonesia' };
          //this.form.provinsi_id = (getData.provinsi_id) ? {kode_wilayah: getData.provinsi_id, nama: getData.provinsi_id} : null
          //this.form.kabupaten_id = (getData.kabupaten_id) ? {kode_wilayah: getData.kabupaten_id, nama: getData.kabupaten_id} : null
          //this.form.kecamatan_id = (getData.kecamatan_id) ? {kode_wilayah: getData.kecamatan_id, nama: getData.desa.parent.nama} : null
          this.form.alamat = getData.alamat;
          this.form.rt = getData.rt;
          this.form.rw = getData.rw;
          //this.form.desa_id = (getData.desa_id) ? {kode_wilayah: getData.desa_id, nama: getData.desa.nama} : null
          this.form.jenis_kelamin = getData.jenis_kelamin ? { key: getData.jenis_kelamin, nama: getData.jenis_kelamin == "L" ? "Laki-laki" : "Perempuan",} : null;
          this.form.nomor_hp = getData.nomor_hp;
          this.form.tempat_lahir = getData.tempat_lahir;
          this.form.nama_ortu = getData.nama_ortu;
          this.form.tanggal_lahir = getData.tanggal_lahir;
          this.upload_photo = [];
          this.photo = getData.photo
            ? "/images/245/" + getData.photo
            : "/vendor/img/avatar3.png";
          this.show_spinner = false;
          this.show_text = true;
          this.getKebutuhan();
          this.getJenisTinggal();
          /*if(getData.bujur){
                        this.markers[0].position.lat = Number(getData.bujur).toFixed(6)
                        this.markers[0].position.lng = Number(getData.lintang).toFixed(6)
                        this.center = { lat: Number(getData.bujur).toFixed(6), lng: Number(getData.lintang).toFixed(6) };
                    }*/
        });
    },
  },
};
</script>
