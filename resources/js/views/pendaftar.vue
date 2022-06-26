<template>
    <div>
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                <div>Data Pendaftar</div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="main-card mb-3 card">
                <div class="card-header">
                    Data Pendaftar
                    <!--div class="btn-actions-pane-right" v-if="hasRole('sekolah') || hasRole('admin') && user.data.bentuk_pendidikan_id">
                        <b-button size="sm" block squared variant="success" to="/pendaftar/tambah">Tambah Data Pendaftar</b-button>
                    </div-->
                </div>
                <div class="card-body">
                    <app-datatable :items="items" :fields="fields" :meta="meta" :title="'Hapus Pendaftar'" @per_page="handlePerPage" @pagination="handlePagination" @search="handleSearch" @sort="handleSort" @filter_jenjang="handleFilterJenjang" @filter_jalur="handleFilterJalur" @filter_status="handleFilterStatus" />
                </div>
            </div>
        </section>
        <b-modal id="modal-xl" size="md" v-model="tambahPendaftar" title="Tambah Pendaftar">
            <p>Silahkan tambah data pendaftar dibawah ini, dengan menggunakan template yang disediakan. Download template pendaftar <a :href="'/template-pendaftar-'+jenjang+'.xlsx'" target="_blank">disini</a></p>
            <label for="bentuk_pendidikan_id" class="col-form-label">Pilih Jenjang Pendidikan</label>
            <div class="form-group">
                <v-select label="nama" :options="data_jenjang" v-model="bentuk_pendidikan_id" id="bentuk_pendidikan_id" @input="getSekolah"/>
            </div>
            <label for="sekolah_id" class="col-form-label">Pilih Sekolah</label>
            <div class="form-group">
                <v-select label="nama" :options="data_sekolah" v-model="form_sekolah_id" id="sekolah_id"/>
            </div>
            <label for="file" class="col-form-label">Pilih File Excel</label>
            <div class="form-group">
                <b-form-file v-model="file" id="file" :state="Boolean(file)" placeholder="Choose a file or drop it here..." drop-placeholder="Drop file here..." @change="fileUpload($event.target)"></b-form-file>
            </div>
        </b-modal>
    </div>
