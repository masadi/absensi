<template>
  <div>
    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div>Informasi Hasil Seleksi Jalur {{nama_jalur}} {{nama_jenjang}}</div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="main-card mb-3 card">
        <div class="card-header">
          Informasi Hasil Seleksi Jalur {{nama_jalur}} {{nama_jenjang}}
          <template v-if="hasRole('admin') || hasRole('sekolah')">
            <div class="btn-actions-pane-right">
              <b-button-group size="sm">
                <b-button v-if="hasRole('admin')" variant="danger" @click="GenerateHasil(jalur_id, sekolah_id)"><i class="fas fa-sync"></i> Generate Hasil</b-button>
                <b-button variant="primary" @click="DownloadBiodata(jalur_id, sekolah_id)" v-if="hasRole('sekolah')"><i class="fas fa-user"></i> Download Biodata</b-button>
                <b-button variant="success" @click="DownloadExcel(jalur_id, sekolah_id)" v-if="hasRole('sekolah')"><i class="fas fa-download"></i> Download Hasil</b-button>
              </b-button-group>
            </div>
          </template>
        </div>
        <div class="card-body">
            <template v-if="hasRole('siswa')">
              <template v-if="hasil_seleksi">
                <table class="table">
                  <tr>
                    <td width="30%">Sekolah Tujuan</td>
                    <td width="70%">: {{hasil_seleksi.sekolah_tujuan}}</td>
                  </tr>
                  <tr>
                    <td>Jumlah Pagu</td>
                    <td>: {{hasil_seleksi.sekolah.sekolah.pagu_single.jumlah}}</td>
                  </tr>
                  <tr v-if="hasil_seleksi.sekolah.jalur.tautan === 'zonasi'">
                    <td v-if="hasil_seleksi.sekolah.pendaftar.bentuk_pendidikan_id === 6">Jarak 90%</td>
                    <td v-else>Jarak 40%</td>
                    <td>: {{hasil_seleksi.sekolah.jarak}} Meter</td>
                  </tr>
                  <tr v-if="hasil_seleksi.sekolah.jalur.tautan === 'zonasi' && hasil_seleksi.sekolah.pendaftar.bentuk_pendidikan_id === 6">
                    <td>Nilai Rapor 5%</span></td>
                    <td>: {{hasil_seleksi.sekolah.nilai_mapel}}</td>
                  </tr>
                  <tr v-if="hasil_seleksi.sekolah.jalur.tautan === 'zonasi'">
                    <td v-if="hasil_seleksi.sekolah.pendaftar.bentuk_pendidikan_id === 6">Umur 5%</td>
                    <td v-else>Umur 60%</td>
                    <td>: {{hasil_seleksi.sekolah.pendaftar.user.usia}}</td>
                  </tr>
                  <tr>
                    <td>Nilai Akhir</td>
                    <td>: {{hasil_seleksi.nilai_akhir}}</td>
                  </tr>
                  <tr>
                    <td>Ranking</td>
                    <td>: {{hasil_seleksi.rangking}} dari {{hasil_seleksi.jml_pendaftar}} Pendaftar</td>
                  </tr>
                  <tr>
                    <td>Status Verifikasi</td>
                    <td>: 
                      <template v-if="hasil_seleksi.sekolah.sekolah.pagu_single.jumlah < hasil_seleksi.rangking">
                        Tidak diterima
                      </template>
                      <template v-else>
                        {{(hasil_seleksi.status) ? 'Di '+hasil_seleksi.status.nama : 'Belum dilakukan verifikasi'}} <b-button variant="primary" @click="DownloadBukti(hasil_seleksi)" v-if="!open"><i class="fas fa-download"></i> Download Bukti Penerimaan</b-button>
                      </template> 
                    </td>
                  </tr>
                </table>
                <div class="badge badge-danger" v-if="open">Keterangan: Hasil ranking diatas bersifat sementara. Hasil final akan diumumkan pada tanggal 04 Juli 2022</div>
              </template>
              <template v-else>
                <h3 class="text-center">Proses seleksi sedang berlangsung</h3>
              </template>
            </template>
            <template v-else>
              <p>{{keterangan}}</p>
              <app-datatable
                :items="items"
                :fields="fields"
                :meta="meta"
                :title="'Hapus Sekolah'"
                @per_page="handlePerPage"
                @pagination="handlePagination"
                @search="handleSearch"
                @sort="handleSort"
                @filter_sekolah="handleFilterSekolah"
              />
            </template>
        </div>
      </div>
    </section>
    <b-modal ref="modal-download" hide-footer title="Download Hasil">
      <b-form-select v-model="download.filter" class="mb-3" @change="selectFilter">
        <template #first>
          <b-form-select-option :value="null">-- Filter Hasil --</b-form-select-option>
        </template>
        <b-form-select-option value="1">Semua Pendaftar</b-form-select-option>
        <b-form-select-option value="2">Pendaftar Diterima</b-form-select-option>
        <b-form-select-option value="3">Pendaftar Tidak Diterima</b-form-select-option>
      </b-form-select>
      <b-form-select v-model="download.output" class="mb-3" @change="selectOutput">
        <template #first>
          <b-form-select-option :value="null">-- Filter Output --</b-form-select-option>
        </template>
        <b-form-select-option value="1">PDF</b-form-select-option>
        <b-form-select-option value="2">EXCEL</b-form-select-option>
      </b-form-select>
      <b-button class="mt-2" variant="primary" block @click="downloadHasil" :disabled="disableSelect">DOWNLOAD</b-button>
    </b-modal>
  </div>
