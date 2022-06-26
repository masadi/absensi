<template>
  <div>
    <div class="row">
      <!-- BLOCK INI AKAN MENGHANDLE LOAD DATA PERPAGE, DENGAN DEFAULT ADALAH 10 DATA -->
      <div class="col-md-4 mb-2">
        <div class="form-inline">
          <!-- KETIKA SELECT BOXNYA DIGANTI, MAKA AKAN MENJALANKAN FUNGSI loadPerPage -->
          <select class="form-control" v-model="meta.per_page" @change="loadPerPage">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
          <label class="ml-2">Entri</label>
        </div>
      </div>

      <!-- BLOCK INI AKAN MENG-HANDLE PENCARIAN DATA -->
      <div class="col-md-4 offset-md-4">
        <div class="form-inline float-right">
          <label class="mr-2">Cari</label>
          <!-- KETIKA ADA INPUTAN PADA KOLOM PENCARIAN, MAKA AKAN MENJALANKAN FUNGSI SEARCH -->
          <input type="text" class="form-control" @input="search" />
        </div>
      </div>
    </div>
    <!-- BLOCK INI AKAN MENGHASILKAN LIST DATA DALAM BENTUK TABLE MENGGUNAKAN COMPONENT TABLE DARI BOOTSTRAP VUE -->

    <!-- :ITEMS ADALAH DATA YANG AKAN DITAMPILKAN -->
    <!-- :FIELDS AKAN MENJADI HEADER DARI TABLE, MAKA BERISI FIELD YANG SALING BERKORELASI DENGAN ITEMS -->
    <!-- :sort-by.sync & :sort-desc.sync AKAN MENGHANDLE FITUR SORTING -->
    <b-table :striped="true" :bordered="true" hover :items="items" :fields="fields" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" show-empty>
        <template v-slot:cell(sekolah_id)="row">
            {{(row.item.sekolah) ? row.item.sekolah.nama : '-'}}
        </template>
        <template v-slot:cell(actions)="row">
            <!--b-dropdown id="dropdown-dropleft" dropleft text="Aksi" variant="success">
                <b-dropdown-item href="javascript:" @click="editData(row)"><i class="fas fa-edit"></i> Edit</b-dropdown-item>
                <b-dropdown-item href="javascript:" @click="deleteData(row.item.user_id)"><i class="fas fa-trash"></i> Hapus</b-dropdown-item>
            </b-dropdown-->
            <b-button variant="danger" size="sm" @click="tukarAkses(row.item)">Tukar Akses</b-button>
            <button class="btn btn-success btn-sm" @click="editData(row.item)">
                <i class="fas fa-edit"></i> Edit
            </button>
            <button class="btn btn-danger btn-sm" @click="deleteData(row.item)">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </template>
    </b-table>

    <!-- BAGIAN INI AKAN MENAMPILKAN JUMLAH DATA YANG DI-LOAD -->
    <div class="row">
      <div class="col-md-6">
        <p>
          Menampilkan {{ meta.from }} sampai {{ meta.to }} dari {{ meta.total }} entri
        </p>
      </div>

      <!-- BLOCK INI AKAN MENJADI PAGINATION DARI DATA YANG DITAMPILKAN -->
      <div class="col-md-6">
        <!-- DAN KETIKA TERJADI PERGANTIAN PAGE, MAKA AKAN MENJALANKAN FUNGSI changePage -->
        <b-pagination
          v-model="meta.current_page"
          :total-rows="meta.total"
          :per-page="meta.per_page"
          align="right"
          @change="changePage"
          aria-controls="dw-datatable"
        ></b-pagination>
      </div>
    </div>
    <b-modal id="modal-xl" size="xl" v-model="showModal" title="Detil Pengguna">
      {{ modalText }}
      <template v-slot:modal-footer>
        <div class="w-100 float-right">
          <b-button variant="secondary" size="sm" @click="showModal = false">
            Tutup
          </b-button>
        </div>
      </template>
    </b-modal>
    <b-modal id="modal-edit-operator" size="lg" title="Edit Data Operator" ref="modal_edit_operator" hide-footer>
        <b-form @submit.stop.prevent="onSubmit">
            <b-form-group id="name" label="Nama Lengkap" label-for="name">
                <input type="hidden" name="id" v-model="form.id">
                <b-form-input id="name" name="name" v-model="form.name" v-validate="{ required: true, min: 3 }" :state="validateState('name')" aria-describedby="name-live-feedback" data-vv-as="Nama Lengkap"></b-form-input>
                <b-form-invalid-feedback id="name-live-feedback">{{ veeErrors.first('name') }}</b-form-invalid-feedback>
            </b-form-group>
            <b-form-group id="email" label="Email Aktif" label-for="email">
                <b-form-input id="email" name="email" v-model="form.email" v-validate="{ required: true, email: true, unique_2: true }" :state="validateState('email')" aria-describedby="email-live-feedback" data-vv-as="Email Aktif"></b-form-input>
                <b-form-invalid-feedback id="email-live-feedback">{{ veeErrors.first('email') }}</b-form-invalid-feedback>
            </b-form-group>
            <b-form-group id="password" label="Password" label-for="password">
                <b-form-input id="password" name="password" type="password" v-model="form.password" v-validate="{ required: false, min: 3 }" :state="validateState('password')" aria-describedby="password-live-feedback" data-vv-as="Password"></b-form-input>
                <b-form-invalid-feedback id="password-live-feedback">{{ veeErrors.first('password') }}</b-form-invalid-feedback>
            </b-form-group>
            <b-button type="submit" variant="primary">Update</b-button>
            <b-button class="ml-2" @click="resetForm()">Reset</b-button>
            </b-form>
    </b-modal>
  </div>
