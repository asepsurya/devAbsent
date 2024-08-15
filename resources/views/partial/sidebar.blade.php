<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li>
                    <a href="javascript:void(0);" class="d-flex align-items-center border bg-white rounded p-2 mb-4">
                        <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/icons/global-img.svg"
                            class="avatar avatar-md img-fluid rounded" alt="Profile">
                        <span class="text-dark ms-2 fw-normal">SMKS SATYA BHAKTI</span>
                    </a>
                </li>
            </ul>
            <ul>
                <li>
                    <ul>
                        <li class="{{ Request::is('dashboard') ? 'active' : ''}}">
                            <a href="/dashboard"><i class="ti ti-layout-dashboard"></i><span>Beranda</span></a>
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
                                    <a href="/absensi/student"
                                       class="{{ Request::is('absensi/student') ? 'active' : ''}}">
                                        Peserta Didik
                                    </a>
                                </li>
                                <li>
                                    <a href="/absensi/teacher"
                                       class="{{ Request::is('absensi/teacher') ? 'active' : ''}}">
                                       GTK
                                    </a>
                                </li>
                            </ul>
                            
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
                                                class="{{ Request::is('akademik/datainduk/student') ? 'active' : ''}}">Peserta Didik</a></li>
                                  
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
                                        <li><a href="/pengaturan/gurupatpel"
                                                class="{{ Request::is('pengaturan/gurumatpel') ? 'active' : ''}}">Guru Mata Pelajaran</a></li>
                                        <li><a href="/pengaturan/walikelas"
                                                class="{{ Request::is('pengaturan/walikelas') ? 'active' : ''}}">Wali Kelas</a>
                                        </li>
                                        <li><a href="/pengaturan/rombel"
                                                class="{{ Request::is('pengaturan/rombel') ? 'active' : ''}}">Rombongan Belajar</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="submenu">
                                    <a href="javascript:void(0);"
                                        class=" {{ Request::is('import*') ? 'subdrop active' : ''}}"> Import Data</span><span class="menu-arrow"></span></a>
                                    <ul class="mx-3">
                                        <li><a href="/import/student"
                                                class="{{ Request::is('import/student') ? 'active' : ''}}">Peserta Didik</a></li>
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
                        <li>
                            <a href="##"><i class="ti ti-device-laptop"></i><span>Daftar Perangkat</span></a>
                        </li>
                    </ul>
                </li>
                <li>
                    <ul>
                        <li>
                            <a href="##"><i class="ti ti-nfc"></i><span>Registrasi RFID</span></a>
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