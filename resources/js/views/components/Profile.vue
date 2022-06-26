<template>
  <div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-8">
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
        </div>
        <div class="col-md-4 text-center">
                                    <label for="current-password" class="col-form-label">Foto Profil</label>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <img :src="photo">
                                                <div class="custom-file">
                                                    <label class="custom-file-label" for="image">Cari Berkas</label>
                                                    <!--input type="file" class="custom-file-input" id="image" name="image"-->
                                                    <!--input type="file" name="image" id="image" @change="fileUpload($event.target)"
                                                            class="form-control" :class="{ 'is-invalid': form.errors.has('image') }">
                                                        <has-error :form="form" field="image"></has-error-->
                                                    <b-form-file v-model="upload_photo" :state="Boolean(upload_photo)" accept=".jpg, .png, .jpeg" placeholder="Cari berkas foto..." drop-placeholder="Letakkan berkas foto disini..."></b-form-file>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
      </div>
    </div>
    <div class="card-footer">
      <b-button squared variant="success" size="lg" v-on:click="updateProfile">
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
  components: {
    //DatePicker,
    Datepicker,
  },
  data() {
    return {
      form: new Form({
                user_id: '',
                name: '',
                email: '',
                bujur: '',
                lintang: '',
            }),
      errors: null,
      photo: '',
      upload_photo: [],
      show_spinner: false,
      show_text: true,
    }
  },
  created() {
        //MAKA AKAN MENJALANKAN FUNGSI BERIKUT
    this.loadPostsData();
  },
  methods: {
    loadPostsData() {
        axios
            .post(`/api/profile`, {
                user_id: user.user_id,
            })
            .then((response) => {
                let getData = response.data.data;
                this.form.bujur = Number(bujur);
                this.form.lintang = Number(lintang);
                this.form.email = getData.email
                this.form.name = getData.name
                this.photo = getData.photo ? "/images/245/" + getData.photo : "/vendor/img/avatar3.png";
            })
        },
    updateProfile() {
      this.show_spinner = true;
      this.show_text = false;
      this.errors = null;
      let formData = new FormData();
      formData.append("image", this.upload_photo);
      formData.append("user_id", user.user_id);
      formData.append("name", this.form.name ? this.form.name : "-");
      formData.append("email", this.form.email ? this.form.email : "");
      axios
        .post("/api/update-profile", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          console.log(response);
          Toast.fire({
            icon: "success",
            title: response.data.message,
          });
          this.loadPostsData();
        })
        .catch((error) => {
          console.log(error.response.data);
          var errors = [];
          $.each(error.response.data.errors, function (key, value) {
            errors.push(value[0]);
          });
          console.log(errors);
          this.errors = errors;
          this.show_spinner = false;
          this.show_text = true;
          this.scrollToTop();
        });
    },
    getKebutuhan(){
            axios.post(`/api/users/kebutuhan-khusus`).then((response) => {
                let getData = response.data.data
                this.data_kebutuhan_khusus = getData
                /*let formulir = this.form
                $.each(getData, function (key, value) {
                    if(user.data.agama_id && user.data.agama_id === value.id){
                        formulir.agama_id = value
                    }
                })*/
            })
        },
        getAgama(){
            axios.post(`/api/users/agama`).then((response) => {
                let getData = response.data.data
                this.data_agama = getData
                let formulir = this.form
                console.log(user.data.agama_id);
                $.each(getData, function (key, value) {
                    if(user.data.agama_id && user.data.agama_id === value.id){
                        formulir.agama_id = value
                    }
                })
            })
        },
        getNegara(val){
            let negara = null
            if(val === null){
                return false
            } else {
                negara = val.key
            }
            console.log(negara);
            axios.post(`/api/users/negara`, {
                negara: negara
            }).then((response) => {
                let getData = response.data.data
                this.data_negara = getData
                let formulir = this.form
                $.each(getData, function (key, value) {
                    if(user.data.negara_id && user.data.negara_id === value.negara_id){
                        formulir.negara_id = {negara_id: value.negara_id, nama: value.nama}
                    }
                })
            })
        },
        getProvinsi(val){
            let negara_id
            if(!val){
                return false
            } else {
                negara_id = val.negara_id
            }
            axios.post(`/api/users/provinsi`, {
                negara_id: negara_id,
            }).then((response) => {
                let getData = response.data.data
                if(getData.length){
                    this.select_provinsi = true
                    this.data_provinsi = getData
                } else {
                    this.form.provinsi_id = ''
                    this.form.kabupaten_id = ''
                    this.form.kecamatan_id = ''
                    this.form.desa_id = ''
                    this.select_provinsi = false
                    this.select_kabupaten = false
                    this.select_kecamatan = false
                    this.select_desa = false
                }
                if(user.data.provinsi_id){
                    let formulir = this.form
                    $.each(getData, function (key, value) {
                        if(user.data.provinsi_id && user.data.provinsi_id === value.kode_wilayah.trim()){
                            formulir.provinsi_id = value
                        }
                    })
                    if(!this.form.provinsi_id){
                        this.select_provinsi = false
                        this.form.provinsi_id = user.data.provinsi
                    }
                }
            })
        },
        getKabupaten(val){
            let provinsi_id
            if(!val){
                return false
            } else {
                provinsi_id = val.kode_wilayah
            }
            axios.post(`/api/users/kabupaten`, {
                provinsi_id: provinsi_id,
            }).then((response) => {
                let getData = response.data.data
                this.data_kabupaten = getData
                if(getData.length){
                    this.select_kabupaten = true
                }
                if(user.data.kabupaten_id){
                    let formulir = this.form
                    $.each(getData, function (key, value) {
                        if(user.data.kabupaten_id && user.data.kabupaten_id === value.kode_wilayah.trim()){
                            formulir.kabupaten_id = value
                        }
                    })
                    if(!this.form.kabupaten_id){
                        this.select_kabupaten = false
                        this.form.kabupaten_id = user.data.kabupaten
                    }
                }
            })
        },
        getKecamatan(val){
            let kabupaten_id
            if(!val){
                return false
            } else {
                kabupaten_id = val.kode_wilayah
            }
            axios.post(`/api/users/kecamatan`, {
                kabupaten_id: kabupaten_id,
            }).then((response) => {
                let getData = response.data.data
                this.data_kecamatan = getData
                if(getData.length){
                    this.select_kecamatan = true
                }
                if(user.data.kecamatan_id){
                    let formulir = this.form
                    $.each(getData, function (key, value) {
                        if(user.data.kecamatan_id && user.data.kecamatan_id === value.kode_wilayah.trim()){
                            formulir.kecamatan_id = value
                        }
                    })
                    if(!this.form.kecamatan_id){
                        this.select_kecamatan = false
                        this.form.kecamatan_id = user.data.kecamatan
                    }
                }
            })
        },
        getDesa(val){
            let kecamatan_id
            if(!val){
                return false
            } else {
                kecamatan_id = val.kode_wilayah
            }
            axios.post(`/api/users/desa`, {
                kecamatan_id: kecamatan_id,
            }).then((response) => {
                let getData = response.data.data
                this.data_desa = getData
                if(getData.length){
                    this.select_desa = true
                }
                if(user.data.desa_id){
                    let formulir = this.form
                    $.each(getData, function (key, value) {
                        if(user.data.desa_id && user.data.desa_id === value.kode_wilayah.trim()){
                            formulir.desa_id = value
                        }
                    })
                    if(!this.form.desa_id){
                        this.select_desa = false
                        this.form.desa_id = user.data.desa
                    }
                }
            })
        },
        scrollToTop() {
            window.scrollTo(0,0);
        },
        validasi(field, text){
            var errors = [];
            if(!field){
                errors.push(text);
                this.errors = errors
                this.show_spinner = false
                this.show_text = true
                this.scrollToTop()
                return false
            }
        },
        
  },
};
</script>
