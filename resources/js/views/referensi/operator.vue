<template>
  <div>
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div>Data Operator Sekolah</div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="main-card mb-3 card">
            <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-th mr-1"></i>
                Data Operator Sekolah
            </h3>
                <div class="btn-actions-pane-right">
                    <b-button size="sm" block squared variant="success" v-b-modal.modal-operator>Tambah Data Operator</b-button>
                </div>
            </div>
            <div class="card-body">
                <app-datatable :items="items" :fields="fields" :meta="meta" :title="'Hapus Operator Sekolah'" @per_page="handlePerPage" @pagination="handlePagination" @search="handleSearch" @sort="handleSort" />
            </div>
        </div>
    </section>
    <b-modal id="modal-operator" size="lg" title="Tambah Data Operator" ref="modal_operator" hide-footer>
        <b-form @submit.stop.prevent="onSubmit">
            <b-form-group id="jenjang" label="Jenjang Sekolah" label-for="jenjang">
                <b-form-select id="jenjang" name="jenjang" v-model="form.jenjang" v-validate="{ required: true }" :options="list_jenjang" :state="validateState('jenjang')" aria-describedby="jenjang-live-feedback" data-vv-as="Jenjang Sekolah" @change="getSekolah"></b-form-select>
                <b-form-invalid-feedback id="jenjang-live-feedback">{{ veeErrors.first('jenjang') }}</b-form-invalid-feedback>
            </b-form-group>
            <b-form-group id="sekolah_id" label="Nama Sekolah" label-for="sekolah_id">
                <b-form-select id="sekolah_id" name="sekolah_id" v-model="form.sekolah_id" v-validate="{ required: true }" :options="list_sekolah" :state="validateState('sekolah_id')" aria-describedby="sekolah_id-live-feedback" data-vv-as="Nama Sekolah"></b-form-select>
                <b-form-invalid-feedback id="sekolah_id-live-feedback">{{ veeErrors.first('sekolah_id') }}</b-form-invalid-feedback>
            </b-form-group>
            <b-form-group id="name" label="Nama Lengkap" label-for="name">
                <b-form-input id="name" name="name" v-model="form.name" v-validate="{ required: true, min: 3 }" :state="validateState('name')" aria-describedby="name-live-feedback" data-vv-as="Nama Lengkap"></b-form-input>
                <b-form-invalid-feedback id="name-live-feedback">{{ veeErrors.first('name') }}</b-form-invalid-feedback>
            </b-form-group>
            <b-form-group id="email" label="Email Aktif" label-for="email">
                <b-form-input id="email" name="email" v-model="form.email" v-validate="{ required: true, email: true, unique: true }" :state="validateState('email')" aria-describedby="email-live-feedback" data-vv-as="Email Aktif"></b-form-input>
                <b-form-invalid-feedback id="email-live-feedback">{{ veeErrors.first('email') }}</b-form-invalid-feedback>
            </b-form-group>
            <b-form-group id="password" label="Password" label-for="password">
                <b-form-input id="password" name="password" type="password" v-model="form.password" v-validate="{ required: true, min: 3 }" :state="validateState('password')" aria-describedby="password-live-feedback" data-vv-as="Password"></b-form-input>
                <b-form-invalid-feedback id="password-live-feedback">{{ veeErrors.first('password') }}</b-form-invalid-feedback>
            </b-form-group>
            <b-button type="submit" variant="primary">Simpan</b-button>
            <b-button class="ml-2" @click="resetForm()">Reset</b-button>
            </b-form>
    </b-modal>
  </div>
</template>

