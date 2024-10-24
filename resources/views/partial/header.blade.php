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
               {{-- <div class="top-nav-search">
                <a href="javascript:void(0);" class="responsive-search">
                    <i class="fa fa-search"></i>
                </a>
                <form action="#" class="dropdown">
                    <div class="searchinputs" id="dropdownMenuClickable">
                        <input type="text" placeholder="Search Menu" name="search" id="a">
                        <div class="search-addon">
                            <button type="submit"><i class="ti ti-command"></i></button>
                        </div>
                    </div>
                </form>
            </div> --}}
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
            {{-- notification --}}
            <div class="pe-1 notification-item" id="notification_item">
                <a href="#" class="btn btn-outline-light bg-white btn-icon position-relative me-1" id="notification_popup">
                    <i class="ti ti-bell"></i>
                    <span class="notification-status-dot"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end notification-dropdown p-4">
                    <div class="d-flex align-items-center justify-content-between border-bottom p-0 pb-3 mb-3">
                        <h4 class="notification-title">Notifications (2)</h4>
                        <div class="d-flex align-items-center">
                            <a href="#" class="text-primary fs-15 me-3 lh-1">Mark all as read</a>
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="bg-white dropdown-toggle" data-bs-toggle="dropdown"><i class="ti ti-calendar-due me-1"></i>Today
                                </a>
                                <ul class="dropdown-menu mt-2 p-3">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">
                                            This Week
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">
                                            Last Week
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">
                                            Last Week
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="noti-content">
                        <div class="d-flex flex-column">
                            <div class="border-bottom mb-3 pb-3">
                                <a href="https://preskool.dreamstechnologies.com/html/template/activities.html">
                                    <div class="d-flex">
                                        <span class="avatar avatar-lg me-2 flex-shrink-0">
                                            <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/profiles/avatar-27.jpg" alt="Profile">
                                        </span>
                                        <div class="flex-grow-1">
                                            <p class="mb-1"><span class="text-dark fw-semibold">Shawn</span>
                                                performance in Math is
                                                below the threshold.</p>
                                            <span>Just Now</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="border-bottom mb-3 pb-3">
                                <a href="https://preskool.dreamstechnologies.com/html/template/activities.html" class="pb-0">
                                    <div class="d-flex">
                                        <span class="avatar avatar-lg me-2 flex-shrink-0">
                                            <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/profiles/avatar-23.jpg" alt="Profile">
                                        </span>
                                        <div class="flex-grow-1">
                                            <p class="mb-1"><span class="text-dark fw-semibold">Sylvia</span> added
                                                appointment on
                                                02:00 PM</p>
                                            <span>10 mins ago</span>
                                            <div class="d-flex justify-content-start align-items-center mt-1">
                                                <span class="btn btn-light btn-sm me-2">Deny</span>
                                                <span class="btn btn-primary btn-sm">Approve</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="border-bottom mb-3 pb-3">
                                <a href="https://preskool.dreamstechnologies.com/html/template/activities.html">
                                    <div class="d-flex">
                                        <span class="avatar avatar-lg me-2 flex-shrink-0">
                                            <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/profiles/avatar-25.jpg" alt="Profile">
                                        </span>
                                        <div class="flex-grow-1">
                                            <p class="mb-1">New student record <span class="text-dark fw-semibold"> George</span> is
                                                created by <span class="text-dark fw-semibold">
                                                    Teressa</span></p>
                                            <span>2 hrs ago</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="border-0 mb-3 pb-0">
                                <a href="https://preskool.dreamstechnologies.com/html/template/activities.html">
                                    <div class="d-flex">
                                        <span class="avatar avatar-lg me-2 flex-shrink-0">
                                            <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/profiles/avatar-01.jpg" alt="Profile">
                                        </span>
                                        <div class="flex-grow-1">
                                            <p class="mb-1">A new teacher record for <span class="text-dark fw-semibold">Elisa</span>
                                            </p>
                                            <span>09:45 AM</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex p-0">
                        <a href="#" class="btn btn-light w-100 me-2">Cancel</a>
                        <a href="https://preskool.dreamstechnologies.com/html/template/activities.html" class="btn btn-primary w-100">View All</a>
                    </div>
                </div>
            </div>
            {{-- message --}}
            <div class="pe-1">

                <a href="https://preskool.dreamstechnologies.com/html/template/chat.html" class="btn btn-outline-light bg-white btn-icon position-relative me-1">
                    <i class="ti ti-brand-hipchat"></i>
                    <span class="chat-status-dot"></span>
                </a>
            </div>
            <div class="pe-1">
              <a href="" class="btn btn-outline-light bg-white  position-relative "><span class="ti ti-key"></span> Ubah Password</a>
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
                                <img src="/storage/{{ Auth::user()->student->foto }}" alt='Img' class='img-fluid'>
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
                                <img src="/storage/{{ Auth::user()->gtk->gambar }}" alt='Img' class='img-fluid'>
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
                                <img src="/storage/{{ Auth::user()->gtk->gambar }}" alt='Img' class='img-fluid'>
                            @endif
                            @endif
                        @endif

                        @if(auth()->user()->role == "admin" || auth()->user()->role == "superadmin" )
                            <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
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
                                           <img src="/storage/{{ Auth::user()->student->foto }}" alt='Img' class='img-fluid'>
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
                                           <img src="/storage/{{ Auth::user()->gtk->gambar }}" alt='Img' class='img-fluid'>
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
                                           <img src="/storage/{{ Auth::user()->gtk->gambar }}" alt='Img' class='img-fluid'>
                                       @endif
                                       @endif
                                   @endif

                                   @if(auth()->user()->role == "admin" || auth()->user()->role == "superadmin"  )
                                       <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
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
