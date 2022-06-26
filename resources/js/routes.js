import VueRouter from 'vue-router';


let routes = [{
        path: '/beranda',
        name: 'beranda',
        component: require('./views/dashboard').default
    },
    {
        path: '/sekolah',
        name: 'sekolah',
        component: require('./views/referensi/sekolah').default
    },
    {
        path: '/pendaftar',
        name: 'pendaftar',
        component: require('./views/pendaftar').default
    },
    {
        path: '/pendaftar/tambah',
        name: 'tambah_pendaftar',
        component: require('./views/tambah_pendaftar').default
    },
    {
        path: '/zonasi/informasi',
        name: 'zonasi_informasi',
        meta: 'zonasi',
        component: require('./views/zonasi_informasi').default
    },
    {
        path: '/zonasi/daftar',
        name: 'zonasi_daftar',
        meta: 'zonasi',
        component: require('./views/zonasi_daftar').default
    },
    {
        path: '/zonasi/seleksi/:bentuk_pendidikan_id?',
        name: 'zonasi_seleksi',
        meta: 'zonasi',
        component: require('./views/zonasi_seleksi').default
    },
    {
        path: '/afirmasi/informasi',
        name: 'afirmasi_informasi',
        meta: 'afirmasi',
        component: require('./views/afirmasi_informasi').default
    },
    {
        path: '/afirmasi/daftar',
        name: 'afirmasi_daftar',
        meta: 'afirmasi',
        component: require('./views/afirmasi_daftar').default
    },
    {
        path: '/afirmasi/seleksi/:bentuk_pendidikan_id?',
        name: 'afirmasi_seleksi',
        meta: 'afirmasi',
        component: require('./views/afirmasi_seleksi').default
    },
    {
        path: '/prestasi/informasi',
        name: 'prestasi_informasi',
        meta: 'prestasi',
        component: require('./views/prestasi_informasi').default
    },
    {
        path: '/prestasi/daftar',
        name: 'prestasi_daftar',
        meta: 'prestasi',
        component: require('./views/prestasi_daftar').default
    },
    {
        path: '/prestasi/seleksi/:bentuk_pendidikan_id?',
        name: 'prestasi_seleksi',
        meta: 'prestasi',
        component: require('./views/prestasi_seleksi').default
    },
    {
        path: '/perpindahan/informasi',
        name: 'perpindahan_informasi',
        meta: 'perpindahan',
        component: require('./views/perpindahan_informasi').default
    },
    {
        path: '/perpindahan/daftar',
        name: 'perpindahan_daftar',
        meta: 'perpindahan',
        component: require('./views/perpindahan_daftar').default
    },
    {
        path: '/perpindahan/seleksi/:bentuk_pendidikan_id?',
        name: 'perpindahan_seleksi',
        meta: 'perpindahan',
        component: require('./views/perpindahan_seleksi').default
    },
    {
        path: '/pengguna',
        name: 'pengguna',
        component: require('./views/referensi/users').default
    },
    {
        path: '/operator',
        name: 'operator',
        component: require('./views/referensi/operator').default
    },
    {
        path: '/profil',
        name: 'profil',
        component: require('./views/profile').default
    },
    {
        path: '/ganti-password',
        name: 'password',
        component: require('./views/ganti-password').default
    },
    {
        path: '/unduhan',
        name: 'unduhan',
        component: require('./views/unduhan').default
    },
];

const router = new VueRouter({
    path: '/app',
    component: require('./views/dashboard').default,
    base: '/app/',
    mode: 'history',
    routes,
    linkActiveClass: 'mm-active',
    user: user,
});
/*router.beforeResolve((to, from, next) => {
    // If this isn't an initial page load.
    if (to.name) {
        $('.fade').removeClass('show').addClass('out');
        // Start the route progress bar.
        NProgress.start()
    }
    next()
})

router.afterEach((to, from) => {
    // Complete the animation of the route progress bar.
    //NProgress.done()
    //$('.fade').removeClass('out').addClass('show');
    setTimeout(function() {
        NProgress.done();
        $('.fade').removeClass('out').addClass('show');
    }, 1000);
})*/
export default router