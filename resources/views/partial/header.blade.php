<div class="header">
    <div class="header-left active">
        <a href="/" target="_blank" class="logo logo-normal">
            <img src="{{ asset('asset/img/logo.png') }}" alt="Logo">
        </a>
        <a href="/" target="_blank" class="logo-small">
            <img src="{{ asset('asset/img/logo-icon.png') }}" alt="Logo">
        </a>
        <a href="/" target="_blank" class="dark-logo">
            <img src="{{ asset('asset/img/logo-white.png') }}" alt="Logo">
        </a>
        <a id="toggle_btn" href="javascript:void(0);">
            <i class="ti ti-layout-align-left"></i>
        </a>
    </div>
    <a id="mobile_btn" class="mobile_btn" href="#sidebar">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>
    <div class="header-user">

        <div class="nav user-menu">
            <div class="nav-item nav-search-inputs me-auto">
                @if (Request::is('classroom/detail*'))
                    <h3><span class="ti ti-chalkboard"></span> Ruangan Kelas</h3>
                @endif
                @if (Request::is('quiz*'))
                    <h3><span class="ti ti-chalkboard"></span> Quiz</h3>
                @endif

            </div>

            <div class="me-2">
                <a href="#" class="btn btn-outline-light fw-normal bg-white d-flex align-items-center p-2" >
                    <i class="ti ti-calendar-due me-1"></i>Tahun Ajaran : {{ $tahunAjaran }}
                </a>

            </div>


            <div class="pe-1">
              <a data-bs-toggle="modal" data-bs-target="#changePassword" class="btn btn-outline-light bg-white  position-relative "><span class="ti ti-key"></span> Ubah Password</a>
            </div>
               {{-- Night Mode --}}
               <div class="pe-1">
                <a href="#" id="dark-mode-toggle" class="dark-mode-toggle activate btn btn-outline-light bg-white btn-icon me-1">
                    <i class="ti ti-moon"></i>
                </a>
                <a href="#" id="light-mode-toggle" class="dark-mode-toggle btn btn-outline-light bg-white btn-icon me-1">
                    <i class="ti ti-brightness-up"></i>
                </a>
            </div>
            <div class="pe-1">
                <a href="#" class="btn btn-outline-light bg-white btn-icon me-1" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Cek Update" data-bs-original-title="Cek Update!">
                    <i class="ti ti-refresh"></i>
                </a>
            </div>
            <div class="pe-1">
                <a href="#" class="btn btn-outline-light bg-white btn-icon me-1" id="btnFullscreen">
                    <i class="ti ti-maximize"></i>
                </a>
            </div>
            {{-- user --}}

            {{-- @foreach ( auth()->user()->load('gtk') as  $item) --}}
            <div class="d-flex align-items-center">
                <div class="dropdown ms-1">
                    <a href="javascript:void(0);" class="dropdown-toggle d-flex align-items-center"
                        data-bs-toggle="dropdown">
                        <span class="avatar avatar-md rounded">
                    {{-- default --}}

                        {{-- user siswa --}}
                        @if(auth()->user()->role == "siswa")
                         @if(Auth::user()->student == NULL)
                            <img src='{{ asset('asset/img/user-default.jpg')  }}' alt='Img' class='img-fluid'>
                         @else
                            @if(Auth::user()->student->foto == "" )
                                <img src='{{ asset('asset/img/user-default.jpg')  }}' alt='Img' class='img-fluid'>
                            @else
                                <img src="{{ asset('storage/'. Auth::user()->student->foto) }}" alt='Img' class='img-fluid'>
                            @endif
                         @endif
                        @endif

                       @if(auth()->user()->role == "guru")
                         @if(Auth::user()->gtk == NULL)
                            <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                         @else
                            @if(Auth::user()->gtk->gambar == "" )
                                <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                            @else
                                <img src="{{ asset('storage/'. Auth::user()->gtk->gambar) }}" alt='Img' class='img-fluid'>
                            @endif
                         @endif
                        @endif

                        @if( auth()->user()->role == "walikelas")
                            @if(Auth::user()->gtk == NULL)
                                <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                            @else
                            @if(Auth::user()->gtk->gambar == "" )
                                <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                            @else
                                <img src="{{ asset('/storage' . Auth::user()->gtk->gambar ) }}" alt='Img' class='img-fluid'>
                            @endif
                            @endif
                        @endif


                        @if(auth()->user()->role == "admin" || auth()->user()->role == "superadmin" )
                            @if(Auth::user()->gtk)
                            <img src="{{ asset('storage/'. Auth::user()->gtk->gambar) }}" alt='Img' class='img-fluid'>
                            @else
                            <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                            @endif
                        @endif

                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="d-block">
                            <div class="d-flex align-items-center p-2">
                                <span class="avatar avatar-md me-2 online avatar-rounded">

                                    @if(auth()->user()->role == "siswa")
                                    @if(Auth::user()->student == NULL)
                                       <img src='{{ asset('asset/img/user-default.jpg')  }}' alt='Img' class='img-fluid'>
                                    @else
                                       @if(Auth::user()->student->foto == "" )
                                           <img src='{{ asset('asset/img/user-default.jpg')  }}' alt='Img' class='img-fluid'>
                                       @else
                                           <img src="{{ asset('storage/'. Auth::user()->student->foto) }}" alt='Img' class='img-fluid'>
                                       @endif
                                    @endif
                                   @endif

                                  @if(auth()->user()->role == "guru")
                                    @if(Auth::user()->gtk == NULL)
                                       <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                                    @else
                                       @if(Auth::user()->gtk->gambar == "" )
                                           <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                                       @else
                                           <img src="{{ asset('storage/' . Auth::user()->gtk->gambar ) }}" alt='Img' class='img-fluid'>
                                       @endif
                                    @endif
                                   @endif

                                   @if( auth()->user()->role == "walikelas")
                                       @if(Auth::user()->gtk == NULL)
                                           <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                                       @else
                                       @if(Auth::user()->gtk->gambar == "" )
                                           <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                                       @else
                                           <img src="{{ asset('storage/' . Auth::user()->gtk->gambar) }}" alt='Img' class='img-fluid'>
                                       @endif
                                       @endif
                                   @endif

                                   @if(auth()->user()->role == "admin" || auth()->user()->role == "superadmin" )
                                        @if(Auth::user()->gtk)
                                        <img src="{{ asset('storage/' . Auth::user()->gtk->gambar) }}" alt='Img' class='img-fluid'>
                                        @else
                                        <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                                        @endif
                                    @endif

                                </span>
                                <div>
                                    <h6 class>{{ auth()->user()->nama }}</h6>
                                    <p class="text-primary mb-0">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                            <hr class="m-0">
                            @if (auth()->user()->role != "superadmin")
                                <a class="dropdown-item d-inline-flex align-items-center p-2" href="{{ route('profileIndex',auth()->user()->nomor) }}">
                                <i class="ti ti-user-circle me-2"></i>Profile Saya</a>
                            @endif

                            <hr class="m-0">
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="sumbit" class="dropdown-item d-inline-flex align-items-center p-2"> <i
                                    class="ti ti-login me-2"></i> Keluar Aplikasi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="dropdown mobile-user-menu">
        <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
            aria-expanded="false"><i class="ti ti-align-justified"></i></a>
        <div class="dropdown-menu dropdown-menu-end">
            <a class="dropdown-item" href="{{ route('profileIndex',auth()->user()->nomor) }}">Profile Saya</a>
            <a class="dropdown-item" href="profile-settings.html">Setelan</a>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="sumbit" class="dropdown-item"> Keluar</button>
            </form>

        </div>
    </div>

</div>

