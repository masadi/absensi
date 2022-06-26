<template>
  <div>
    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div>Ganti Password</div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="main-card mb-3 card">
        <div class="card-body">
          <div class="alert alert-danger" v-show="errors">
            <h5><i class="icon fas fa-ban"></i> Isian Tidak Valid!</h5>
            <ul>
              <li v-for="(error, key) in errors">
                {{ error }}
              </li>
            </ul>
          </div>

          <label for="current-password" class="col-form-label"
            >Sandi Saat Ini (Biarkan kosong jika tidak ingin merubah)</label
          >
          <div class="form-group">
            <input
              v-model="form.current_password"
              type="password"
              id="current-password"
              name="current_password"
              class="form-control"
              :class="{ 'is-invalid': form.errors.has('current_password') }"
              placeholder="Sandi saat ini"
              autocomplete="new-password"
            />
            <has-error :form="form" field="current_password"></has-error>
          </div>
          <label for="password" class="col-form-label">Sandi Baru</label>
          <div class="form-group">
            <input
              v-model="form.password"
              type="password"
              id="password"
              name="password"
              class="form-control"
              :class="{ 'is-invalid': form.errors.has('password') }"
              placeholder="Sandi baru"
              autocomplete="password"
            />
            <has-error :form="form" field="password"></has-error>
          </div>
          <label for="password_confirmation" class="col-form-label"
            >Konfirmasi Sandi</label
          >
          <div class="form-group">
            <input
              v-model="form.password_confirmation"
              type="password"
              id="password_confirmation"
              name="password_confirmation"
              class="form-control"
              :class="{ 'is-invalid': form.errors.has('password_confirmation') }"
              placeholder="Ketik ulang kata sandi baru"
              autocomplete="password_confirmation"
            />
            <has-error :form="form" field="password_confirmation"></has-error>
          </div>
        </div>
        <div class="card-footer">
          <b-button squared variant="success" size="lg" v-on:click="updatePassword">
            <b-spinner small v-show="show_spinner"></b-spinner>
            <span class="sr-only" v-show="show_spinner">Loading...</span>
            <span v-show="show_text">Perbaharui Data</span>
          </b-button>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import axios from "axios"; //IMPORT AXIOS
export default {
  data() {
    return {
      form: new Form({
        user_id: user.user_id,
        current_password: "",
        password: "",
        password_confirmation: "",
      }),
      errors: null,
      show_spinner: false,
      show_text: true,
    };
  },
  methods: {
    updatePassword() {
      this.form
        .post(`/api/users/update-password`)
        .then((response) => {
          Swal.fire(response.title, response.text, response.icon).then(() => {
            this.loadPostsData();
          });
        })
        .catch((error) => {
          if (error.response) {
            var errors = [];
            $.each(error.response.data.errors, function (key, value) {
              errors.push(value[0]);
            });
            this.errors = errors;
            this.show_spinner = false;
            this.show_text = true;
          }
        });
    },
  },
};
</script>
