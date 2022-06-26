<template>
<div>
    <div class="row" v-if="hasRole('admin') && !user.data.bentuk_pendidikan_id">
        <div class="col-md-4 mb-2">
            <select class="form-control" v-model="meta.jenjang" @change="filterJenjang">
                <option value="0">== Filter Jenjang ==</option>
                <option value="5">Jenjang SD</option>
                <option value="6">Jenjang SMP</option>                
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-control" v-model="meta.jalur" @change="filterJalur">
                <option value="0">== Filter Jalur Pendaftaran ==</option>
                <template v-for="(jalur, index) in meta.all_jalur">
                    <option :value="jalur.id">{{jalur.nama}}</option>
                </template>
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-control" v-model="meta.status" @change="filterStatus">
                <option value="0">== Filter Status Pendaftaran ==</option>
                <template v-for="(status, index) in meta.all_status">
                    <option :value="status.id">{{status.nama}}</option>
                </template>
                <option value="99">Belum Diverifikasi</option>
            </select>
        </div>
    </div>
    <div class="row" v-else>
        <div class="col-md-6 mb-2">
            <select class="form-control" v-model="meta.jalur" @change="filterJalur">
                <option value="0">== Filter Jalur Pendaftaran ==</option>
                <template v-for="(jalur, index) in meta.all_jalur">
                    <option :value="jalur.id">{{jalur.nama}}</option>
                </template>
            </select>
        </div>
        <div class="col-md-6">
            <select class="form-control" v-model="meta.status" @change="filterStatus">
                <option value="0">== Filter Status Pendaftaran ==</option>
                <template v-for="(status, index) in meta.all_status">
                    <option :value="status.id">{{status.nama}}</option>
                </template>
                <option value="99">Belum Diverifikasi</option>
            </select>
        </div>
    </div>
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
    <b-table :striped="true" :bordered="true" hover :items="items" :fields="fields" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" show-empty>
        <template v-slot:table-busy>
            <div class="text-center text-danger my-2">
                <b-spinner class="align-middle"></b-spinner>
                <strong>Loading...</strong>
            </div>
        </template>
        <template v-slot:cell(sekolah_id)="row">
            {{row.item.sekolah.nama}}
        </template>
        <template v-slot:cell(nama_pendaftar)="row">
            {{row.item.pendaftar.user.name}}
        </template>
        <template v-slot:cell(nik_pendaftar)="row">
            {{row.item.pendaftar.user.username}}
        </template>
        <template v-slot:cell(jalur_id)="row">
            {{row.item.jalur.nama}}
        </template>
        <template v-slot:cell(tukar_akses)="row">
            <b-button variant="danger" size="sm" @click="tukarAkses(row.item)">Tukar Akses</b-button>
        </template>
        <template v-slot:cell(status_id)="row">
            <div class="badge badge-info" v-if="!row.item.kunci">Pendaftaran Belum Dikunci</div>
            <div class="badge badge-warning" v-if="row.item.kunci && !row.item.status">Belum diverifikasi</div>
            <div class="badge badge-success" v-if="row.item.kunci && row.item.status && row.item.status.nama == 'Terima'">Terverifikasi</div>
            <div class="badge badge-danger" v-if="row.item.kunci && row.item.status && row.item.status.nama == 'Tolak'">Ditolak</div>
            <div class="badge badge-info" v-if="row.item.kunci && row.item.status && row.item.status.nama == 'Perbaikan'">Perbaikan</div>
        </template>
        <template v-slot:cell(actions)="row">
            <b-dropdown right variant="primary" size="sm" text="Aksi">
                <!--b-dropdown-item @click="addNilai(row.item)" v-if="hasRole('admin')"><i class="fas fa-check"></i>&nbsp; Tambah Nilai</b-dropdown-item-->
                <b-dropdown-item @click="cetakAkun(row.item.pendaftar.user.user_id)"><i class="fas fa-print"></i>&nbsp;  Cetak Akun</b-dropdown-item>
                <template v-if="!row.item.status && row.item.kunci || row.item.kunci && row.item.status.nama == 'Perbaikan'">
                    <b-dropdown-item @click="openShowModal(row)" v-if="hasRole('sekolah')"><i class="fas fa-check"></i>&nbsp; Verifikasi Dokumen</b-dropdown-item>
                </template>
                <b-dropdown-item @click="hapusPendaftaran(row.item)" v-if="hasRole('admin')"><i class="fas fa-trash"></i>&nbsp; Hapus Pendaftaran</b-dropdown-item>
                <b-dropdown-item @click="cetakPendaftaran(row.item)" v-if="row.item.status"><i class="fas fa-print"></i>&nbsp; Cetak Bukti Pendaftaran</b-dropdown-item>
            </b-dropdown>
            <!--b-button variant="success" size="sm" @click="openDetilModal(row.item)"><i class="fas fa-eye"></i> Detil</b-button-->
            <!--b-button variant="primary" size="sm" @click="cetakAkun(row.item.pendaftar.user.user_id)"><i class="fas fa-print"></i> Cetak Akun</b-button>
            <template v-if="!row.item.status && row.item.kunci || row.item.kunci && row.item.status.nama == 'Perbaikan'">
                <b-button variant="warning" size="sm" @click="openShowModal(row)" v-if="hasRole('sekolah')"><i class="fas fa-check"></i> Verfikasi Dokumen</b-button>
            </template>
            <b-button variant="danger" size="sm" @click="hapusPendaftaran(row.item)" v-if="hasRole('admin')"><i class="fas fa-trash"></i> Hapus Pendaftaran</b-button>
            <b-button variant="success" size="sm" @click="cetakPendaftaran(row.item)" v-if="row.item.status"><i class="fas fa-print"></i> Cetak Bukti Pendaftaran</b-button-->
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
    <b-modal ref="modal-nilai" title="Tambah Nilai" @ok="handleOk">
        <input type="hidden" v-model="nilai.sekolah_pilihan_id">
        <b-form-input v-model="nilai.nilai_akhir"></b-form-input>
    </b-modal>
    <b-modal id="modal-xl" size="xl" v-model="showModal" title="Verifikasi Pendaftaran">
        <table class="table">
            <tr>
                <td width="30%">NIK</td>
                <td width="70%">: {{(modalText.pendaftar) ? (modalText.pendaftar.user) ? modalText.pendaftar.user.username : '-' : '-'}}</td>
            </tr>
            <tr>
                <td>Nama Lengkap</td>
                <td>: {{(modalText.pendaftar) ? (modalText.pendaftar.user) ? modalText.pendaftar.user.name : '-' : '-'}}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>: {{(modalText.pendaftar) ? (modalText.pendaftar.user.jenis_kelamin == 'L') ? 'Laki-laki' : 'Perempuan' : '-'}}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: {{(modalText.pendaftar) ? modalText.pendaftar.user.alamat : '-'}}</td>
            </tr>
            <tr>
                <td>Desa/Kelurahan</td>
                <td>: {{(modalText.pendaftar) ? modalText.pendaftar.user.desa : '-'}}</td>
            </tr>
            <tr>
                <td>Kecamatan</td>
                <td>: {{(modalText.pendaftar) ? modalText.pendaftar.user.kecamatan : '-'}}</td>
            </tr>
            <tr>
                <td>Kabupaten/Kota</td>
                <td>: {{(modalText.pendaftar) ? modalText.pendaftar.user.kabupaten : '-'}}</td>
            </tr>
            <tr>
                <td>Provinsi</td>
                <td>: {{(modalText.pendaftar) ? modalText.pendaftar.user.provinsi : '-'}}</td>
            </tr>
            <tr>
                <td>Telepon</td>
                <td>: {{(modalText.pendaftar) ? modalText.pendaftar.user.nomor_hp : '-'}}</td>
            </tr>
            <tr>
                <td>Jalur Pendaftaran</td>
                <td>: {{(modalText.pendaftar) ? modalText.jalur.nama : '-'}}</td>
            </tr>
            <tr>
                <td>Jarak ke Sekolah</td>
                <td>: {{jarak_ke_sekolah}}</td>
            </tr>
        </table>
        <h3>Lokasi Pendaftar</h3>
        <GmapMap :center='center' :zoom='16' :sensor="false" labels:true :mapTypeId="mapTypeId" style='width:100%;  height: 400px;' ref="mapRef" id="map">
            <GmapMarker :key="index" v-for="(m, index) in markers" :position="m.position" @click="center=m.position" :clickable="false" :draggable="false"/>
        </GmapMap>
        <h3>Kelengkapan Dokumen</h3>
        <input v-model="form.pendaftar_id" type="hidden" name="pendaftar_id" class="form-control">
        <input v-model="form.jml_dokumen" type="hidden" name="jml_dokumen" class="form-control">
        <input v-model="form.jml_piagam" type="hidden" name="jml_piagam" class="form-control">
        <table class="table">
            <thead>
                <tr>
                    <th width="20%">Jenis Berkas</th>
                    <th width="30%">Bukti Berkas</th>
                    <th width="10%">Lihat Berkas</th>
                    <th width="20%">Hasil Verifikasi</th>
                    <th width="20%">Catatan Verifikasi</th>
                </tr>
            </thead>
            <tbody>
                <template v-if="data_dokumen.length">
                    <tr v-for="dok in data_dokumen">
                        <td>{{dok.komponen.nama}}</td>
                        <td>{{dok.komponen.bukti}}</td>
                        <td><a :href="'/uploads/'+dok.berkas" title="Lihat Dokumen" class="btn btn-primary" target="_blank"><i class="fa fa-external-link-alt"></i></a></td>
                        <td>
                            <v-select label="nama" :options="hasil_verifikasi" v-model="form.status_id[dok.dokumen_id]" @input="status_id => updateCountry(dok, status_id)" />
                        </td>
                        <td>
                            <b-form-textarea id="textarea" v-model="form.catatan[dok.dokumen_id]" placeholder="Tulis catatan disini..." rows="3" max-rows="6"></b-form-textarea>
                        </td>
                    </tr>
                </template>
                <template v-else>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data untuk ditampilkan</td>
                    </tr>
                </template>
            </tbody>
        </table>
        <template v-if="ada_piagam">
            <h3>Dokumen Piagam</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Kejuaraan</th>
                        <th>Tingkat Prestasi</th>
                        <th>Juara</th>
                        <th>Tanggal Dokumen</th>
                        <th>Bukti Berkas</th>
                        <th>Hasil Verifikasi</th>
                        <th>Catatan Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="data_piagam.length">
                        <tr v-for="(piagam, index) in data_piagam">
                            <td class="text-center">{{index + 1}}</td>
                            <td>{{(piagam.skor_prestasi) ? piagam.skor_prestasi.jenis_kejuaraan.nama : '-'}}</td>
                            <td>{{piagam.tingkat_prestasi.nama}}</td>
                            <td class="text-center">{{piagam.juara}}</td>
                            <td>{{piagam.tanggal | tanggalIndo}}</td>
                            <td><a :href="'/uploads/'+piagam.dokumen" title="Lihat Dokumen" class="btn btn-primary" target="_blank"><i class="fa fa-external-link-alt"></i></a></td>
                            <td>
                                <v-select label="nama" :options="hasil_verifikasi" v-model="form.status_id_piagam[piagam.id]" @input="status_id_piagam => updateStatusPiagam(piagam, status_id_piagam)" />
                            </td>
                            <td>
                                <b-form-textarea id="textarea" v-model="form.catatan_piagam[piagam.id]" placeholder="Tulis catatan disini..." rows="3" max-rows="6"></b-form-textarea>
                            </td>
                        </tr>
                    </template>
                    <template v-else>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data untuk ditampilkan</td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </template>
        <template v-if="ada_nilai">
            <h3>Nilai Rapor</h3>
            <table class="table table-bordered table-striped table-hover">
                <!--thead>
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
                        <td class="text-center">{{nilai_rapor['IV'][1][mapel.id]}}</td>
                        <td class="text-center">{{nilai_rapor['IV'][2][mapel.id]}}</td>
                        <td class="text-center">{{nilai_rapor['V'][1][mapel.id]}}</td>
                        <td class="text-center">{{nilai_rapor['V'][2][mapel.id]}}</td>
                        <td class="text-center">{{nilai_rapor['VI'][1][mapel.id]}}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-center">Rata-rata Nilai Semester</th>
                        <th class="text-center">{{rerata['IV'][1]}}</th>
                        <th class="text-center">{{rerata['IV'][2]}}</th>
                        <th class="text-center">{{rerata['V'][1]}}</th>
                        <th class="text-center">{{rerata['V'][2]}}</th>
                        <th class="text-center">{{rerata['VI'][1]}}</th>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-center">Rata-rata Akhir</th>
                        <th colspan="5" class="text-center">{{rerata_akhir}}</th>
                    </tr>
                </tfoot-->
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
                        <td class="text-center">{{nilai_rapor[mapel.id]}}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-center">Rata-rata Akhir</th>
                        <th class="text-center">{{rerata_akhir}}</th>
                    </tr>
                </tfoot>
            </table>
        </template>
        <template v-slot:modal-footer>
            <b-button variant="secondary" size="sm" @click="showModal=false">Tutup</b-button>
            <b-button variant="primary" size="sm" @click="prosesVerifikasi" v-if="data_dokumen.length">Proses Verifikasi</b-button>
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
            rerata_akhir: 0,
            ada_nilai: 0,
            mata_pelajaran: [],
            nilai_rapor: {},
            rerata: {},
            ada_piagam: 0,
            jarak_ke_sekolah: '',
            data_dokumen: [],
            data_piagam: [],
            kunci: false,
            hasil_verifikasi: [],
            user: user,
            editmode: false,
            form: new Form({
                user_id: user.user_id,
                status_id: {},
                pendaftar_id: '',
                jml_dokumen: 0,
                jml_piagam: 0,
                catatan: {},
                sekolah_pilihan_id: '', 
                status_id_piagam: {},
                catatan_piagam: {},
            }),
            //VARIABLE INI AKAN MENGHADLE SORTING DATA
            sortBy: null, //FIELD YANG AKAN DISORT AKAN OTOMATIS DISIMPAN DISINI
            sortDesc: false, //SEDANGKAN JENISNYA ASCENDING ATAU DESC AKAN DISIMPAN DISINI
            //TAMBAHKAN DUA VARIABLE INI UNTUK MENGHANDLE MODAL DAN DATA YANG AKAN DIHAPUS
            deleteModal: false,
            showModal: false,
            showDetil: false,
            modalText: {},
            modalTextAdmin: {},
            selected: null,
            sasaran: false,
            center: { lat: -7.195404, lng: 113.250257 },
            //currentPlace: null,
            markers: [{
                position: {
                    lat: -7.195404,
                    lng: 113.250257
                }
            }],
            //places: [],
            //coordinates: {},
            mapTypeId: 'hybrid',
            nilai: {
                sekolah_pilihan_id: null,
                nilai_akhir: 0,
            },
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
        tukarAkses(item){
            let siswa_id = item.pendaftar.user_id
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Anda akan beralih sebagai akun Siswa",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya!",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.value) {
                    window.open('/tukar-akses/'+siswa_id+'/'+this.user.user_id, '_self')
                    /*return fetch("/api/tukar-akses/" + siswa_id)
                        .then((response) => response.json())
                        .then((data) => {
                        console.log(data);
                    });*/
                }
            });
        },
        bukaKunci(item, modalTextAdmin){
            axios.post(`/api/pendaftar/kunci`, {
                sekolah_pilihan_id: item.sekolah_pilihan_id,
            })
            .then((response) => {
                Swal.fire(response.data.title, response.data.text, response.data.icon).then(() => {
                    axios.get(`/api/pendaftar/`+modalTextAdmin.pendaftar_id)
                    .then((response) => {
                        this.showDetil = false
                        this.openDetilModal(response.data.data);
                    })
                });
            });
        },
        handleOk(bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault()
            // Trigger submit handler
            this.handleSubmit()
        },
        handleSubmit(){
            axios.post(`/api/pendaftar/update-nilai`, {
                sekolah_pilihan_id: this.nilai.sekolah_pilihan_id,
                nilai_akhir: this.nilai.nilai_akhir,
            })
            .then((response) => {
                this.$refs['modal-nilai'].hide()
                Swal.fire(response.data.title, response.data.text, response.data.icon).then(() => {
                    this.loadPerPage(this.meta.per_page)
                });
            });
        },
        addNilai(item){
            console.log(item);
            this.nilai = {
                sekolah_pilihan_id: item.sekolah_pilihan_id,
                nilai_akhir:item.titipan,
            }
            this.$refs['modal-nilai'].show()
        },
        hapusPendaftaran(item, modalTextAdmin){
            axios.post(`/api/pendaftar/hapus`, {
                sekolah_pilihan_id: item.sekolah_pilihan_id,
            })
            .then((response) => {
                Swal.fire(response.data.title, response.data.text, response.data.icon).then(() => {
                    this.loadPerPage(this.meta.per_page)
                    /*axios.get(`/api/pendaftar/`+modalTextAdmin.pendaftar_id)
                    .then((response) => {
                        this.showDetil = false
                        this.openDetilModal(response.data.data);
                    })*/
                });
            });
        },
        updateCountry (dok, status_id) {
            dok.status_id = status_id;
        },
        updateStatusPiagam(piagam, status_id_piagam){
            piagam.status_id = status_id_piagam;
        },
        prosesVerifikasi() {
            this.$loading(true)
            this.form.post('/api/pendaftar/proses').then((response)=>{
                this.$loading(false)
                Toast.fire({
                    icon: response.status,
                    title: response.message
                });
                this.loadPerPage(10)
                this.showModal = false
                this.showDetil = false
            }).catch((error)=>{
                let errors = (error.status_id) ? error.status_id : error.status_id_piagam
                Swal.fire("Gagal!", errors.join(','), "warning");
            })
        },
        filterJenjang(val){
            this.$emit('filter_jenjang', this.meta.jenjang)
        },
        filterJalur(val){
            this.$emit('filter_jalur', this.meta.jalur)
        },
        filterStatus(val){
            this.$emit('filter_status', this.meta.status)
        },
        //JIKA SELECT BOX DIGANTI, MAKA FUNGSI INI AKAN DIJALANKAN
        loadPerPage(val) {
            console.log(this.meta.per_page);
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
        openShowModal(row) {
            this.getStatus(row.item.pendaftar_id, user.sekolah_id, row.item.jalur_id)
            this.showModal = true
            this.modalText = row.item
            this.form.pendaftar_id = row.item.pendaftar_id
            this.form.sekolah_pilihan_id = row.item.sekolah_pilihan_id
            let lintang = Number(row.item.pendaftar.user.lintang).toFixed(6);
            let bujur = Number(row.item.pendaftar.user.bujur).toFixed(6);
            this.markers[0] = {
                position: {
                    lat: Number(lintang),
                    lng: Number(bujur)
                }
            }
            this.center = { lat: Number(lintang), lng: Number(bujur) };
        },
        openDetilModal(item) {
            this.showDetil = true
            this.modalTextAdmin = item
        },
        cetakAkun(user_id){
            window.open('/cetak/akun/'+user_id, '_blank')
        },
        getStatus(pendaftar_id, sekolah_id, jalur_id){
            this.$loading(true)
            axios.get(`/api/pendaftaran/all-status`,{
                params: {
                    pendaftar_id: pendaftar_id,
                    sekolah_id: sekolah_id,
                    jalur_id: jalur_id,
                }
            })
            .then((response) => {
                this.$loading(false)
                let getData = response.data.data
                this.ada_piagam = response.data.pendaftar.sekolah_pilihan_single.jalur.prestasi
                let lintang_sekolah = Number(response.data.pendaftar.sekolah_pilihan_single.sekolah.lintang).toFixed(6);
                let bujur_sekolah = Number(response.data.pendaftar.sekolah_pilihan_single.sekolah.bujur).toFixed(6);
                this.markers[1] = {
                    position: {
                        lat: Number(lintang_sekolah),
                        lng: Number(bujur_sekolah)
                    }
                }
                var ltlng = [];
                $.each(this.markers, function(index, value){
                    ltlng.push(new google.maps.LatLng(value.position.lat, value.position.lng));
                })
                var flightPath = new google.maps.Polyline({
                    path: ltlng,
                    geodesic: true,
                    strokeColor: '#4986E7',
                    strokeOpacity: 1.0,
                    strokeWeight: 2
                });
                this.$refs.mapRef.$mapPromise.then((map) => {
                    flightPath.setMap(map);
                })

                let Dokumen = response.data.pendaftar.dokumen
                this.data_dokumen = Dokumen
                this.data_piagam = response.data.pendaftar.piagam
                this.form.jml_dokumen = Dokumen.length
                this.form.jml_piagam = this.data_piagam.length
                this.hasil_verifikasi = getData
                let tempStatus = {}
                let tempCatatan = {}
                $.each(Dokumen, function (key, value) {
                    if(value.status){
                        tempStatus[value.dokumen_id] = {id: value.status_id, nama: value.status.nama} 
                        tempCatatan[value.dokumen_id] = value.catatan
                    }
                })
                this.form.status_id = tempStatus
                this.form.catatan = tempCatatan
                this.jarak_ke_sekolah = response.data.pendaftar.sekolah_pilihan_single.jarak+' m'
                let tempStatusPiagam = {}
                let tempCatatanPiagam = {}
                $.each(this.data_piagam, function (key, value) {
                    if(value.status){
                        tempStatusPiagam[value.id] = {id: value.status_id, nama: value.status.nama} 
                        tempCatatanPiagam[value.id] = value.catatan
                    }
                })
                this.form.status_id_piagam = tempStatusPiagam
                this.form.catatan_piagam = tempCatatanPiagam
                this.mata_pelajaran = response.data.mata_pelajaran
                /*let tempNilai = {}
                let getNilai = response.data.nilai;
                if(Object.keys(getNilai).length){
                    this.ada_nilai = (response.data.pendaftar.user.bentuk_pendidikan_id === 6) ? 1 : 0
                    this.nilai_rapor = getNilai
                    this.rerata = response.data.rerata
                } else {
                    this.rerata = tempNilai
                    this.nilai_rapor = tempNilai
                }
                this.rerata_akhir = response.data.rerata_akhir*/
            })
        },
        cetakPendaftaran(row){
            window.open('/cetak/pendaftaran/'+row.sekolah_pilihan_id, '_blank')
        },
    }
}
</script>