</template>
<script>
import Datatable from "./Hasil_seleksi";
import moment from 'moment'
export default {
  created() {
    this.$loading(true)
    if(this.hasRole('siswa')){
      this.loadPostSiswa()
    } else {
      this.loadPostsData();
    }
    var sekarang = moment().format('YYYY-MM-DD');
    var beda = moment(sekarang).isBefore('2022-07-04', 'day');
    this.open = beda
  },
  data() {
    return {
      download: {
        filter:null,
        output: null,
      },
      disableSelect: true,
      fields: [],
      items: [], //DEFAULT VALUE DARI ITEMS ADALAH KOSONG
      meta: [], //JUGA BERLAKU UNTUK META
      current_page: 1, //DEFAULT PAGE YANG AKTIF ADA PAGE 1
      per_page: 10, //DEFAULT LOAD PERPAGE ADALAH 10
      search: "",
      sortBy: "nilai", //DEFAULT SORTNYA ADALAH CREATED_AT
      sortByDesc: true, //ASCEDING
      nama_jalur: '',
      keterangan: '',
      nama_jenjang: '',
      jalur_id: '', 
      sekolah_id: (user.sekolah_id) ? user.sekolah_id : '',
      hasil_seleksi: null,
      meta_sekolah_id: user.sekolah_id,
      open: true,
    };
  },
  components: {
    "app-datatable": Datatable, //REGISTER COMPONENT DATATABLE
  },
  methods: {
    selectFilter(){
      if(this.download.filter && this.download.output){
        this.disableSelect = false
      } else {
        this.disableSelect = true
      }
    },
    selectOutput(){
      if(this.download.filter && this.download.output){
        this.disableSelect = false
      } else {
        this.disableSelect = true
      }
    },
    downloadHasil(){
      this.$refs['modal-download'].hide()
      window.open('/cetak/hasil/'+this.jalur_id+'/'+this.download.filter+'/'+this.download.output+'/'+this.sekolah_id, '_blank')
    },
    loadPostSiswa(){
      let route = this.$route.meta
      let bentuk_pendidikan_id = (this.$route.params.bentuk_pendidikan_id) ? this.$route.params.bentuk_pendidikan_id : user.data.bentuk_pendidikan_id
      axios.post(`/api/seleksi`, {
        user_id: user.user_id,
        tautan: route,
        bentuk_pendidikan_id: bentuk_pendidikan_id,
      }).then((response) => {
        this.$loading(false)
        let getData = response.data;
        this.nama_jalur = getData.jalur.nama
        if (!response.data.data) {
          return false;
        }
        this.hasil_seleksi = {
          jml_pendaftar: getData.data.sekolah.sekolah_pilihan_count,
          sekolah_tujuan: getData.data.sekolah.nama,
          nilai_akhir: getData.data.nilai_akhir,
          rangking: getData.rangking,
          status: getData.data.status,
          sekolah: getData.data,
        }
      })
    },
    loadPostsData() {
      let route = this.$route.meta
      let bentuk_pendidikan_id = (this.$route.params.bentuk_pendidikan_id) ? this.$route.params.bentuk_pendidikan_id : user.data.bentuk_pendidikan_id
      console.log(bentuk_pendidikan_id);
      let set_fields = []
      if(this.hasRole('admin') || this.hasRole('dinas')){
        if(route === 'zonasi'){
          if(bentuk_pendidikan_id === '5'){
            set_fields = set_fields = [
              {
                key: "nomor",
                label: "No",
                class: "text-center",
                sortable: false,
              },
              {
                key: "nama_siswa",
                label: "NAMA",
                thClass: "text-center",
                sortable: false,
              },
              {
                key: "nik",
                label: "NIK",
                class: "text-center",
                sortable: false,
              },
              {
                key: "sekolah_tujuan",
                thClass: "text-center",
                label: "Sekolah Tujuan",
                sortable: false,
              },
              {
                key: "usia",
                label: (route === 'zonasi') ? "UMUR (60%)" : "UMUR",
                class: "text-center",
                sortable: false,
              },
              {
                key: "jarak",
                label: (route === 'zonasi') ? "JARAK (40%)" : "JARAK",
                class: "text-center",
                sortable: false,
              },
              {
                key: "nilai_akhir",
                class: "text-center",
                label: "NILAI AKHIR",
                sortable: false,
              },
            ]
          } else {
            set_fields = [
              {
                key: "nomor",
                label: "No",
                class: "text-center",
                sortable: false,
              },
              {
                key: "nama_siswa",
                label: "NAMA",
                thClass: "text-center",
                sortable: false,
              },
              {
                key: "nik",
                label: "NIK",
                class: "text-center",
                sortable: false,
              },
              {
                key: "sekolah_tujuan",
                thClass: "text-center",
                label: "Sekolah Tujuan",
                sortable: false,
              },
              {
                key: "usia",
                label: (route === 'zonasi') ? "UMUR (5%)" : "UMUR",
                class: "text-center",
                sortable: false,
              },
              {
                key: "jarak",
                label: (route === 'zonasi') ? "JARAK (90%)" : "JARAK",
                class: "text-center",
                sortable: false,
              },
              {
                key: "nilai_mapel",
                label: (route === 'zonasi') ? "NILAI RAPOR (5%)" : "NILAI RAPOR",
                class: "text-center",
                sortable: false,
              },
              {
                key: "nilai_akhir",
                class: "text-center",
                label: "NILAI AKHIR",
                sortable: false,
              },
            ]
          }
        } else {
          set_fields = [
            {
              key: "nomor",
              label: "No",
              class: "text-center",
              sortable: false,
            },
            {
              key: "nama_siswa",
              label: "NAMA",
              sortable: false,
            },
            {
              key: "nik",
              label: "NIK",
              class: "text-center",
              sortable: false,
            },
            {
              key: "nilai_akhir",
              class: "text-center",
              label: "NILAI AKHIR",
              sortable: false,
            },
          ]
        }
      } else {
        if(route === 'zonasi'){
          if(bentuk_pendidikan_id === 5){
            set_fields = [
              {
                key: "nomor",
                label: "No",
                class: "text-center",
                sortable: false,
              },
              {
                key: "nama_siswa",
                label: "NAMA",
                thClass: "text-center",
                sortable: false,
              },
              {
                key: "nik",
                label: "NIK",
                class: "text-center",
                sortable: false,
              },
              {
                key: "usia",
                label: (route === 'zonasi') ? "UMUR (60%)" : "UMUR",
                class: "text-center",
                sortable: false,
              },
              {
                key: "jarak",
                label: (route === 'zonasi') ? "JARAK (40%)" : "JARAK",
                class: "text-center",
                sortable: false,
              },
              {
                key: "nilai_akhir",
                class: "text-center",
                label: "NILAI AKHIR",
                sortable: false,
              },
            ]
          } else {
            set_fields = [
              {
                key: "nomor",
                label: "No",
                class: "text-center",
                sortable: false,
              },
              {
                key: "nama_siswa",
                label: "NAMA",
                thClass: "text-center",
                sortable: false,
              },
              {
                key: "nik",
                label: "NIK",
                class: "text-center",
                sortable: false,
              },
              {
                key: "usia",
                label: (route === 'zonasi') ? "UMUR (5%)" : "UMUR",
                class: "text-center",
                sortable: false,
              },
              {
                key: "jarak",
                label: (route === 'zonasi') ? "JARAK (90%)" : "JARAK",
                class: "text-center",
                sortable: false,
              },
              {
                key: "nilai_mapel",
                label: (route === 'zonasi') ? "NILAI RAPOR (5%)" : "NILAI RAPOR",
                class: "text-center",
                sortable: false,
              },
              {
                key: "nilai_akhir",
                class: "text-center",
                label: "NILAI AKHIR",
                sortable: false,
              },
            ]
          }
        } else {
          set_fields = [
            {
              key: "nomor",
              label: "No",
              class: "text-center",
              sortable: false,
            },
            {
              key: "nama_siswa",
              label: "NAMA",
              sortable: false,
            },
            {
              key: "nik",
              label: "NIK",
              class: "text-center",
              sortable: false,
            },
            {
              key: "nilai_akhir",
              class: "text-center",
              label: "NILAI AKHIR",
              sortable: false,
            },
          ]
        }
      }
      this.fields = set_fields
      //console.log(user.data);
      this.$loading(true)
      let current_page = this.current_page; 
      axios.post(`/api/seleksi`, {
        sekolah_id: this.meta_sekolah_id,
        user_id: user.user_id,
        bentuk_pendidikan_id: bentuk_pendidikan_id,
        tautan: route,
        page: current_page,
        per_page: this.per_page,
        q: this.search,
        sortby: this.sortBy,
        sortbydesc: this.sortByDesc ? "DESC" : "ASC",
      }).then((response) => {
        this.$loading(false)
        this.loading = false;
        let getData = response.data.data;
        if (!getData) {
          return false;
        }
        this.nama_jenjang = (this.hasRole('admin')) ? response.data.jenjang : ''
        this.nama_jalur = response.data.jalur.nama
        this.jalur_id = response.data.jalur.id
        this.jenjang = (this.$route.params) ? this.$route.params.bentuk_pendidikan_id : user.data.bentuk_pendidikan_id
        this.keterangan = 'Urutan hasil seleksi Jalur '+response.data.jalur.nama+' sesuai peringkat tertinggi'
        this.items = getData.data; //MAKA ASSIGN DATA POSTINGAN KE DALAM VARIABLE ITEMS
        //DAN ASSIGN INFORMASI LAINNYA KE DALAM VARIABLE META
        this.meta = {
          total: getData.total,
          current_page: getData.current_page,
          per_page: getData.per_page,
          from: getData.from,
          to: getData.to,
          all_sekolah: response.data.all_sekolah,
          sekolah_id: this.meta_sekolah_id,
        };
      })
    },
    DownloadBukti(item){
      console.log(item.sekolah.sekolah_pilihan_id);
      window.open('/cetak/penerimaan/'+item.sekolah.sekolah_pilihan_id, '_blank')
    },
    DownloadExcel(jalur_id = null, sekolah_id = ''){
      this.$refs['modal-download'].show()
    },
    DownloadBiodata(jalur_id = null, sekolah_id = ''){
      window.open('/cetak/biodata/'+jalur_id+'/'+sekolah_id, '_blank')
    },
    GenerateHasil(jalur_id = null, sekolah_id = ''){
      let data = {jalur_id: jalur_id, sekolah_id: sekolah_id}
      Swal.fire({
        title: "Generate Nilai Akhir",
        text: "Proses Ini akan sedikit memakan waktu tergantung dari jumlah pendaftar!",
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya!",
        cancelButtonText: "Batal",
      }).then((result) => {
        if (result.value) {
          this.$loading(true)
          return fetch('/api/generate-hasil', {
            method: 'POST', // or 'PUT'
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
          })
          .then(response => response.json())
          .then(data => {
            Swal.fire(data.title, data.text, data.icon).then(() => {
              this.loadPostsData();
            })
          })
          .catch((error) => {
            console.error('Error:', error);
          });
        }
      })
          /*axios.post(`/api/generate-hasil`, {
            jalur_id: jalur_id,
            sekolah_id: sekolah_id,
          }).then((response) => {
            this.loading = false;
            let getData = response.data.data;
          })*/
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
    handleFilterSekolah(val){
      console.log(val);
      this.meta_sekolah_id= (val) ? val : ''
      this.loadPostsData()
    },
  },
};
</script>
