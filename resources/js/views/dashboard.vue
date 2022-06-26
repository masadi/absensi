<template>
  <div class="no">
    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div>Beranda</div>
        </div>
        <div class="page-title-actions" v-if="hasRole('admin')">
          <button type="button" class="btn-shadow mr-3 btn btn-dark" @click="downloadRekap">
            <i class="fa fa-download"></i> DOWNLOAD REKAP
          </button>
        </div>
      </div>
    </div>
    <section class="content" v-if="hasRole('admin') || hasRole('dinas')">
      <template v-if="user.data.bentuk_pendidikan_id === 5">
        <div class="row">
          <div class="col-lg-6 col-xl-6">
            <div class="card mb-3 widget-content bg-night-fade">
              <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                  <div class="widget-heading">Jumlah SD</div>
                </div>
                <div class="widget-content-right">
                  <div class="widget-numbers text-white">
                    <span>{{ jml_sd }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-xl-6">
            <div class="card mb-3 widget-content bg-happy-green">
              <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                  <div class="widget-heading">
                    Jumlah Pendaftar SD
                  </div>
                </div>
                <div class="widget-content-right">
                  <div class="widget-numbers text-warning">
                    <span>{{ jml_pendaftar_sd }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="main-card mb-3 card">
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <div class="text-lg text-center">Pendaftar SD</div>
                <div class="chartdiv" id="chartSD" ref="chartSD" style="width: 100%; height: 500px"></div>
              </div>
            </div>
          </div>
        </div>
      </template>
      <template v-else-if="user.data.bentuk_pendidikan_id === 6">
        <div class="row">
          <div class="col-lg-6 col-xl-6">
            <div class="card mb-3 widget-content bg-night-fade">
              <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                  <div class="widget-heading">Jumlah SMP</div>
                </div>
                <div class="widget-content-right">
                  <div class="widget-numbers text-white">
                    <span>{{ jml_smp }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-xl-6">
            <div class="card mb-3 widget-content bg-happy-green">
              <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                  <div class="widget-heading">
                    Jumlah Pendaftar SMP
                  </div>
                </div>
                <div class="widget-content-right">
                  <div class="widget-numbers text-warning">
                    <span>{{ jml_pendaftar_smp }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="main-card mb-3 card">
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <div class="text-lg text-center">Pendaftar SMP</div>
                <div class="chartdiv" id="chartSMP" ref="chartSMP" style="width: 100%; height: 500px"></div>
              </div>
            </div>
          </div>
        </div>
      </template>
      <template v-else>
        <div class="row">
          <div class="col-lg-6 col-xl-3">
            <div class="card mb-3 widget-content bg-night-fade">
              <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                  <div class="widget-heading">Jumlah SD</div>
                </div>
                <div class="widget-content-right">
                  <div class="widget-numbers text-white">
                    <span>{{ jml_sd }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-xl-3">
            <div class="card mb-3 widget-content bg-arielle-smile">
              <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                  <div class="widget-heading">Jumlah SMP</div>
                </div>
                <div class="widget-content-right">
                  <div class="widget-numbers text-white">
                    <span>{{ jml_smp }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-xl-3">
            <div class="card mb-3 widget-content bg-happy-green">
              <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                  <div class="widget-heading">
                    Jumlah Pendaftar SD
                  </div>
                </div>
                <div class="widget-content-right">
                  <div class="widget-numbers text-warning">
                    <span>{{ jml_pendaftar_sd }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-xl-3">
            <div class="card mb-3 widget-content bg-premium-dark">
              <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                  <div class="widget-heading">
                    Jumlah Pendaftar SMP
                  </div>
                </div>
                <div class="widget-content-right">
                  <div class="widget-numbers text-warning">
                    <span>{{ jml_pendaftar_smp }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="main-card mb-3 card">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="text-lg text-center">Pendaftar SD</div>
                <div class="chartdiv" id="chartSD" ref="chartSD" style="width: 100%; height: 500px"></div>
              </div>
              <div class="col-lg-6">
                <div class="text-lg text-center">Pendaftar SMP</div>
                <div class="chartdiv" id="chartSMP" ref="chartSMP" style="width: 100%; height: 500px"></div>
              </div>
            </div>
          </div>
        </div>
      </template>
    </section>
    <section class="content" v-if="hasRole('siswa')">
      <!--div class="row">
        <div class="col-md-6" v-for="(jalur, index) in all_jalur">
          <div :class="'mb-3 card text-white card-body h-auto '+jalur.card">
            <h5 class="text-white card-title">Jalur {{jalur.nama}}</h5>
            {{jalur.keterangan}}
            <table class="table table-bordered" v-if="jalur.komponen.length">
              <thead>
                <tr>
                  <th class="text-center">NO</th>
                  <th class="text-center">KOMPONEN</th>
                  <th class="text-center">BOBOT</th>
                  <th class="text-center">SKOR MAKSIMUM</th>
                  <th class="text-center">BUKTI FISIK</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(komponen, key) in jalur.komponen">
                  <td class="text-center">{{key + 1}}</td>
                  <td>{{komponen.nama}}</td>
                  <td class="text-center">{{(komponen.bobot) ? komponen.bobot+' %' : '-'}}</td>
                  <td class="text-center">{{(komponen.skor) ? komponen.skor : '-'}}</td>
                  <td>{{komponen.bukti}}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div-->
      <template v-if="!profil_pengguna">
        <b-alert show class="text-center">
            <h3>Pendaftaran bisa dilakukan setelah Anda melengkapi semua data! <b-badge variant="danger" to="/profil">Lengkapi Data Anda Disini</b-badge></h3>
        </b-alert>
      </template>
      <template v-else>
        <b-alert variant="success" show><h3>Data anda sudah lengkap, silahkan Pilih Jalur Pendaftraan!</h3></b-alert>
      </template>
      <template v-if="sekolah_pilihan.length">
        <div class="main-card card mb-3">
          <div class="card-header text-center">
            Riwayat Pendaftaran Anda
          </div>
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="text-center" width="10%">Pilihan Ke-</th>
                  <th class="text-center" width="40%">Sekolah Tujuan</th>
                  <th class="text-center" width="20%">Jalur</th>
                  <th class="text-center" width="20%">Status Verifikasi</th>
                  <th class="text-center" width="10%">Cetak Bukti</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(sekolah, key) in sekolah_pilihan">
                  <td class="text-center">{{sekolah.pilihan_ke}}</td>
                  <td>{{sekolah.sekolah.nama}} ({{sekolah.sekolah.npsn}})</td>
                  <td class="text-center">{{sekolah.jalur.nama}}</td>
                  <td class="text-center">
                    <div class="badge badge-warning" v-if="!sekolah.status">Belum diverifikasi</div>
                    <div class="badge badge-success" v-if="sekolah.status && sekolah.status.nama == 'Terima'">Terverifikasi</div>
                    <!--div class="badge badge-danger" @click="viewBukti(sekolah.sekolah_pilihan_id)" v-if="sekolah.status && sekolah.status.nama == 'Tolak'">Ditolak</div>
                    <div class="badge badge-info" @click="viewBukti(sekolah.sekolah_pilihan_id)" v-if="sekolah.status && sekolah.status.nama == 'Perbaikan'">Perbaikan</div-->
                    <b-button size="sm" squared variant="info" @click="viewBukti(sekolah.sekolah_pilihan_id)" v-if="sekolah.status && sekolah.status.nama == 'Perbaikan'">Perbaikan</b-button>
                    <b-button size="sm" squared variant="danger" @click="viewBukti(sekolah.sekolah_pilihan_id)" v-if="sekolah.status && sekolah.status.nama == 'Tolak'">Ditolak</b-button>
                  </td>
                  <td class="text-center">
                    <b-button size="sm" squared variant="success" @click="cetakBukti(sekolah.sekolah_pilihan_id)" v-if="sekolah.status"> <i class="fas fa-print"></i></b-button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>  
      </template>
      <div class="main-card card mb-3">
        <div class="card-header">
          Profil Anda
          <div class="btn-actions-pane-right">
            <b-button size="sm" block squared variant="success" to="/profil">Lengkapi Profil Pengguna</b-button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-6">
              <table class="table">
                <tr>
                  <td>Nama Lengkap</td>
                  <td>: {{ nama_lengkap }}</td>
                </tr>
                <tr>
                  <td>NIK</td>
                  <td>: {{ nik }}</td>
                </tr>
                <tr>
                  <td>Tempat, Tanggal Lahir</td>
                  <td>: {{ tempat_tanggal_lahir }}</td>
                </tr>
                <tr>
                  <td>Jenis Kelamin</td>
                  <td>: {{ jenis_kelamin }}</td>
                </tr>
                <tr>
                  <td>Agama</td>
                  <td>: {{ agama }}</td>
                </tr>
                <tr>
                  <td>Nomor HP</td>
                  <td>: {{ nomor_hp }}</td>
                </tr>
                <tr>
                  <td>Nama Orang Tua/Wali</td>
                  <td>: {{ nama_ortu }}</td>
                </tr>
                <tr>
                  <td>Tempat Tinggal</td>
                  <td>: {{ tempat_tinggal }}</td>
                </tr>
              </table>
            </div>
            <div class="col-lg-6">
              <table class="table">
                <tr>
                  <td>Agama</td>
                  <td>: {{ agama }}</td>
                </tr>
                <tr>
                  <td>Alamat</td>
                  <td>: {{ alamat }}</td>
                </tr>
                <tr>
                  <td>RT/RW</td>
                  <td>: {{ rt_rw }}</td>
                </tr>
                <tr>
                  <td>Desa/Kelurahan</td>
                  <td>: {{ desa }}</td>
                </tr>
                <tr>
                  <td>Kecamatan</td>
                  <td>: {{ kecamatan }}</td>
                </tr>
                <tr>
                  <td>Kabupaten</td>
                  <td>: {{ kabupaten }}</td>
                </tr>
                <tr>
                  <td>Provinsi</td>
                  <td>: {{ provinsi }}</td>
                </tr>
                <tr>
                  <td>Kebutuhan Khusus</td>
                  <td>: {{ kebutuhan_khusus }}</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="content" v-if="hasRole('sekolah')">
      <template v-if="user.sekolah && user.sekolah.bentuk_pendidikan_id == 5">
        <div class="row">
          <div class="col-lg-6 col-xl-4">
            <div class="card mb-3 widget-content bg-night-fade">
              <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                  <div class="widget-heading">Jumlah Pendaftar Jalur Zonasi</div>
                </div>
                <div class="widget-content-right">
                  <div class="widget-numbers text-white">
                    <span>{{ jml_pendaftar_zonasi }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-xl-4">
            <div class="card mb-3 widget-content bg-arielle-smile">
              <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                  <div class="widget-heading">Jumlah Pendaftar Jalur Afirmasi</div>
                </div>
                <div class="widget-content-right">
                  <div class="widget-numbers text-white">
                    <span>{{ jml_pendaftar_afirmasi }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-xl-4">
            <div class="card mb-3 widget-content bg-happy-green">
              <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                  <div class="widget-heading">
                    Jumlah Pendaftar Jalur Perpindahan Tugas orang Tua
                  </div>
                </div>
                <div class="widget-content-right">
                  <div class="widget-numbers text-warning">
                    <span>{{ jml_pendaftar_ortu }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="main-card mb-3 card">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="text-lg text-center">Statistik Pendaftar</div>
                <div class="chartdiv" id="chartSD" ref="chartSD" style="width: 100%; height: 500px"></div>
              </div>
            </div>
          </div>
        </div>
      </template>
      <template v-else>
        <div class="row">
          <div class="col-lg-6 col-xl-3">
            <div class="card mb-3 widget-content bg-night-fade">
              <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                  <div class="widget-heading">Jumlah Pendaftar Jalur Zonasi</div>
                </div>
                <div class="widget-content-right">
                  <div class="widget-numbers text-white">
                    <span>{{ jml_pendaftar_zonasi }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-xl-3">
            <div class="card mb-3 widget-content bg-arielle-smile">
              <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                  <div class="widget-heading">Jumlah Pendaftar Jalur Afirmasi</div>
                </div>
                <div class="widget-content-right">
                  <div class="widget-numbers text-white">
                    <span>{{ jml_pendaftar_afirmasi }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-xl-3">
            <div class="card mb-3 widget-content bg-happy-green">
              <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                  <div class="widget-heading">
                    Jumlah Pendaftar Jalur Perpindahan Tugas orang Tua
                  </div>
                </div>
                <div class="widget-content-right">
                  <div class="widget-numbers text-warning">
                    <span>{{ jml_pendaftar_ortu }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-xl-3">
            <div class="card mb-3 widget-content bg-premium-dark">
              <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                  <div class="widget-heading">
                    Jumlah Pendaftar Jalur Prestasi
                  </div>
                </div>
                <div class="widget-content-right">
                  <div class="widget-numbers text-warning">
                    <span>{{ jml_pendaftar_prestasi }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="main-card mb-3 card">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="text-lg text-center">Statistik Pendaftar</div>
                <div class="chartdiv" id="chartSMP" ref="chartSMP" style="width: 100%; height: 500px"></div>
              </div>
            </div>
          </div>
        </div>
      </template>
    </section>
    <my-loader />
    <b-modal ref="bukti" hide-footer title="Detil Dokumen" size="lg">
      <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th>Nama Dokumen</th>
              <th class="text-center">Status</th>
              <th class="text-center">Keterangan</th>
            </tr>
          </thead>
          <tbody>
            <template v-if="all_dokumen.length">
              <tr v-for="(dokumen, key) in all_dokumen">
                <td class="text-center">{{key + 1}}</td>
                <td>{{dokumen.komponen.nama}}</td>
                <td class="text-center">{{dokumen.status.nama}}</td>
                <td>{{dokumen.catatan}}</td>
              </tr>
            </template>
            <template v-else>
              <tr>
                <td colspan="4" class="text-center">Tidak ada data untuk ditampilkan</td>
              </tr>
            </template>
          </tbody>
        </table>
    </b-modal>
  </div>
</template>
<style type="text/css">
.leaflet-popup-close-button {
  display: none;
}
</style>
<script>
/* Imports */
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
//import am4themes_material from "@amcharts/amcharts4/themes/material";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";
import axios from "axios"; //IMPORT AXIOS
import moment from 'moment'
export default {
  //KETIKA COMPONENT INI DILOAD
  created() {
    this.$loading(true)
    //MAKA AKAN MENJALANKAN FUNGSI BERIKUT
    this.loadPostsData();
  },
  data() {
    /*
     */
    return {
      user: user,
      jml_sd: 0,
      jml_smp: 0,
      jml_pendaftar_sd: 0,
      jml_pendaftar_smp: 0,
      
      jml_pendaftar_zonasi: 0,
      jml_pendaftar_afirmasi: 0,
      jml_pendaftar_ortu: 0,
      jml_pendaftar_prestasi: 0,
      alamat: null,
      bujur: null,
      pendaftar: null,
      all_jalur: [],
      jenjang_sd : false,
      nama_lengkap: '-',
      nik: '-',
      jenis_kelamin: '-',
      desa: '',
      kecamatan: '-',
      kabupaten: '-',
      provinsi: '-',
      rt_rw: '-',
      agama: '-',
      nomor_hp: '-',
      tempat_tanggal_lahir: '-',
      nama_ortu: '-',
      kebutuhan_khusus: '-',
      tempat_tinggal: '-',
      agama: '-',
      profil_pengguna: 1,
      sekolah_pilihan: [],
      all_dokumen: [],
    };
  },
  /*
    this.$router.go({
                        name: 'proses_pengisian',
                        params: {
                            id: new_page
                        }
                    })
    ,*/
  methods: {
    downloadRekap(){
      Swal.fire({
        title: "Download Rekapitulasi",
        text: "Silahkan Pilih Format",
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "EXCEL",
        cancelButtonText: "PDF",
      }).then((result) => {
        if (result.value) {
          window.open('/cetak/excel', '_blank')
        } else {
          window.open('/cetak/pdf', '_blank')
        }
      });
    },
    viewBukti(sekolah_pilihan_id){
      console.log(sekolah_pilihan_id);
      axios.post(`/api/dokumen`, {
        sekolah_pilihan_id: sekolah_pilihan_id,
      }).then((response) => {
        let getData = response.data.data
        this.all_dokumen = getData.dokumen
        this.$refs['bukti'].show()
      })
    },
    cetakBukti(sekolah_pilihan_id){
      window.open('/cetak/pendaftaran/'+sekolah_pilihan_id, '_blank')
    },
    goToForm() {
      if (this.alamat && this.bujur) {
        this.$router.push({ path: "pendaftaran" });
      } else {
        console.log(this.alamat);
        if (!this.alamat) {
          Swal.fire({
            title: "Profil Pengguna Belum Lengkap",
            text: "Silahkan lengkapi dulu profil pengguna!",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Lengkapi Sekarang!",
            cancelButtonText: "Lengkapi Nanti",
          }).then((result) => {
            if (result.value) {
              this.$router.push({ path: "profil" });
            }
          });
        }
      }
    },
    createChart(chartID, chartData) {
      am4core.useTheme(am4themes_animated);
      // Themes end

      //let chart = am4core.create(chartID, am4charts.PieChart3D);
      let chart = am4core.create(chartID, am4charts.XYChart);
      chart.colors.step = 2;
      chart.legend = new am4charts.Legend();
      chart.legend.position = "top";
      chart.legend.paddingBottom = 20;
      chart.legend.labels.template.maxWidth = 95;

      let xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      xAxis.dataFields.category = "jalur";
      xAxis.renderer.cellStartLocation = 0.1;
      xAxis.renderer.cellEndLocation = 0.9;
      xAxis.renderer.grid.template.location = 0;

      let yAxis = chart.yAxes.push(new am4charts.ValueAxis());
      yAxis.min = 0;
      if (chartID == "chartSD") {
        chart.data = [
          {
            jalur: "Zonasi",
            pendaftar_l: chartData.pendaftar_zonasi_sd_l,
            pendaftar_p: chartData.pendaftar_zonasi_sd_p,
          },
          {
            jalur: "Afirmasi",
            pendaftar_l: chartData.pendaftar_afirmasi_sd_l,
            pendaftar_p: chartData.pendaftar_afirmasi_sd_p,
          },
          {
            jalur: "Perpindahan Tugas orang Tua/Wali",
            pendaftar_l: chartData.pendaftar_ortu_sd_l,
            pendaftar_p: chartData.pendaftar_ortu_sd_p,
          },
        ];
      } else {
        chart.data = [
          {
            jalur: "Zonasi",
            pendaftar_l: chartData.pendaftar_zonasi_smp_l,
            pendaftar_p: chartData.pendaftar_zonasi_smp_p,
          },
          {
            jalur: "Afirmasi",
            pendaftar_l: chartData.pendaftar_afirmasi_smp_l,
            pendaftar_p: chartData.pendaftar_afirmasi_smp_p,
          },
          {
            jalur: "Perpindahan Tugas orang Tua/Wali",
            pendaftar_l: chartData.pendaftar_ortu_smp_l,
            pendaftar_p: chartData.pendaftar_ortu_smp_p,
          },
          {
            jalur: "Prestasi",
            pendaftar_l: chartData.pendaftar_prestasi_smp_l,
            pendaftar_p: chartData.pendaftar_prestasi_smp_p,
          },
        ];
      }
      function createSeries(value, name) {
        let series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = value;
        series.dataFields.categoryX = "jalur";
        series.name = name;

        series.events.on("hidden", arrangeColumns);
        series.events.on("shown", arrangeColumns);

        let bullet = series.bullets.push(new am4charts.LabelBullet());
        bullet.interactionsEnabled = false;
        bullet.dy = 30;
        bullet.label.text = "{valueY}";
        bullet.label.fill = am4core.color("#ffffff");

        return series;
      }
      createSeries("pendaftar_l", "Laki-laki");
      createSeries("pendaftar_p", "Perempuan");
      function arrangeColumns() {
        let series = chart.series.getIndex(0);

        let w =
          1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
        if (series.dataItems.length > 1) {
          let x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
          let x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
          let delta = ((x1 - x0) / chart.series.length) * w;
          if (am4core.isNumber(delta)) {
            let middle = chart.series.length / 2;

            let newIndex = 0;
            chart.series.each(function (series) {
              if (!series.isHidden && !series.isHiding) {
                series.dummyData = newIndex;
                newIndex++;
              } else {
                series.dummyData = chart.series.indexOf(series);
              }
            });
            let visibleCount = newIndex;
            let newMiddle = visibleCount / 2;

            chart.series.each(function (series) {
              let trueIndex = chart.series.indexOf(series);
              let newIndex = series.dummyData;

              let dx = (newIndex - trueIndex + middle - newMiddle) * delta;

              series.animate(
                { property: "dx", to: dx },
                series.interpolationDuration,
                series.interpolationEasing
              );
              series.bulletsContainer.animate(
                { property: "dx", to: dx },
                series.interpolationDuration,
                series.interpolationEasing
              );
            });
          }
        }
      }
    },
    loadPostsData() {
      axios
        .post(`/api/dashboard`, {
          user_id: user.user_id,
        })
        .then((response) => {
          this.loading = false;
          let getData = response.data.data;
          if (!getData) {
            return false;
          }
          this.sekolah_pilihan = (getData.pendaftar) ? getData.pendaftar.sekolah_pilihan : []
          this.jenjang_sd = (getData.bentuk_pendidikan_id == 5) ? true : false
          this.all_jalur = response.data.jalur
          this.alamat = getData.alamat
          this.nama_lengkap = getData.name
          this.nik = getData.username
          this.jenis_kelamin = (getData.jenis_kelamin === "L") ? "Laki-laki" : "Perempuan"
          this.desa = getData.desa
          this.kecamatan = getData.kecamatan
          this.kabupaten = getData.kabupaten
          this.provinsi = getData.provinsi
          this.rt_rw = (getData.rt) ? getData.rt+'/'+getData.rw : '-'
          this.agama = (getData.agama) ? getData.agama.nama : '-'
          this.tempat_tinggal = (getData.jenis_tinggal) ? getData.jenis_tinggal.nama : '-'
          this.nomor_hp = getData.nomor_hp
          this.tempat_tanggal_lahir = (getData.tempat_lahir) ? getData.tempat_lahir+', '+moment(String(getData.tanggal_lahir)).format('DD MMMM YYYY') : '-'
          this.nama_ortu = getData.nama_ortu
          if(getData.bentuk_pendidikan_id == 5){
            this.profil_pengguna = getData.bujur
          } else {
            this.profil_pengguna = (getData.bujur && getData.nilai.length) ? 1 : 0
          }
          /*if(getData.bentuk_pendidikan_id == 6){
            if(getData.bujur && getData.ijazah){
              this.profil_pengguna = 1
            } else {
              this.profil_pengguna = null
            }
          } else {
            this.profil_pengguna = getData.bujur
          }*/
          let tempKhusus = []
          if(getData.kebutuhan_khusus){
            $.each(getData.kebutuhan_khusus, function (key, value) {
              tempKhusus[key] = value.nama
            })
          }
          this.kebutuhan_khusus = (tempKhusus.length) ? tempKhusus.join(', ') : '-'
          this.bujur = getData.bujur
          this.pendaftar = getData.pendaftar;
          this.jml_sd = getData.jml_sekolah ? getData.jml_sekolah.jml_sd : 0;
          this.jml_smp = getData.jml_sekolah ? getData.jml_sekolah.jml_smp : 0;
          this.jml_pendaftar_sd = getData.jml_pendaftar
            ? getData.jml_pendaftar.pendaftar_sd
            : 0;
          this.jml_pendaftar_smp = getData.jml_pendaftar
            ? getData.jml_pendaftar.pendaftar_smp
            : 0;
          let vm = this;
          let chartSD = $("#chartSD");
          let chartSMP = $("#chartSMP");
          if (chartSD.length) {
            this.jml_pendaftar_zonasi = getData.jml_pendaftar
              ? getData.jml_pendaftar.pendaftar_zonasi_sd_l +
                getData.jml_pendaftar.pendaftar_zonasi_sd_p
              : 0;
            this.jml_pendaftar_afirmasi = getData.jml_pendaftar
              ? getData.jml_pendaftar.pendaftar_afirmasi_sd_l +
                getData.jml_pendaftar.pendaftar_afirmasi_sd_p
              : 0;
            this.jml_pendaftar_ortu = getData.jml_pendaftar
              ? getData.jml_pendaftar.pendaftar_ortu_sd_l +
                getData.jml_pendaftar.pendaftar_ortu_sd_p
              : 0;
            vm.createChart("chartSD", getData.jml_pendaftar);
          }
          if (chartSMP.length) {
            this.jml_pendaftar_zonasi = getData.jml_pendaftar
              ? getData.jml_pendaftar.pendaftar_zonasi_smp_l +
                getData.jml_pendaftar.pendaftar_zonasi_smp_p
              : 0;
            this.jml_pendaftar_afirmasi = getData.jml_pendaftar
              ? getData.jml_pendaftar.pendaftar_afirmasi_smp_l +
                getData.jml_pendaftar.pendaftar_afirmasi_smp_p
              : 0;
            this.jml_pendaftar_ortu = getData.jml_pendaftar
              ? getData.jml_pendaftar.pendaftar_ortu_smp_l +
                getData.jml_pendaftar.pendaftar_ortu_smp_p
              : 0;
            this.jml_pendaftar_prestasi = getData.jml_pendaftar
              ? getData.jml_pendaftar.pendaftar_prestasi_smp_l +
                getData.jml_pendaftar.pendaftar_prestasi_smp_p
              : 0;
            vm.createChart("chartSMP", getData.jml_pendaftar);
          }
          this.$loading(false)
        });
    },
  },
};
</script>
