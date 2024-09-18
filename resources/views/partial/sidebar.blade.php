<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li>
                    <a href="javascript:void(0);" class="d-flex align-items-center border bg-white rounded p-2 mb-4">
                        <img src="{{ asset('asset/img/smk.png') }}"
                            class="avatar avatar-md img-fluid rounded" alt="Profile">
                        <span class="text-dark ms-2 fw-normal">SMKS SATYA BHAKTI</span>
                    </a>
                </li>
            </ul>

            <ul>
                <li>
                    @if(auth()->user()->role =="admin")
                        @php $link = route('dashboard.admin')  @endphp
                    @elseif (auth()->user()->role=="walikelas")
                        @php $link = route('dashboard.walikelas')  @endphp
                    @elseif (auth()->user()->role == "guru")
                        @php $link = route('dashboard.teacher')  @endphp
                    @else
                        @php $link = route('dashboard.student')  @endphp
                    @endif
                    <ul>
                        <li>
                            <a href="{{ $link }}"><i class="ti ti-layout-dashboard"></i><span>Beranda  </span></a>
                        </li>

                    </ul>
                </li>

                <li>
                @can('menu')
                    <h6 class="submenu-hdr"><span>Management</span></h6>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);"
                                class=" {{ Request::is('absensi*') ? 'subdrop active' : ''}}"><i
                                    class="ti ti-checklist"></i><span>Absensi</span><span class="menu-arrow"></span></a>
                            <ul>
                                <li>
                                    <a href="/absensi/student?tanggal={{ date('d/m/Y') }}"
                                       class="{{ Request::is('absensi/student') ? 'active' : ''}}">
                                        Peserta Didik
                                    </a>
                                </li>
                                <li>
                                    <a href="/absensi/teacher?tanggal={{ date('d/m/Y') }}"
                                       class="{{ Request::is('absensi/teacher') ? 'active' : ''}}">
                                       GTK
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li  class="{{ Request::is('class/list*') ? 'active' : ''}}">
                            <a href="/class/list" ><i class="ti ti-list-details"></i><span>Data Kelas</span></a>
                        </li>
                    </ul>
                    @endcan
                </li>

                <li>
                    <ul>
                        <h6 class="submenu-hdr"><span>Master Data</span></h6>
                        <li class="submenu">
                            <a href="javascript:void(0);"
                                class=" {{ Request::is('akademik*') ? 'subdrop active' : ''}}"><i
                                    class="ti ti-school"></i><span>Akademik</span><span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li class="submenu">
                                    <a href="javascript:void(0);"
                                        class=" {{ Request::is('akademik/datainduk*') ? 'subdrop active' : ''}}"> Data
                                        Induk</span><span class="menu-arrow"></span></a>
                                    <ul class="mx-3">
                                        <li><a href="/akademik/datainduk/student"
                                                class="{{ Request::is('akademik/datainduk/student*') ? 'active' : ''}}">Peserta Didik</a></li>

                                        <li><a href="/akademik/datainduk/jurusan"
                                                class="{{ Request::is('akademik/datainduk/jurusan') ? 'active' : ''}}">Jurusan</a>
                                        </li>
                                        <li><a href="/akademik/datainduk/kelas"
                                                class="{{ Request::is('akademik/datainduk/kelas') ? 'active' : ''}}">Kelas</a>
                                        </li>
                                        <li><a href="/akademik/datainduk/mapel"
                                                class="{{ Request::is('akademik/datainduk/mapel') ? 'active' : ''}}">Mata
                                                Pelajaran</a></li>
                                        <li><a href="/akademik/datainduk/tahunajar"
                                                class="{{ Request::is('akademik/datainduk/tahunajar') ? 'active' : ''}}">Tahun
                                                Pelajaran</a></li>
                                    </ul>
                                </li>
                                <li class="submenu">
                                    <a href="javascript:void(0);"
                                        class=" {{ Request::is('akademik/pengaturan*') ? 'subdrop active' : ''}}"> Pengaturan</span><span class="menu-arrow"></span></a>
                                    <ul class="mx-3">
                                        <li><a href="/akademik/pengaturan/mapel"
                                                class="{{ Request::is('akademik/pengaturan/mapel') ? 'active' : ''}}">Mata Pelajaran</a></li>
                                        <li><a href="/akademik/pengaturan/subject_teachers"
                                                class="{{ Request::is('akademik/pengaturan/subject_teachers') ? 'active' : ''}}">Guru Mata Pelajaran</a></li>
                                        <li><a href="/akademik/pengaturan/walikelas"
                                                class="{{ Request::is('akademik/pengaturan/walikelas') ? 'active' : ''}}">Wali Kelas</a>
                                        </li>
                                        <li><a href="/akademik/pengaturan/rombel"
                                                class="{{ Request::is('akademik/pengaturan/rombel') ? 'active' : ''}}">Rombongan Belajar</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="submenu">
                                    <a href="javascript:void(0);"
                                        class=" {{ Request::is('student/import') ? 'subdrop active' : ''}}"> Import Data</span><span class="menu-arrow"></span></a>
                                    <ul class="mx-3">
                                        <li><a href="{{ route('studentIndex') }}"
                                                class="{{ Request::is('datainduk/student/import') ? 'active' : ''}}">Peserta Didik</a></li>
                                        <li><a href="/import/teacher"
                                                class="{{ Request::is('import/teacher') ? 'active' : ''}}">GTK</a></li>
                                        <li><a href="/import/mapel"
                                                class="{{ Request::is('import/mapel') ? 'active' : ''}}">Mata Pelajaran</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul>
                </li>

                <li>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);"
                                class=" {{ Request::is('gtk*') ? 'subdrop active' : ''}}"><i
                                    class="ti ti-users"></i><span>GTK</span><span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="/gtk/all"
                                        class="{{ Request::is('gtk/all') ? 'active' : ''}}">Semua GTK</a></li>
                                <li><a href="/gtk/employment_types"
                                        class="{{ Request::is('gtk/employment_types') ? 'active' : ''}}">Jenis GTK</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <ul>
                        <li class="{{ Request::is('device/lisensi*') ? 'active' : ''}}">
                            <a href="{{ route('lisensiIndex') }}"><i class="ti ti-key"></i><span>Lisensi</span></a>
                        </li>
                    </ul>
                </li>
                <li>
                    <ul>
                        <li class="{{ Request::is('rfid') ? 'active' : ''}}">
                            <a href="{{ route('rfid') }}"><i class="ti ti-nfc"></i><span>Registrasi RFID</span></a>
                        </li>
                    </ul>
                </li>
                <li>
                    <ul>
                        <li class="{{ Request::is('verifikasiuser') ? 'active' : ''}}">
                            <a href="/verifikasiuser"><i class="ti ti-user"></i><span>Verifikasi Pengguna </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <ul>
                        <h6 class="submenu-hdr"><span>Jadwal</span></h6>
                        <li>
                            <a href="##"><i class="ti ti-notebook"></i><span>Pelajaran</span></a>
                        </li>
                        <li  class="{{ Request::is('holidays') ? 'active' : ''}}">
                            <a href="/holidays" ><i class="ti ti-calendar-stats"></i><span>Hari Libur</span></a>
                        </li>
                    </ul>
                </li>
                <li>
                    <ul>
                        <h6 class="submenu-hdr"><span>Report</span></h6>
                        <li>
                            <a href="##"><i class="ti ti-file-text"></i><span>Laporan</span></a>
                        </li>
                    </ul>
                </li>
                <li>
                    <ul>
                        <h6 class="submenu-hdr"><span>Setelan Aplikasi</span></h6>
                        <li>
                            <ul>
                                <li class="submenu">
                                    <a href="javascript:void(0);"
                                        class=" {{ Request::is('user*') ? 'subdrop active' : ''}}"><i
                                            class="ti ti-lock"></i><span>Pengguna</span><span class="menu-arrow"></span></a>
                                    <ul>
                                        <li><a href="/user/administrator"
                                                class="{{ Request::is('user/administrator') ? 'active' : ''}}">Administrator</a></li>
                                        <li><a href="/user/students"
                                                class="{{ Request::is('user/students') ? 'active' : ''}}">Peserta Didik</a></li>
                                        <li><a href="/user/employees"
                                                class="{{ Request::is('user/employees') ? 'active' : ''}}">GTK</a></li>
                                        <li><a href="/user/modules"
                                                class="{{ Request::is('user/modules') ? 'active' : ''}}">Daftar Modul</a></li>
                                        <li><a href="/user/user_privileges"
                                                class="{{ Request::is('user/user_privileges') ? 'active' : ''}}">Hak Akses</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="##"><i class="ti ti-settings"></i><span>Pengaturan</span></a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>
