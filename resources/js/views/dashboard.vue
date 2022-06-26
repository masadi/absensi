<template>
  <div class="no">
    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div>Beranda</div>
        </div>
      </div>
    </div>
    <section class="content" v-if="hasRole('admin')">
      admin
    </section>
    <section class="content" v-if="hasRole('siswa')">
      siswa
    </section>
    <section class="content" v-if="hasRole('ptk')">
      ptk
    </section>
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
