<template>
  <div>
    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div>Informasi Pendaftaran Jalur {{nama_jalur}}</div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="main-card mb-3 card">
        <div class="card-body">
            <h3>Informasi Pendaftaran Jalur {{nama_jalur}}</h3>
            <p>{{keterangan}}</p>
            <table class="table table-bordered" v-if="all_komponen.length">
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
                <tr v-for="(komponen, key) in all_komponen">
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
    </section>
  </div>
</template>
<script>
export default {
  created() {
    this.$loading(true)
    this.loadPostsData();
  },
  data() {
    return {
      nama_jalur: '',
      keterangan: '',
      all_komponen : [],
    };
  },
  methods: {
    loadPostsData() {
      let route = this.$route.meta
      axios.post(`/api/informasi`, {
        user_id: user.user_id,
        tautan: route,
      }).then((response) => {
        this.loading = false;
        let getData = response.data.data;
        if (!getData) {
          return false;
        }
        this.nama_jalur = getData.nama
        this.keterangan = getData.keterangan
        this.all_komponen = getData.komponen
        console.log(this.all_komponen);
        this.$loading(false)
      })
    },
  },
};
</script>