<script>
import Datatable from "./../components/Operator.vue"; //IMPORT COMPONENT DATATABLENYA
import { Validator } from "vee-validate";
import indonesia from 'vee-validate/dist/locale/id';
export default {
    data() {
        return {
            fields: [
                { key: "name", label: "Nama Lengkap", thClass: "text-center", sortable: true },
                { key: "email", label: "Email", thClass: "text-center", sortable: true },
                { key: "sekolah_id", label: "Sekolah", thClass: "text-center", sortable: true },
                //{key: 'bentuk_pendidikan_id', label: 'Jenjang Sekolah', class: 'text-center', sortable: true},
                { key: "actions", label: "Aksi", class: "text-center", sortable: false }, //TAMBAHKAN CODE INI
            ],
            items: [], //DEFAULT VALUE DARI ITEMS ADALAH KOSONG
            meta: [], //JUGA BERLAKU UNTUK META
            current_page: 1, //DEFAULT PAGE YANG AKTIF ADA PAGE 1
            per_page: 10, //DEFAULT LOAD PERPAGE ADALAH 10
            search: "",
            sortBy: "bentuk_pendidikan_id", //DEFAULT SORTNYA ADALAH CREATED_AT
            sortByDesc: true, //ASCEDING
            //sekolah_id: user.sekolah_id,
            list_jenjang: [
                {value: null, text: '== Pilih Jenjang ==' }, 
                {value: 5, text: 'Jenjang SD'}, 
                {value: 6, text: 'Jenjang SMP'}
            ],
            list_sekolah: [{value: null, text: '== Pilih Sekolah ==' }],
            form: new Form({
                id: null,
                name: null,
                jenjang: null,
                sekolah_id : null,
                email: null,
                password: null,
            }),
            locale: 'id',
        };
    },
    computed: {
        nextLocale() {
            return this.locale === 'id' ? 'Indonesia' : 'English';
        }
    },
    created() {
        //axios.get('/api/users').then(({data}) => this.users = data);
        this.loadPostsData();
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
        $route () {
        // make sure we revert to english if the user navigated away.
            this.$validator.localize('en');
        }
    },
    components: {
        "app-datatable": Datatable, //REGISTER COMPONENT DATATABLE
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
        Validator.extend("unique", {
        validate: isUnique,
            getMessage: (field, params, data) => data.message
        });
    },
    methods: {
        getSekolah(val){
            this.form.sekolah_id = null
            this.list_sekolah = [{value: null, text: '== Pilih Sekolah ==' }]
            axios.get(`/api/sekolah/`+val)
            .then((response) => {
            //JIKA RESPONSENYA DITERIMA
                let getData = response.data.data;
                let vm = this
                $.each(getData, function(index, value){
                    vm.list_sekolah.push(value)
                })
                console.log(this.list_sekolah);
            })
        },
        changeLocale() {
            this.locale = this.$validator.locale === 'id' ? 'en' : 'id';
            this.$validator.localize(this.locale);
        },
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
                jenjang: null,
                sekolah_id : null,
                email: null,
                password: null
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
                this.form.post('/api/users/simpan-operator').then((response) => {
                    let getData = response.data;
                    let data = response.status
                    this.$refs['modal_operator'].hide()
                    Swal.fire(data.title, data.message, data.status).then(() => {
                        this.resetForm()
                        this.loadPostsData()
                    });
                }).catch((data) => {
                    console.log(data);
                });
            });
        },
        loadPostsData() {
            let current_page = this.search == "" ? this.current_page : 1;
            //LAKUKAN REQUEST KE API UNTUK MENGAMBIL DATA POSTINGAN
            axios.get(`/api/users/list-operator`, {
            //KIRIMKAN PARAMETER BERUPA PAGE YANG SEDANG DILOAD, PENCARIAN, LOAD PERPAGE DAN SORTING.
                params: {
                    bentuk_pendidikan_id: user.data.bentuk_pendidikan_id,
                    page: current_page,
                    per_page: this.per_page,
                    q: this.search,
                    sortby: this.sortBy,
                    sortbydesc: this.sortByDesc ? "DESC" : "ASC",
                },
            })
            .then((response) => {
            //JIKA RESPONSENYA DITERIMA
                let getData = response.data.data;
                this.items = getData.data; //MAKA ASSIGN DATA POSTINGAN KE DALAM VARIABLE ITEMS
                //DAN ASSIGN INFORMASI LAINNYA KE DALAM VARIABLE META
                this.meta = {
                    total: getData.total,
                    current_page: getData.current_page,
                    per_page: getData.per_page,
                    from: getData.from,
                    to: getData.to,
                };
            });
        },
        //JIKA ADA EMIT TERKAIT LOAD PERPAGE, MAKA FUNGSI INI AKAN DIJALANKAN
        handlePerPage(val) {
            this.per_page = val; //SET PER_PAGE DENGAN VALUE YANG DIKIRIM DARI EMIT
            this.loadPostsData(); //DAN REQUEST DATA BARU KE SERVER
        },
        //JIKA ADA EMIT PAGINATION YANG DIKIRIM, MAKA FUNGSI INI AKAN DIEKSEKUSI
        handlePagination(val) {
            this.current_page = val; //SET CURRENT PAGE YANG AKTIF
            this.loadPostsData();
        },
        //JIKA ADA DATA PENCARIAN
        handleSearch(val) {
            this.search = val; //SET VALUE PENCARIAN KE VARIABLE SEARCH
            this.loadPostsData(); //REQUEST DATA BARU
        },
        //JIKA ADA EMIT SORT
        handleSort(val) {
            if (val.sortBy) {
                this.sortBy = val.sortBy;
                this.sortByDesc = val.sortDesc;

                this.loadPostsData(); //DAN LOAD DATA BARU BERDASARKAN SORT
            }
        },
    },
};
</script>