</template>

<script>
import _ from "lodash"; //IMPORT LODASH, DIMANA AKAN DIGUNAKAN UNTUK MEMBUAT DELAY KETIKA KOLOM PENCARIAN DIISI
import { Validator } from "vee-validate";
import indonesia from 'vee-validate/dist/locale/id';
export default {
    //PROPS INI ADALAH DATA YANG AKAN DIMINTA DARI PENGGUNA COMPONENT DATATABLE YANG KITA BUAT
    props: {
        //ITEMS STRUKTURNYA ADALAH ARRAY, KARENA BAGIAN INI BERISI DATA YANG AKAN DITAMPILKAN DAN SIFATNYA WAJIB DIKIRIMKAN KETIKA COMPONENT INI DIGUNAKAN
        items: {
        type: Array,
        required: true,
        },
        //FIELDS JUGA SAMA DENGAN ITEMS
        fields: {
        type: Array,
        required: true,
        },
        //ADAPUN META, TYPENYA ADALAH OBJECT YANG BERISI INFORMASI MENGENAL CURRENT PAGE, LOAD PERPAGE, TOTAL DATA, DAN LAIN SEBAGAINYA.
        meta: {
        required: true,
        },
        title: {
        type: String,
        default: "Delete Modal",
        },
        editUrl: {
        type: String,
        default: null,
        },
    },
    data() {
        return {
        editmode: false,
        form: new Form({
            id: null,
            name: null,
            email: null,
            password: null,

        }),
        //VARIABLE INI AKAN MENGHADLE SORTING DATA
        sortBy: null, //FIELD YANG AKAN DISORT AKAN OTOMATIS DISIMPAN DISINI
        sortDesc: false, //SEDANGKAN JENISNYA ASCENDING ATAU DESC AKAN DISIMPAN DISINI
        //TAMBAHKAN DUA VARIABLE INI UNTUK MENGHANDLE MODAL DAN DATA YANG AKAN DIHAPUS
        deleteModal: false,
        showModal: false,
        editModal: false,
        modalText: "",
        selected: null,
        };
    },
    computed: {
        nextLocale() {
            return this.locale === 'id' ? 'Indonesia' : 'English';
        }
    },
    created() {
        //axios.get('/api/users').then(({data}) => this.users = data);
        this.$validator.localize('id', {
            messages: indonesia.messages,
            attributes: {
                email: 'Emailku',
                name: 'Namaku',
                sekolah_id: 'Sekolahku',
                jenjang: 'Jenjangku',
            }
        });
        // start with english locale.
        this.$validator.localize('id');
    },
    watch: {
        //KETIKA VALUE DARI VARIABLE sortBy BERUBAH
        sortBy(val) {
        //MAKA KITA EMIT DENGAN NAMA SORT DAN DATANYA ADALAH OBJECT BERUPA VALUE DARI SORTBY DAN SORTDESC
        //EMIT BERARTI MENGIRIMKAN DATA KEPADA PARENT ATAU YANG MEMANGGIL COMPONENT INI
        //SEHINGGA DARI PARENT TERSEBUT, KITA BISA MENGGUNAKAN VALUE YANG DIKIRIMKAN
            this.$emit("sort", {
                sortBy: this.sortBy,
                sortDesc: this.sortDesc,
            });
        },
        //KETIKA VALUE DARI SORTDESC BERUBAH
        sortDesc(val) {
        //MAKA CARA YANG SAMA AKAN DIKERJAKAN
        this.$emit("sort", {
            sortBy: this.sortBy,
            sortDesc: this.sortDesc,
            });
        },
        $route () {
        // make sure we revert to english if the user navigated away.
            this.$validator.localize('en');
            console.log('mounted disini')
        },
    },
    mounted() {
        console.log(this.form.id);
    },
    mounted() {
        const isUnique = value =>
        new Promise(resolve => {
            setTimeout(() => {
                console.log(value);
                axios.post(`/api/users/cek-email`, {
                //KIRIMKAN PARAMETER BERUPA PAGE YANG SEDANG DILOAD, PENCARIAN, LOAD PERPAGE DAN SORTING.
                    email: value,
                    id: this.form.id,
                })
                .then((response) => {
                //JIKA RESPONSENYA DITERIMA
                    let getData = response.data.data;
                    if(getData){
                        return resolve({
                            valid: false,
                            data: {
                                message: `${value} sudah terdaftar di database.`
                            }
                        })
                    } else {
                        return resolve({
                            valid: true
                        }); 
                    }
                });
            }, 200);
        });
        Validator.extend("unique_2", {
        validate: isUnique,
            getMessage: (field, params, data) => data.message
        });
    },
    methods: {
        tukarAkses(item){
            console.log(item);
            let operator_id = item.user_id
            window.open('/tukar-akses/'+operator_id+'/'+this.user.user_id, '_self')
        },
        //JIKA SELECT BOX DIGANTI, MAKA FUNGSI INI AKAN DIJALANKAN
        loadPerPage(val) {
            //DAN KITA EMIT LAGI DENGAN NAMA per_page DAN VALUE SESUAI PER_PAGE YANG DIPILIH
            this.$emit("per_page", this.meta.per_page);
        },
        //KETIKA PAGINATION BERUBAH, MAKA FUNGSI INI AKAN DIJALANKAN
        changePage(val) {
            //KIRIM EMIT DENGAN NAMA PAGINATION DAN VALUENYA ADALAH HALAMAN YANG DIPILIH OLEH USER
            this.$emit("pagination", val);
        },
        //KETIKA KOTAK PENCARIAN DIISI, MAKA FUNGSI INI AKAN DIJALANKAN
        //KITA GUNAKAN DEBOUNCE UNTUK MEMBUAT DELAY, DIMANA FUNGSI INI AKAN DIJALANKAN
        //500 MIL SECOND SETELAH USER BERHENTI MENGETIK
        search: _.debounce(function (e) {
            //KIRIM EMIT DENGAN NAMA SEARCH DAN VALUE SESUAI YANG DIKETIKKAN OLEH USER
            this.$emit("search", e.target.value);
        }, 500),
        deleteData(item) {
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
                return fetch("/api/users/delete-user/" + item.user_id, {
                    method: "DELETE",
                })
                    .then(() => {
                    //this.form.delete('api/komponen/'+id).then(()=>{
                    Swal.fire("Berhasil!", "Data Pengguna berhasil dihapus", "success").then(
                        () => {
                        this.loadPerPage(10);
                        }
                    );
                    })
                    .catch((data) => {
                    Swal.fire("Failed!", data.message, "warning");
                    });
                }
            });
        },
        resetPassword(item) {
            console.log(item);
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Tindakan ini tidak dapat dikembalikan!",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Reset Password!",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.value) {
                return (
                    fetch("/api/reset-password", {
                    method: "POST",
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ user_id: item.user_id }),
                    })
                    /*.then((response)=>{
                                console.log(response);
                                return false
                            //this.form.delete('api/komponen/'+id).then(()=>{
                                */
                    .then((response) => response.json())
                    // Displaying results to console
                    .then((json) => {
                        Swal.fire({
                        title: json.title,
                        text: json.text,
                        icon: json.icon,
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Cetak",
                        cancelButtonText: "OK",
                        }).then((result) => {
                        if (result.isConfirmed) {
                            this.loadPerPage(10);
                            window.open("/cetak/" + item.user_id, "_blank");
                        } else {
                            this.loadPerPage(10);
                        }
                        });
                    })
                    .catch((data) => {
                        Swal.fire("Failed!", data.message, "warning");
                    })
                );
                }
            });
        },
        editData(row) {
            this.$refs['modal_edit_operator'].show()
            this.form.id = row.user_id;
            this.form.name = row.name;
            this.form.email = row.email;
        },
        /*updateData() {
            let id = this.form.id;
            this.form
            .put("/api/users/" + id)
            .then((response) => {
            $("#modalEdit").modal("hide");
            Toast.fire({
                icon: "success",
                title: response.message,
            });
            this.loadPerPage(10);
            })
            .catch((e) => {
            Toast.fire({
                icon: "error",
                title: "Some error occured! Please try again",
            });
            });
        },*/
        validateState(ref) {
            if (
                this.veeFields[ref] &&
                (this.veeFields[ref].dirty || this.veeFields[ref].validated)
            ) {
                return !this.veeErrors.has(ref);
            }
            return null;
        },
        resetForm() {
            this.form = {
                id: null,
                name: null,
                email: null,
                password: null,
            };
            this.$nextTick(() => {
                this.$validator.reset();
            });
        },
        onSubmit() {
            this.$validator.validateAll().then(result => {
                if (!result) {
                    return;
                }
                console.log(this.form);
                axios.put('/api/users/'+this.form.id,{
                    name: this.form.name,
                    email: this.form.email,
                    password: this.form.password,
                }).then((response) => {
                    console.log(response);
                    let data = response.data.status
                    this.$refs['modal_edit_operator'].hide()
                    Swal.fire(data.title, data.text, data.icon).then(() => {
                        this.resetForm()
                        this.loadPerPage(10)
                    });
                }).catch((data) => {
                    console.log(data);
                });
            });
        },
    },
};
</script>
