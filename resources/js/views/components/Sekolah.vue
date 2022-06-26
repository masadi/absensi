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
                <input type="text" class="form-control" @input="search">
            </div>
        </div>
    </div>
    <!-- BLOCK INI AKAN MENGHASILKAN LIST DATA DALAM BENTUK TABLE MENGGUNAKAN COMPONENT TABLE DARI BOOTSTRAP VUE -->

    <!-- :ITEMS ADALAH DATA YANG AKAN DITAMPILKAN -->
    <!-- :FIELDS AKAN MENJADI HEADER DARI TABLE, MAKA BERISI FIELD YANG SALING BERKORELASI DENGAN ITEMS -->
    <!-- :sort-by.sync & :sort-desc.sync AKAN MENGHANDLE FITUR SORTING -->
    <b-table striped hover :items="items" :fields="fields" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" show-empty>
        <template v-slot:table-busy>
            <div class="text-center text-danger my-2">
                <b-spinner class="align-middle"></b-spinner>
                <strong>Loading...</strong>
            </div>
        </template>
        <template v-slot:cell(actions)="row">
            <b-dropdown id="dropdown-dropleft" dropleft text="Aksi" variant="success" size="sm">
                <b-dropdown-item href="javascript:" @click="editData(row)"><i class="fas fa-edit"></i> Edit</b-dropdown-item>
                <b-dropdown-item href="javascript:" @click="openShowModal(row)"><i class="fas fa-eye"></i> Detil</b-dropdown-item>
            </b-dropdown>
        </template>
    </b-table>

    <!-- BAGIAN INI AKAN MENAMPILKAN JUMLAH DATA YANG DI-LOAD -->
    <div class="row">
        <div class="col-md-6">
            <p>Menampilkan {{ meta.from }} sampai {{ meta.to }} dari {{ meta.total }} entri</p>
        </div>

        <!-- BLOCK INI AKAN MENJADI PAGINATION DARI DATA YANG DITAMPILKAN -->
        <div class="col-md-6">
            <!-- DAN KETIKA TERJADI PERGANTIAN PAGE, MAKA AKAN MENJALANKAN FUNGSI changePage -->
            <b-pagination v-model="meta.current_page" :total-rows="meta.total" :per-page="meta.per_page" align="right" @change="changePage" aria-controls="dw-datatable"></b-pagination>
        </div>
    </div>
    <b-modal id="modal-xl" size="lg" v-model="showModal" title="Detil Sekolah">
        <table class="table">
            <tr>
                <td width="30%">Nama</td>
                <td width="70%">: {{modalText.nama}}</td>
            </tr>
            <tr>
                <td>NPSN</td>
                <td>: {{modalText.npsn}}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: {{modalText.alamat_jalan}}</td>
            </tr>
            <tr>
                <td>Desa/Kelurahan</td>
                <td>: {{modalText.desa_kelurahan}}</td>
            </tr>
            <tr>
                <td>Kecamatan</td>
                <td>: {{modalText.kecamatan}}</td>
            </tr>
            <tr>
                <td>Kabupaten/Kota</td>
                <td>: {{modalText.kabupaten}}</td>
            </tr>
            <tr>
                <td>Provinsi</td>
                <td>: {{modalText.provinsi}}</td>
            </tr>
            <tr>
                <td>Kodepos</td>
                <td>: {{modalText.kode_pos}}</td>
            </tr>
            <tr>
                <td>Telepon</td>
                <td>: {{modalText.no_telp}}</td>
            </tr>
            <tr>
                <td>Fax</td>
                <td>: {{modalText.no_fax}}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>: {{modalText.email}}</td>
            </tr>
            <tr>
                <td>Website</td>
                <td>: {{modalText.website}}</td>
            </tr>
            <tr>
                <td>Status Sekolah</td>
                <td>: {{(modalText.status_sekolah == 1) ? 'Negeri' : 'Swasta'}}</td>
            </tr>
            <tr>
                <td>Nama Kepala Sekolah</td>
                <td>: {{modalText.nama_kepsek}}</td>
            </tr>
            <tr>
                <td>NIP Kepala Sekolah</td>
                <td>: {{modalText.nip_kepsek}}</td>
            </tr>
            <tr>
                <td>Jumlah Rombel</td>
                <td>: {{modalText.jml_rombel}}</td>
            </tr>
        </table>
        <template v-slot:modal-footer>
            <div class="w-100 float-right">
                <b-button variant="secondary" size="sm" @click="showModal=false">
                    Tutup
                </b-button>
            </div>
        </template>
    </b-modal>
    <b-modal id="modal-xl" size="lg" v-model="editModal" title="Detil Sekolah">
        <template v-slot:modal-header>
            <h5 class="modal-title">Edit Data Sekolah</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </template>
        <template v-slot:default="{ hide }">
            <div class="form-group">
                <label>NPSN Sekolah</label>
                <input v-model="form.id" type="hidden" name="id" class="form-control" :class="{ 'is-invalid': form.errors.has('id') }">
                <input v-model="form.npsn" type="text" name="npsn" class="form-control" :class="{ 'is-invalid': form.errors.has('npsn') }">
                <has-error :form="form" field="npsn"></has-error>
            </div>
            <div class="form-group">
                <label>Nama Sekolah</label>
                <input v-model="form.nama" type="text" name="nama" class="form-control" :class="{ 'is-invalid': form.errors.has('nama') }">
                <has-error :form="form" field="nama"></has-error>
            </div>
            <div class="form-group">
                <label>Nama Kepala Sekolah</label>
                <input v-model="form.nama_kepsek" type="text" name="nama_kepsek" class="form-control" :class="{ 'is-invalid': form.errors.has('nama_kepsek') }">
                <has-error :form="form" field="nama_kepsek"></has-error>
            </div>
            <div class="form-group">
                <label>NIP Kepala Sekolah</label>
                <input v-model="form.nip_kepsek" type="text" name="nip_kepsek" class="form-control" :class="{ 'is-invalid': form.errors.has('nip_kepsek') }">
                <has-error :form="form" field="nip_kepsek"></has-error>
            </div>
            <div class="form-group">
                <label>Jumlah Rombel</label>
                <input type="text" v-model="form.jml_rombel" name="jml_rombel" class="form-control" :class="{ 'is-invalid': form.errors.has(`jml_rombel`) }"/>
                <has-error :form="form" field="jml_rombel"></has-error>
            </div>
            <template  v-for="(jalur, index) in all_jalur">
                <div class="form-group">
                    <label>Jumlah Pagu Jalur {{jalur.nama}}</label>
                    <input type="text" v-model="form.pagu[jalur.id]" :name="`pagu[${jalur.id}]`" class="form-control" :class="{ 'is-invalid': form.errors.has(`pagu.${jalur.id}`) }"/>
                    <has-error :form="form" :field="`pagu.${jalur.id}`"></has-error>
                </div>
            </template>
        </template>
        <template v-slot:modal-footer="{ hide }">
            <b-button variant="secondary" size="sm" @click="hide()">Tutup</b-button>
            <b-button variant="primary" size="sm" @click="updateData">Perbaharui</b-button>
        </template>
    </b-modal>
