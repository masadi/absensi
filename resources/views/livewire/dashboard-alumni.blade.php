<div>
    <div id="user-profile">
  <!-- profile header -->
  <div class="row">
    <div class="col-12">
      <div class="card profile-header mb-2">
        <!-- profile cover photo -->
        <img
          class="card-img-top"
          src="{{asset('images/profile/user-uploads/timeline.jpg')}}"
          alt="User Profile Image"
        />
        <!--/ profile cover photo -->

        <div class="position-relative">
          <!-- profile picture -->
          <div class="profile-img-container d-flex align-items-center">
            <div class="profile-img">
              <img
                src="{{ ($user->profile_photo_url) ? $user->profile_photo_url : asset('images/portrait/small/avatar-s-11.jpg') }}"
                class="rounded img-fluid"
                alt="Card image"
              />
            </div>
            <!-- profile title -->
            <div class="profile-title ms-3">
              <h2 class="text-white">{{$user->name}}</h2>
              <p class="text-white">Alumni {{($user->tahun_lulus) ? 'Tahun Lulus '.$user->tahun_lulus : ''}} {{($user->dpw) ? 'Anggota DPW '.$user->dpw->nama : ''}}</p>
            </div>
          </div>
        </div>

        <!-- tabs pill -->
        <div class="profile-header-nav mb-4">
        </div>
      </div>
    </div>
  </div>
  <!--/ profile header -->

  <!-- profile info section -->
  <section id="profile-info">
    <div class="row">
      <!-- left profile info section -->
      <div class="col-lg-4 col-12 order-2 order-lg-1">
        <!-- about -->
        <div class="card">
          <div class="card-body">
            <h5 class="mb-75">Tentang</h5>
            <p class="card-text">
              {{($user->tentang) ? $user->tentang : '-'}}
            </p>
            <div class="mt-2">
              <h5 class="mb-75">Terverikasi:</h5>
              <p class="card-text">{{$user->updated_at->isoFormat('dddd, D MMMM Y')}}</p>
            </div>
            <div class="mt-2">
              <h5 class="mb-75">Alamat:</h5>
              <p class="card-text">{{($user->alamat_rumah) ? $user->alamat_rumah : '-'}}</p>
            </div>
            <div class="mt-2">
              <h5 class="mb-75">Email:</h5>
              <p class="card-text">{{$user->email}}</p>
            </div>
            <div class="mt-2">
              <h5 class="mb-50">No. Handphone</h5>
              <p class="card-text mb-0">{{($user->nomor_handphone) ? $user->nomor_handphone : '-'}}</p>
            </div>
          </div>
        </div>
        <!--/ about -->

        <!-- suggestion pages -->
        <div class="card">
          <div class="card-body profile-suggestion">
            <h5 class="mb-2">Alumni di DPW Anda</h5>
            <!-- user suggestions -->
            <div class="d-flex justify-content-start align-items-center mb-1">
              <div class="avatar me-1">
                <img src="{{asset('images/avatars/12-small.png')}}" alt="avatar img" height="40" width="40" />
              </div>
              <div class="profile-user-info">
                <h6 class="mb-0">Peter Reed</h6>
                <small class="text-muted">Company</small>
              </div>
              <div class="profile-star ms-auto"><i data-feather="star" class="font-medium-3"></i></div>
            </div>
            <!-- user suggestions -->
            <div class="d-flex justify-content-start align-items-center mb-1">
              <div class="avatar me-1">
                <img src="{{asset('images/avatars/1-small.png')}}" alt="avatar" height="40" width="40" />
              </div>
              <div class="profile-user-info">
                <h6 class="mb-0">Harriett Adkins</h6>
                <small class="text-muted">Company</small>
              </div>
              <div class="profile-star ms-auto"><i data-feather="star" class="font-medium-3"></i></div>
            </div>
            <!-- user suggestions -->
            <div class="d-flex justify-content-start align-items-center mb-1">
              <div class="avatar me-1">
                <img src="{{asset('images/avatars/10-small.png')}}" alt="avatar" height="40" width="40" />
              </div>
              <div class="profile-user-info">
                <h6 class="mb-0">Juan Weaver</h6>
                <small class="text-muted">Company</small>
              </div>
              <div class="profile-star ms-auto"><i data-feather="star" class="font-medium-3"></i></div>
            </div>
            <!-- user suggestions -->
            <div class="d-flex justify-content-start align-items-center mb-1">
              <div class="avatar me-1">
                <img src="{{asset('images/avatars/3-small.png')}}" alt="avatar img" height="40" width="40" />
              </div>
              <div class="profile-user-info">
                <h6 class="mb-0">Claudia Chandler</h6>
                <small class="text-muted">Company</small>
              </div>
              <div class="profile-star ms-auto"><i data-feather="star" class="font-medium-3"></i></div>
            </div>
            <!-- user suggestions -->
            <div class="d-flex justify-content-start align-items-center mb-1">
              <div class="avatar me-1">
                <img src="{{asset('images/avatars/5-small.png')}}" alt="avatar img" height="40" width="40" />
              </div>
              <div class="profile-user-info">
                <h6 class="mb-0">Earl Briggs</h6>
                <small class="text-muted">Company</small>
              </div>
              <div class="profile-star ms-auto">
                <i data-feather="star" class="profile-favorite font-medium-3"></i>
              </div>
            </div>
            <!-- user suggestions -->
            <div class="d-flex justify-content-start align-items-center">
              <div class="avatar me-1">
                <img src="{{asset('images/avatars/6-small.png')}}" alt="avatar img" height="40" width="40" />
              </div>
              <div class="profile-user-info">
                <h6 class="mb-0">Jonathan Lyons</h6>
                <small class="text-muted">Beauty Store</small>
              </div>
              <div class="profile-star ms-auto"><i data-feather="star" class="font-medium-3"></i></div>
            </div>
          </div>
        </div>
        <!--/ suggestion pages -->

        <!-- twitter feed card -->
        <div class="card">
          <div class="card-body">
            <h5>Alumni Seangkatan Anda</h5>
            <div class="d-flex justify-content-start align-items-center mb-1">
                <div class="avatar me-1">
                  <img src="{{asset('images/avatars/12-small.png')}}" alt="avatar img" height="40" width="40" />
                </div>
                <div class="profile-user-info">
                  <h6 class="mb-0">Peter Reed</h6>
                  <small class="text-muted">Company</small>
                </div>
                <div class="profile-star ms-auto"><i data-feather="star" class="font-medium-3"></i></div>
              </div>
              <div class="d-flex justify-content-start align-items-center mb-1">
                <div class="avatar me-1">
                  <img src="{{asset('images/avatars/12-small.png')}}" alt="avatar img" height="40" width="40" />
                </div>
                <div class="profile-user-info">
                  <h6 class="mb-0">Peter Reed</h6>
                  <small class="text-muted">Company</small>
                </div>
                <div class="profile-star ms-auto"><i data-feather="star" class="font-medium-3"></i></div>
              </div>
              <div class="d-flex justify-content-start align-items-center mb-1">
                <div class="avatar me-1">
                  <img src="{{asset('images/avatars/12-small.png')}}" alt="avatar img" height="40" width="40" />
                </div>
                <div class="profile-user-info">
                  <h6 class="mb-0">Peter Reed</h6>
                  <small class="text-muted">Company</small>
                </div>
                <div class="profile-star ms-auto"><i data-feather="star" class="font-medium-3"></i></div>
              </div>
              <div class="d-flex justify-content-start align-items-center mb-1">
                <div class="avatar me-1">
                  <img src="{{asset('images/avatars/12-small.png')}}" alt="avatar img" height="40" width="40" />
                </div>
                <div class="profile-user-info">
                  <h6 class="mb-0">Peter Reed</h6>
                  <small class="text-muted">Company</small>
                </div>
                <div class="profile-star ms-auto"><i data-feather="star" class="font-medium-3"></i></div>
              </div>
              <div class="d-flex justify-content-start align-items-center mb-1">
                <div class="avatar me-1">
                  <img src="{{asset('images/avatars/12-small.png')}}" alt="avatar img" height="40" width="40" />
                </div>
                <div class="profile-user-info">
                  <h6 class="mb-0">Peter Reed</h6>
                  <small class="text-muted">Company</small>
                </div>
                <div class="profile-star ms-auto"><i data-feather="star" class="font-medium-3"></i></div>
              </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8 col-12 order-1 order-lg-2">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Riwayat Donasi Anda</h4>
            </div>
          <div class="card-body">
            @livewire('riwayat-donasi')
          </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Kegiatan yang akan Anda hadiri</h4>
            </div>
          <div class="card-body">
            @livewire('akan-hadir')
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-profile.css')) }}">
</div>
