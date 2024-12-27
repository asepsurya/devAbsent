<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li>
                    <a href="javascript:void(0);" class="d-flex align-items-center border bg-white rounded p-2 mb-4">
                        <img src="{{ app('settings')['site_logo'] == '' ? asset('asset/img/default-logo.png') : '/storage/'.app('settings')['site_logo']  }}"
                            class="avatar avatar-md img-fluid rounded" alt="Profile">
                        <span class="text-dark ms-2 fw-normal">{{ app('settings')['site_name'] }}</span>
                    </a>
                </li>
            </ul>

            <ul>
                <li>
                    <ul>
                        @if(auth()->user()->role == "superadmin")
                            <li class="{{ Request::is('dashboard') ? 'active' : ''}}">
                                <a href="{{ route('dashboard.superadmin') }}">
                                    <i class="ti ti-layout-dashboard"></i><span>Beranda</span>
                                </a>
                            </li>
                        @elseif(auth()->user()->role == "admin")
                            <li class="{{ Request::is('admin/dashboard') ? 'active' : ''}}">
                                <a href="{{ route('dashboard.admin') }}">
                                    <i class="ti ti-layout-dashboard"></i><span>Beranda</span>
                                </a>
                            </li>
                        @elseif(auth()->user()->role == "walikelas")
                            <li class="{{ Request::is('walikelas/dashboard') ? 'active' : ''}}">
                                <a href="{{ route('dashboard.walikelas') }}">
                                    <i class="ti ti-layout-dashboard"></i><span>Beranda</span>
                                </a>
                            </li>
                        @elseif(auth()->user()->role == "guru")
                            <li class="{{ Request::is('teacher/dashboard') ? 'active' : ''}}">
                                <a href="{{ route('dashboard.teacher') }}">
                                    <i class="ti ti-layout-dashboard"></i><span>Beranda</span>
                                </a>
                            </li>
                        @else
                            <li class="{{ Request::is('student/dashboard') ? 'active' : ''}}">
                                <a href="{{ route('dashboard.student') }}">
                                    <i class="ti ti-layout-dashboard"></i><span>Beranda</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                @if(auth()->user()->role == 'siswa')
                    <li>
                        <h6 class="submenu-hdr"><span>Menu Saya</span></h6>
                        <ul>
                            <li class="{{ Request::is('class/leasson/view*') ? 'active' : ''}}">
                                @if(auth()->user()->rombelstudent)
                                    <a href="{{ route('leassonView', auth()->user()->rombelstudent->id_kelas) }}">
                                        <i class="ti ti-list"></i><span>Jadwal Pelajaran</span>
                                    </a>
                                @else
                                    <a class="notif"><i class="ti ti-list"></i><span>Jadwal Pelajaran</span></a>
                                @endif
                            </li>
                            <li class="{{ Request::is('absent/list*') ? 'active' : ''}}">
                                @if(auth()->user()->rombelstudent)
                                    <a href="{{ route('absent_list', [auth()->user()->rombelstudent->id_kelas, auth()->user()->rombelstudent->nis]) }}">
                                        <i class="ti ti-key"></i><span>Daftar Hadir Kelas</span>
                                    </a>
                                @endif
                            </li>
                        </ul>
                    </li>
                @endif

                <li>
                    @if(auth()->user()->canAny(['Absensi RFID', 'Absensi Kelas', 'Management Absensi']))
                        <h6 class="submenu-hdr"><span>Management</span></h6>
                    @endif
                    <ul>
                        @can('Absensi RFID')
                            <li class="submenu">
                                <a href="javascript:void(0);" class="{{ Request::is('absensi*') ? 'subdrop active' : ''}}">
                                    <i class="ti ti-checklist"></i><span>Absensi RFID</span><span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/absensi/student?kelas=all&tanggal={{ date('d/m/Y') }}" class="{{ Request::is('absensi/student') ? 'active' : ''}}">
                                            Peserta Didik
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/absensi/teacher?tanggal={{ date('d/m/Y') }}" class="{{ Request::is('absensi/teacher') ? 'active' : ''}}">
                                            GTK
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        @can('Absensi Kelas')
                            <li class="{{ Request::is('absent/class*') ? 'active' : ''}}">
                                <a href="/absent/class">
                                    <i class="ti ti-checklist"></i><span>Absensi Kelas</span>
                                </a>
                            </li>
                        @endcan

                        @can('Management Absensi')
                            <li class="{{ Request::is('class/list') || Request::is('class/absensi/management*') ? 'active' : ''}}">
                                <a href="/class/list">
                                    <i class="ti ti-list-details"></i><span>Management Absensi</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                <li>
                    <ul>
                        @can('akademik', 'lisensi', 'gtk', 'rfid', 'verifikasi_pengguna')
                            <h6 class="submenu-hdr"><span>Master Data</span></h6>
                        @endcan

                        @can('akademik')
                            <li class="submenu">
                                <a href="javascript:void(0);" class="{{ Request::is('akademik*') ? 'subdrop active' : ''}}">
                                    <i class="ti ti-school"></i><span>Akademik</span><span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li class="submenu">
                                        <a href="javascript:void(0);" class="{{ Request::is('akademik/datainduk*') ? 'subdrop active' : ''}}">
                                            Data Induk<span class="menu-arrow"></span>
                                        </a>
                                        <ul class="mx-3">
                                            <li><a href="/akademik/datainduk/student" class="{{ Request::is('akademik/datainduk/student*') ? 'active' : ''}}">Peserta Didik</a></li>
                                            <li><a href="/akademik/datainduk/jurusan" class="{{ Request::is('akademik/datainduk/jurusan') ? 'active' : ''}}">Jurusan</a></li>
                                            <li><a href="/akademik/datainduk/kelas" class="{{ Request::is('akademik/datainduk/kelas') ? 'active' : ''}}">Kelas</a></li>
                                            <li><a href="/akademik/datainduk/mapel" class="{{ Request::is('akademik/datainduk/mapel') ? 'active' : ''}}">Mata Pelajaran</a></li>
                                            <li><a href="/akademik/datainduk/tahunajar" class="{{ Request::is('akademik/datainduk/tahunajar') ? 'active' : ''}}">Tahun Pelajaran</a></li>
                                        </ul>
                                    </li>
                                    <li class="submenu">
                                        <a href="javascript:void(0);" class="{{ Request::is('akademik/pengaturan*') ? 'subdrop active' : ''}}">
                                            Pengaturan<span class="menu-arrow"></span>
                                        </a>
                                        <ul class="mx-3">
                                            <li><a href="/akademik/pengaturan/mapel" class="{{ Request::is('akademik/pengaturan/mapel') ? 'active' : ''}}">Mata Pelajaran</a></li>
                                            <li><a href="/akademik/pengaturan/subject_teachers" class="{{ Request::is('akademik/pengaturan/subject_teachers') ? 'active' : ''}}">Guru Mata Pelajaran</a></li>
                                            <li><a href="/akademik/pengaturan/walikelas" class="{{ Request::is('akademik/pengaturan/walikelas') ? 'active' : ''}}">Wali Kelas</a></li>
                                            <li><a href="/akademik/pengaturan/rombel" class="{{ Request::is('akademik/pengaturan/rombel') ? 'active' : ''}}">Rombongan Belajar</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        @endcan
                        @can('gtk')
                        <li class="submenu">
                            <a href="javascript:void(0);" class="{{ Request::is('gtk*') ? 'subdrop active' : ''}}">
                                <i class="ti ti-users"></i><span>GTK</span><span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="/gtk/all" class="{{ Request::is('gtk/all') ? 'active' : ''}}">Semua GTK</a></li>
                                <li><a href="/gtk/employment_types" class="{{ Request::is('gtk/employment_types') ? 'active' : ''}}">Jenis GTK</a></li>
                            </ul>
                        </li>
                        @endcan
                        @can('lisensi')
                        <li class="{{ Request::is('device/lisensi*') ? 'active' : ''}}">
                            <a href="{{ route('lisensiIndex') }}">
                                <i class="ti ti-key"></i><span>Lisensi</span>
                            </a>
                        </li>
                        @endcan

                        @can('rfid')
                        <li class="{{ Request::is('rfid') ? 'active' : ''}}">
                            <a href="{{ route('rfid') }}">
                                <i class="ti ti-nfc"></i><span>Registrasi RFID</span>
                            </a>
                        </li>
                        @endcan
                        @can('verifikasi_pengguna')
                        <li class="{{ Request::is('verifikasiuser') ? 'active' : ''}}">
                            <a href="/verifikasiuser">
                                <i class="ti ti-user"></i><span>Verifikasi Pengguna
                                    @if ($countActiveUsers)
                                        <span class="notification-status-dot"></span>
                                    @endif
                                </span>

                            </a>
                        </li>

                        @endcan
                    </ul>

                </li>

                <li>
                    <ul>
                        @if(auth()->user()->canAny(['Ruangan Kelas', 'Setelan Masuk Keluar', 'Papan Pengumuman', 'Jadwal Pelajaran', 'Kalender Akademik', 'Setelan Hari Libur']))
                        <h6 class="submenu-hdr"><span>Jadwal dan Kelas</span></h6>
                        @endif

                        @can('Ruangan Kelas')
                            <li class="{{ Request::is('classroom*') ? 'active' : ''}}">
                                <a href="/classroom">
                                    <i class="ti ti-building"></i><span>Ruangan Kelas</span>
                                </a>
                            </li>
                        @endcan

                        @can('Setelan Masuk Keluar')
                            <li class="{{ Request::is('class/time') ? 'active' : ''}}">
                                <a href="/class/time">
                                    <i class="ti ti-clock-hour-2"></i><span>Jam Masuk dan Pulang</span>
                                </a>
                            </li>
                        @endcan

                        @can('Papan Pengumuman')
                            <li class="{{ Request::is('announcements') ? 'active' : ''}}">
                                <a href="/announcements">
                                    <i class="ti ti-brand-trello"></i><span>Papan Pengumuman</span>
                                </a>
                            </li>
                        @endcan

                        @can('Jadwal Pelajaran')
                        <li class="submenu">
                            <a href="javascript:void(0);" class="{{ Request::is('class/leasson*') ? 'subdrop active' : ''}}">
                                <i class="ti ti-notebook"></i><span>Jadwal Pelajaran</span><span class="menu-arrow"></span>
                            </a>

                            <ul class="mx-3">
                                <li><a href="/class/leasson/reference" class="{{ Request::is('class/leasson/reference') ? 'active' : ''}}">Setelan Referensi</a></li>
                                <li><a href="/class/leasson/hari" class="{{ Request::is('class/leasson/hari') ? 'active' : ''}}">Hari Efektif</a></li>
                                <li><a href="/class/leasson" class="{{ Request::is('class/leasson/list*') ? 'active' : ''}}">Setel Jadwal</a></li>
                            </ul>


                        </li>
                        @endcan

                        @can('Kalender Akademik')
                            <li class="{{ Request::is('kalender') ? 'active' : ''}}">
                                <a href="/kalender">
                                    <i class="ti ti-calendar"></i><span>Kalender Akademik</span>
                                </a>
                            </li>
                        @endcan

                        @can('Setelan Hari Libur')
                            <li class="{{ Request::is('holidays') ? 'active' : ''}}">
                                <a href="/holidays">
                                    <i class="ti ti-calendar-stats"></i><span>Hari Libur</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                @can('laporan')
                    <li>
                        <ul>
                            <h6 class="submenu-hdr"><span>Report</span></h6>
                            <li>
                                <ul>
                                    <li class="submenu">
                                        <a href="javascript:void(0);" class="{{ Request::is('report*') ? 'subdrop active' : ''}}">
                                            <i class="ti ti-lock"></i><span>Laporan Absensi</span><span class="menu-arrow"></span>
                                        </a>
                                        <ul>
                                            <li><a href="/report/absentrfid/student?month={{ \Carbon\Carbon::now()->format('m') }}&year={{ \Carbon\Carbon::now()->format('Y') }}"
                                                    class="{{ Request::is('report/absentrfid*') ? 'active' : ''}}">Laporan RFID</a></li>
                                            <li><a href="/report/absent/students?month={{ \Carbon\Carbon::now()->format('m') }}&year={{ \Carbon\Carbon::now()->format('Y') }}"
                                                    class="{{ Request::is('report/absent/students') ? 'active' : ''}}">Laporan Absensi Kelas</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endcan

                <li>
                    <ul>
                        @can('Setelan Aplikasi')
                            <h6 class="submenu-hdr"><span>Setelan Aplikasi</span></h6>
                            <li>
                                <ul>
                                    <li class="submenu">
                                        <a href="javascript:void(0);" class="{{ Request::is('user*') ? 'subdrop active' : ''}}">
                                            <i class="ti ti-lock"></i><span>Pengguna</span><span class="menu-arrow"></span>
                                        </a>
                                        <ul>
                                            <li><a href="/user/administrator" class="{{ Request::is('user/administrator') ? 'active' : ''}}">Administrator</a></li>
                                            <li><a href="/user/students" class="{{ Request::is('user/students') ? 'active' : ''}}">Peserta Didik</a></li>
                                            <li><a href="/user/teacher" class="{{ Request::is('user/teacher') ? 'active' : ''}}">Guru</a></li>
                                            <li><a href="/user/administration" class="{{ Request::is('user/administration') ? 'active' : ''}}">Administrasi</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <ul>
                                    <li class="{{ Request::is('setelan*') ? 'active' : ''}}">
                                        <a href="{{ route('setelan.app') }}"><i class="ti ti-settings"></i><span>Pengaturan Aplikasi</span></a>
                                    </li>
                                </ul>
                            </li>
                        @endcan
                    </ul>

                </li>
        </div>
    </div>
</div>