</div>
</template>

<script>
import _ from 'lodash' //IMPORT LODASH, DIMANA AKAN DIGUNAKAN UNTUK MEMBUAT DELAY KETIKA KOLOM PENCARIAN DIISI
export default {
    //PROPS INI ADALAH DATA YANG AKAN DIMINTA DARI PENGGUNA COMPONENT DATATABLE YANG KITA BUAT
    props: {
        //ITEMS STRUKTURNYA ADALAH ARRAY, KARENA BAGIAN INI BERISI DATA YANG AKAN DITAMPILKAN DAN SIFATNYA WAJIB DIKIRIMKAN KETIKA COMPONENT INI DIGUNAKAN
        items: {
            type: Array,
            required: true
        },
        //FIELDS JUGA SAMA DENGAN ITEMS
        fields: {
            type: Array,
            required: true
        },
        //ADAPUN META, TYPENYA ADALAH OBJECT YANG BERISI INFORMASI MENGENAL CURRENT PAGE, LOAD PERPAGE, TOTAL DATA, DAN LAIN SEBAGAINYA.
        meta: {
            required: true
        },
        title: {
            type: String,
            default: "Delete Modal"
        },
        editUrl: {
            type: String,
            default: null
        },
    },
    data() {
        return {
            user: user,
            editmode: false,
            form: new Form({
                id: '',
                npsn: '',
                nama: '',
                nama_kepsek: '',
                nip_kepsek: '',
                jml_rombel: '',
                pagu: [],
            }),
            //VARIABLE INI AKAN MENGHADLE SORTING DATA
            sortBy: null, //FIELD YANG AKAN DISORT AKAN OTOMATIS DISIMPAN DISINI
            sortDesc: false, //SEDANGKAN JENISNYA ASCENDING ATAU DESC AKAN DISIMPAN DISINI
            //TAMBAHKAN DUA VARIABLE INI UNTUK MENGHANDLE MODAL DAN DATA YANG AKAN DIHAPUS
            deleteModal: false,
            showModal: false,
            editModal: false,
            editModalVerifikator: false,
            modalText: {},
            all_jalur: [],
            sasaran: false,
        }
    },
    watch: {
        //KETIKA VALUE DARI VARIABLE sortBy BERUBAH
        sortBy(val) {
            //MAKA KITA EMIT DENGAN NAMA SORT DAN DATANYA ADALAH OBJECT BERUPA VALUE DARI SORTBY DAN SORTDESC
            //EMIT BERARTI MENGIRIMKAN DATA KEPADA PARENT ATAU YANG MEMANGGIL COMPONENT INI
            //SEHINGGA DARI PARENT TERSEBUT, KITA BISA MENGGUNAKAN VALUE YANG DIKIRIMKAN
            this.$emit('sort', {
                sortBy: this.sortBy,
                sortDesc: this.sortDesc
            })
        },
        //KETIKA VALUE DARI SORTDESC BERUBAH
        sortDesc(val) {
            //MAKA CARA YANG SAMA AKAN DIKERJAKAN
            this.$emit('sort', {
                sortBy: this.sortBy,
                sortDesc: this.sortDesc
            })
        }
    },
    /*computed: {
        isDisabled: function(){
            return this.sasaran
        }
    },*/
    methods: {
        loadPerPage(val) {
            //DAN KITA EMIT LAGI DENGAN NAMA per_page DAN VALUE SESUAI PER_PAGE YANG DIPILIH
            this.$emit('per_page', this.meta.per_page)
        },
        //KETIKA PAGINATION BERUBAH, MAKA FUNGSI INI AKAN DIJALANKAN
        changePage(val) {
            //KIRIM EMIT DENGAN NAMA PAGINATION DAN VALUENYA ADALAH HALAMAN YANG DIPILIH OLEH USER
            this.$emit('pagination', val)
        },
        //KETIKA KOTAK PENCARIAN DIISI, MAKA FUNGSI INI AKAN DIJALANKAN
        //KITA GUNAKAN DEBOUNCE UNTUK MEMBUAT DELAY, DIMANA FUNGSI INI AKAN DIJALANKAN
        //500 MIL SECOND SETELAH USER BERHENTI MENGETIK
        search: _.debounce(function (e) {
            //KIRIM EMIT DENGAN NAMA SEARCH DAN VALUE SESUAI YANG DIKETIKKAN OLEH USER
            this.$emit('search', e.target.value)
        }, 500),
        deleteData(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Tindakan ini tidak dapat dikembalikan!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    return fetch('/api/sekolah/' + id, {
                        method: 'DELETE',
                    }).then(() => {
                        //this.form.delete('api/komponen/'+id).then(()=>{
                        Swal.fire(
                            'Berhasil!',
                            'Data Sekolah berhasil dihapus',
                            'success'
                        ).then(() => {
                            this.loadPerPage(10);
                        });
                    }).catch((data) => {
                        Swal.fire("Failed!", data.message, "warning");
                    });
                }
            })
        },
        openShowModal(row) {
            this.showModal = true
            this.modalText = row.item
        },
        editData(row) {
            this.editmode = true
            this.editModal = true
            this.form.id = row.item.sekolah_id
            this.form.npsn = row.item.npsn
            this.form.nama = row.item.nama
            this.form.nama_kepsek = row.item.nama_kepsek
            this.form.nip_kepsek = row.item.nip_kepsek
            this.all_jalur = this.meta.all_jalur
            console.log(row.item);
            //let tempRombel = {}
            let tempPagu = {}
            $.each(this.all_jalur, function (key, value) {
                if(value.pagu){
                    tempPagu[value.id] = (value.pagu) ? value.pagu.jumlah : 0
                }
            });
            if(Object.keys(tempPagu).length === 0){
                $.each(row.item.pagu, function (key, value) {
                    console.log(value);
                    tempPagu[value.jalur_id] = value.jumlah
                });
            }
            this.form.jml_rombel = row.item.jml_rombel
            this.form.pagu = tempPagu
            $('#modalEdit').modal('show');
        },
        objectSize(obj){
            Object.size = function(obj) {
            var size = 0,
                key;
            for (key in obj) {
                if (obj.hasOwnProperty(key)) size++;
            }
            return size;
            };
        },
        updateData() {
            let id = this.form.id;
            this.form.put('/api/sekolah/' + id).then((response) => {
                this.editModal = false
                Toast.fire({
                    icon: 'success',
                    title: response.message
                });
                this.loadPerPage(10);
            }).catch((e) => {
                Toast.fire({
                    icon: 'error',
                    title: 'Some error occured! Please try again'
                });
            })
        },
        updatePeta() {
            let id = this.user.sekolah_id;
            axios.put('/api/referensi/update-peta/' + id).then((response) => {
                Toast.fire({
                    icon: 'success',
                    title: 'Lokasi Sekolah berhasil disimpan'
                });
                this.loadPerPage(10);
            }).catch((e) => {
                Toast.fire({
                    icon: 'error',
                    title: 'Some error occured! Please try again'
                });
            })
        },
    }
}
</script>