</template>
<script>
import Datatable from './components/Pendaftar.vue' //IMPORT COMPONENT DATATABLENYA
import axios from 'axios' //IMPORT AXIOS
export default {
    //KETIKA COMPONENT INI DILOAD
    created() {
        this.$loading(true)
        //MAKA AKAN MENJALANKAN FUNGSI BERIKUT
        this.loadPostsData()
    },
    data() {
        return {
            jenjang: null,
            user: user,
            file: null,
            fields: [],
            items: [], //DEFAULT VALUE DARI ITEMS ADALAH KOSONG
            meta: [], //JUGA BERLAKU UNTUK META
            current_page: 1, //DEFAULT PAGE YANG AKTIF ADA PAGE 1
            per_page: 10, //DEFAULT LOAD PERPAGE ADALAH 10
            search: '',
            sortBy: 'created_at', //DEFAULT SORTNYA ADALAH CREATED_AT
            sortByDesc: true, //ASCEDING
            sekolah_id: user.sekolah_id,
            tambahPendaftar: false,
            data_jenjang: [
                { nama: "SD", bentuk_pendidikan_id: 5 },
                { nama: "SMP", bentuk_pendidikan_id: 6 },
            ],
            bentuk_pendidikan_id: null,
            data_sekolah: [],
            form_sekolah_id: '',
            meta_jenjang: 0,
            jalur: 0,
            status: 0,
        }
    },
    components: {
        'app-datatable': Datatable //REGISTER COMPONENT DATATABLE
    },
    mounted() {
        if(this.hasRole('admin')){
            this.fields =  
            [{
                    key: 'nama_pendaftar',
                    thClass: 'text-center',
                    label: 'Nama Pendaftar',
                    sortable: false
                },
                {
                    key: 'nik_pendaftar',
                    label: 'NIK',
                    class: 'text-center',
                    sortable: false
                },
                {
                    key: 'sekolah_id',
                    thClass: 'text-center',
                    label: 'Sekolah Tujuan',
                    sortable: true
                },
                {
                    key: 'jalur_id',
                    class: 'text-center',
                    label: 'Jalur Pendaftaran',
                    tdClass: 'text-center',
                    sortable: true
                },
                {
                    key: 'status_id',
                    label: 'Status Verifikasi',
                    tdClass: 'text-center',
                    class: 'text-center',
                    sortable: true
                },
                {
                    key: 'actions',
                    label: 'Aksi',
                    class: 'text-center',
                    sortable: false
                }, //TAMBAHKAN CODE INI
            ] 
        } else { 
            this.fields = [{
                    key: 'nama_pendaftar',
                    thClass: 'text-center',
                    label: 'Nama Pendaftar',
                    sortable: false
                },
                {
                    key: 'nik_pendaftar',
                    label: 'NIK',
                    class: 'text-center',
                    sortable: false
                },
                {
                    key: 'jalur_id',
                    class: 'text-center',
                    label: 'Jalur Pendaftaran',
                    tdClass: 'text-center',
                    sortable: true
                },
                {
                    key: 'tukar_akses',
                    label: 'Tukar Akses',
                    tdClass: 'text-center',
                    class: 'text-center',
                    sortable: false
                },
                {
                    key: 'status_id',
                    label: 'Status Verifikasi',
                    tdClass: 'text-center',
                    class: 'text-center',
                    sortable: true
                },
                {
                    key: 'actions',
                    label: 'Aksi',
                    class: 'text-center',
                    sortable: false
                }, //TAMBAHKAN CODE INI
            ]
        }
    },
    methods: {
        openAddModal(){
            this.tambahPendaftar = true
        },
        getSekolah(val) {
            if(val){
                axios.post(`/api/pendaftaran/all-sekolah`, {
                    bentuk_pendidikan_id: val.bentuk_pendidikan_id,
                    filter: val.filter,
                }).then((response) => {
                    let getData = response.data.data;
                    this.data_sekolah = getData;
                });
            }
        },
        fileUpload(event) {
            this.file = event.files[0]
            this.isLoading = true
            let formData = new FormData();
            let bentuk_pendidikan_id = (this.bentuk_pendidikan_id) ? this.bentuk_pendidikan_id.bentuk_pendidikan_id : ''
            let sekolah_id = (this.form_sekolah_id) ? this.form_sekolah_id.sekolah_id : ''
            formData.append('file', this.file);
            formData.append('user_id', user.user_id);
            formData.append('bentuk_pendidikan_id', bentuk_pendidikan_id);
            formData.append('sekolah_id', sekolah_id);
            axios.post('/api/pendaftar/upload', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                //FUNGSI INI YANG MEMILIKI PERAN UNTUK MENGUBAH SEBERAPA JAUH PROGRESS UPLOAD FILE BERJALAN
                onUploadProgress: function( progressEvent ) {
                    //DATA TERSEBUT AKAN DI ASSIGN KE VARIABLE progressBar
                    this.progressBar = parseInt(Math.round((progressEvent.loaded * 100) / progressEvent.total))
                }.bind(this)
            }).then((response) => {
                setTimeout(() => {
                    this.tambahPendaftar = false
                    Toast.fire({
                        icon: response.data.status,
                        title: response.data.message
                    });
                    this.loadPostsData()
                })
            }).catch((error) => {
                let getData = error.response.data;
                let message = [];
                $.each(getData.errors, function (key, value) {
                    message.push(value);
                });
                Swal.fire("Gagal!", message.join("<br />"), "warning");
            });
        },
        loadPostsData() {
            this.$loading(true)
            let current_page = this.search == '' ? this.current_page : 1
            //this.jenjang
            //LAKUKAN REQUEST KE API UNTUK MENGAMBIL DATA POSTINGAN
            axios.get(`/api/pendaftar`, {
                    //KIRIMKAN PARAMETER BERUPA PAGE YANG SEDANG DILOAD, PENCARIAN, LOAD PERPAGE DAN SORTING.
                    params: {
                        bentuk_pendidikan_id: user.data.bentuk_pendidikan_id,
                        sekolah_id: this.sekolah_id,
                        user_id: user.user_id,
                        page: current_page,
                        per_page: this.per_page,
                        q: this.search,
                        sortby: this.sortBy,
                        sortbydesc: this.sortByDesc ? 'DESC' : 'ASC',
                        jenjang: this.meta_jenjang,
                        jalur: this.jalur,
                        status: this.status,
                    }
                })
                .then((response) => {
                    this.$loading(false)
                    //JIKA RESPONSENYA DITERIMA
                    let getData = response.data.data
                    this.meta_jenjang = response.data.meta_jenjang;
                    this.jalur = response.data.jalur;
                    this.jenjang = response.data.jenjang
                    this.items = getData.data //MAKA ASSIGN DATA POSTINGAN KE DALAM VARIABLE ITEMS
                    //DAN ASSIGN INFORMASI LAINNYA KE DALAM VARIABLE META
                    this.meta = {
                        total: getData.total,
                        current_page: getData.current_page,
                        per_page: getData.per_page,
                        from: getData.from,
                        to: getData.to,
                        isBusy: false,
                        jenjang: this.meta_jenjang,
                        jalur: this.jalur,
                        status: this.status,
                        all_jalur: response.data.all_jalur,
                        all_status: response.data.all_status,
                    }
                })
        },
        //JIKA ADA EMIT TERKAIT LOAD PERPAGE, MAKA FUNGSI INI AKAN DIJALANKAN
        handlePerPage(val) {
            this.per_page = val //SET PER_PAGE DENGAN VALUE YANG DIKIRIM DARI EMIT
            this.loadPostsData() //DAN REQUEST DATA BARU KE SERVER
        },
        //JIKA ADA EMIT PAGINATION YANG DIKIRIM, MAKA FUNGSI INI AKAN DIEKSEKUSI
        handlePagination(val) {
            this.current_page = val //SET CURRENT PAGE YANG AKTIF
            this.loadPostsData()
        },
        //JIKA ADA DATA PENCARIAN
        handleSearch(val) {
            this.search = val //SET VALUE PENCARIAN KE VARIABLE SEARCH
            this.loadPostsData() //REQUEST DATA BARU
        },
        //JIKA ADA EMIT SORT
        handleSort(val) {
            if (val.sortBy) {
                this.sortBy = val.sortBy
                this.sortByDesc = val.sortDesc

                this.loadPostsData() //DAN LOAD DATA BARU BERDASARKAN SORT
            }
        },
        handleFilterJenjang(val){
            this.meta_jenjang = (val) ? val : ''
            this.loadPostsData()
        },
        handleFilterJalur(val){
            this.jalur = (val) ? val : ''
            this.loadPostsData()
        },
        handleFilterStatus(val){
            this.status = (val) ? val : ''
            this.loadPostsData()
        }
    },
}
</script>
