<template>
  <div>
    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div>Data Sekolah</div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="main-card mb-3 card">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-th mr-1"></i>
            Data Sekolah
          </h3>
          <div class="btn-actions-pane-right" v-if="hasRole('sekolah')">
            <b-button size="sm" block squared variant="success" @click="editData(detil_sekolah)">Edit Data Sekolah</b-button>
          </div>
        </div>
        <div class="card-body">
          <template v-if="hasRole('admin')">
            <app-datatable :items="items" :fields="fields" :meta="meta" :title="'Hapus Sekolah'" @per_page="handlePerPage" @pagination="handlePagination" @search="handleSearch" @sort="handleSort"/>
          </template>
          <template v-else>
            <table class="table" v-if="detil_sekolah">
              <tr>
                  <td width="30%">Nama</td>
                  <td width="70%">: {{detil_sekolah.nama}}</td>
              </tr>
              <tr>
                  <td>NPSN</td>
                  <td>: {{detil_sekolah.npsn}}</td>
              </tr>
              <tr>
                  <td>Alamat</td>
                  <td>: {{detil_sekolah.alamat_jalan}}</td>
              </tr>
              <tr>
                  <td>Desa/Kelurahan</td>
                  <td>: {{detil_sekolah.desa_kelurahan}}</td>
              </tr>
              <tr>
                  <td>Kecamatan</td>
                  <td>: {{detil_sekolah.kecamatan}}</td>
              </tr>
              <tr>
                  <td>Kabupaten/Kota</td>
                  <td>: {{detil_sekolah.kabupaten}}</td>
              </tr>
              <tr>
                  <td>Provinsi</td>
                  <td>: {{detil_sekolah.provinsi}}</td>
              </tr>
              <tr>
                  <td>Kodepos</td>
                  <td>: {{detil_sekolah.kode_pos}}</td>
              </tr>
              <tr>
                  <td>Telepon</td>
                  <td>: {{detil_sekolah.no_telp}}</td>
              </tr>
              <tr>
                  <td>Fax</td>
                  <td>: {{detil_sekolah.no_fax}}</td>
              </tr>
              <tr>
                  <td>Email</td>
                  <td>: {{detil_sekolah.email}}</td>
              </tr>
              <tr>
                  <td>Website</td>
                  <td>: {{detil_sekolah.website}}</td>
              </tr>
              <tr>
                  <td>Status Sekolah</td>
                  <td>: {{(detil_sekolah.status_sekolah == 1) ? 'Negeri' : 'Swasta'}}</td>
              </tr>
              <tr>
                  <td>Nama Kepala Sekolah</td>
                  <td>: {{detil_sekolah.nama_kepsek}}</td>
              </tr>
              <tr>
                  <td>NIP Kepala Sekolah</td>
                  <td>: {{detil_sekolah.nip_kepsek}}</td>
              </tr>
              <tr>
                  <td>Jumlah Rombel</td>
                  <td>: {{detil_sekolah.jml_rombel}}</td>
              </tr>
              <template  v-for="(jalur, index) in all_jalur">
                <tr>
                    <td>Jumlah Pagu Jalur {{jalur.nama}}</td>
                    <td>: {{(jalur.pagu) ? jalur.pagu.jumlah : '-'}}</td>
                </tr>
              </template>
          </table>
          <h3>Lokasi Sekolah</h3>
          <table class="table" v-if="detil_sekolah">
              <tr>
                  <td width="30%">Bujur</td>
                  <td width="70%">: {{detil_sekolah.bujur}}</td>
              </tr>
              <tr>
                  <td>Lintang</td>
                  <td>: {{detil_sekolah.lintang}}</td>
              </tr>
            </table>
            <GmapMap :center='center' :zoom='16' :sensor="false" labels:true :mapTypeId="mapTypeId" style='width:100%;  height: 400px;'>
              <GmapMarker :key="index" v-for="(m, index) in markers" :position="m.position" :clickable="false" :draggable="false" />
            </GmapMap>
          </template>
        </div>
      </div>
    </section>
    <my-loader />
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
import Datatable from "./../components/Sekolah.vue"; //IMPORT COMPONENT DATATABLENYA
import axios from "axios"; //IMPORT AXIOS
export default {
  //KETIKA COMPONENT INI DILOAD
  created() {
    //MAKA AKAN MENJALANKAN FUNGSI BERIKUT
    this.loadPostsData();
  },
  data() {
    return {
      center: { lat: -7.195404, lng: 113.250257 },
      mapTypeId: 'hybrid',
      markers: [{
        position: {
          lat: -7.195404,
          lng: 113.250257
        }
      }],
      detil_sekolah: null,
      user: user,
      fields: [
        {
          key: "nama",
          label: "Nama Sekolah",
          sortable: true,
        },
        {
          key: "npsn",
          label: "NPSN",
          sortable: true,
        },
        {
          key: "alamat",
          label: "Alamat",
          sortable: true,
        },
        {
          key: "desa_kelurahan",
          label: "Desa/Kelurahan",
          sortable: false,
        },
        {
          key: "kecamatan",
          label: "Kecamatan",
          sortable: true,
        },
        {
          key: "actions",
          label: "Aksi",
          sortable: false,
        }, //TAMBAHKAN CODE INI
      ],
      items: [], //DEFAULT VALUE DARI ITEMS ADALAH KOSONG
      meta: [], //JUGA BERLAKU UNTUK META
      current_page: 1, //DEFAULT PAGE YANG AKTIF ADA PAGE 1
      per_page: 10, //DEFAULT LOAD PERPAGE ADALAH 10
      search: "",
      sortBy: "created_at", //DEFAULT SORTNYA ADALAH CREATED_AT
      sortByDesc: true, //ASCEDING
      sekolah_id: user.sekolah_id,
      editModal: false,
      form: new Form({
        id: '',
        npsn: '',
        nama: '',
        nama_kepsek: '',
        nip_kepsek: '',
        jml_rombel: '',
        pagu: [],
      }),
      all_jalur: [],
    };
  },
  components: {
    "app-datatable": Datatable, //REGISTER COMPONENT DATATABLE
  },
  methods: {
    editData(row) {
      this.editmode = true
      this.editModal = true
      this.form.id = row.sekolah_id
      this.form.nama = row.nama
      this.form.npsn = row.npsn
      this.form.nama_kepsek = row.nama_kepsek
      this.form.nip_kepsek = row.nip_kepsek
      //this.all_jalur = this.meta.all_jalur
            //let tempRombel = {}
      let tempPagu = {}
      $.each(this.all_jalur, function (key, value) {
          console.log(value);
          //tempRombel[value.id] = (value.pagu) ? value.pagu.jml_rombel : 0
          tempPagu[value.id] = (value.pagu) ? value.pagu.jumlah : 0
      });
      this.form.jml_rombel = row.jml_rombel
      this.form.pagu = tempPagu
      $('#modalEdit').modal('show');
    },
    updateData() {
      let id = this.form.id;
      this.form.put('/api/sekolah/' + id).then((response) => {
        this.editModal = false
        Toast.fire({
          icon: 'success',
          title: response.message
        });
        this.loadPostsData();
      }).catch((e) => {
        Toast.fire({
          icon: 'error',
          title: 'Some error occured! Please try again'
        });
      })
    },
    loadPostsData() {
      if(this.hasRole('admin')){
        let current_page = this.current_page; //this.search == '' ? this.current_page : 1
        //LAKUKAN REQUEST KE API UNTUK MENGAMBIL DATA POSTINGAN
        axios.get(`/api/referensi/sekolah`, {
            //KIRIMKAN PARAMETER BERUPA PAGE YANG SEDANG DILOAD, PENCARIAN, LOAD PERPAGE DAN SORTING.
            params: {
              bentuk_pendidikan_id: user.data.bentuk_pendidikan_id,
              sekolah_id: this.sekolah_id,
              user_id: user.user_id,
              page: current_page,
              per_page: this.per_page,
              q: this.search,
              sortby: this.sortBy,
              sortbydesc: this.sortByDesc ? "DESC" : "ASC",
            },
        }).then((response) => {
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
            isBusy: false,
            all_jalur: response.data.jalur
          };
        });
      } else {
        axios.get(`/api/sekolah/detil/`+this.sekolah_id).then((response) => {
          //detil_sekolah
          let getData = response.data.data;
          this.detil_sekolah = getData
          this.all_jalur = response.data.jalur
          let lintang = Number(Number(getData.lintang).toFixed(6))
          let bujur = Number(Number(getData.bujur).toFixed(6))
          this.markers = [{
            position: {
              lat: lintang,
              lng: bujur
            }
          }]
          this.center = { lat: lintang, lng: bujur }
        })
      }
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
