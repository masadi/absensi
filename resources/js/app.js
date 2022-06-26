/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// 1. Comment out this following line:
//window.Vue = require('vue');

// 2. Add below the above commented-out line:
import Vue from 'vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
import VueRouter from "vue-router";

window.Vue = Vue;
Vue.use(VueRouter);
import { HasError, AlertError } from 'vform';
import Multiselect from 'vue-multiselect'
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('multiselect', Multiselect)
import Form from "./utilities/Form";
window.Form = Form;
import router from './routes';
import Swal from 'sweetalert2';
//import CKEditor from '@ckeditor/ckeditor5-vue';
//Vue.use(CKEditor);
import CKEditor from '@ckeditor/ckeditor5-vue';
Vue.use(CKEditor);
//require('select2');
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
window.Swal = Swal;
window.Toast = Toast;

import Paginator from './utilities/Paginator';
Vue.component('paginator', Paginator);
import vSelect from 'vue-select'
Vue.component('v-select', vSelect)

import { SpinnerPlugin } from 'bootstrap-vue'
Vue.use(SpinnerPlugin)
import loader from "vue-ui-preloader";
Vue.use(loader);
import myLoader from './utilities/Loader';
Vue.component('my-loader', myLoader)
import moment from 'moment'
moment.locale('id');
Vue.filter('formatDate', function (value) {
    if (value) {
        return moment(String(value)).format('LL')
    }
});
Vue.filter('tanggalIndo', function (value) {
    if (value) {
        return moment(String(value)).format('DD MMMM YYYY')
    } else {
        return '-'
    }
});
/*import VueGoogleMap from 'vuejs-google-maps'
import 'vuejs-google-maps/dist/vuejs-google-maps.css'

Vue.use(VueGoogleMap, {
    load: {
        apiKey: 'AIzaSyAe53Qdo8xaUonitn-rPErRMchKhPVMndQ',
        libraries: []
    }
})*/
import * as GmapVue from 'gmap-vue'
Vue.use(GmapVue, {
    load: {
      key: 'AIzaSyBjh5tV4UCBXDFtjkPc3lO4uiXB9yzpohI',
      //OLD:AIzaSyBkax_ntJg_RiyRU8XooKtegBFsKqqxvwk
      libraries: 'places', // This is required if you use the Autocomplete plugin
      // OR: libraries: 'places,drawing'
      // OR: libraries: 'places,drawing,visualization'
      // (as you require)
  
      //// If you want to set the version, you can do so:
      // v: '3.26',
    },
  
    //// If you intend to programmatically custom event listener code
    //// (e.g. `this.$refs.gmap.$on('zoom_changed', someFunc)`)
    //// instead of going through Vue templates (e.g. `<GmapMap @zoom_changed="someFunc">`)
    //// you might need to turn this on.
    // autobindAllEvents: false,
  
    //// If you want to manually install components, e.g.
    //// import {GmapMarker} from 'gmap-vue/src/components/marker'
    //// Vue.component('GmapMarker', GmapMarker)
    //// then set installComponents to 'false'.
    //// If you want to automatically install all the components this property must be set to 'true':
    installComponents: true
})
Vue.mixin({
    data: function () {
        return {
            get detilUser() {
                return user;
            },
            user: user,
        }
    },
    methods: {
        hasRole: function (role) {
            for (var i = 0; i < this.user.roles.length; i++) {
                if (this.user.roles[i].name == role) {
                    return true
                }
            }
            return false
        },
    }
})
import VeeValidate from "vee-validate";
Vue.use(VeeValidate, {
    inject: true,
    fieldsBagName: "veeFields",
    errorBagName: "veeErrors"
});
import VueLoading from 'vuejs-loading-plugin'
Vue.use(VueLoading)
new Vue({
    el: '#pmp_smk',
    router,
    /*components: {
        loader: loader,
        'my-loader': myLoader
    },*/
    //detilUser: user
    /*data: {
        loading: true,
    }*/
});