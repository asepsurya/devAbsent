<style>
    #plugin ul {
        margin-bottom: 1px;
    }
/*the container must be positioned relative:*/
.autocomplete {
  position: relative;
  display: inline-block;
}
.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff;
  border-bottom: 1px solid #d4d4d4;
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9;
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important;
  color: #ffffff00;
}
</style>
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu " class="sidebar-menu">
            <ul>
                <li>
                    <a href="javascript:void(0);" class="d-flex align-items-center border bg-white rounded p-2 mb-4">
                        <img src="{{ app('settings')['site_logo'] == '' ? asset('asset/img/default-logo.png') : asset('storage/'.app('settings')['site_logo'])  }}" class="avatar avatar-md img-fluid rounded" alt="Profile">
                        <span class="text-dark ms-2 fw-normal" style="line-height: 1.4;">{{ app('settings')['site_name'] }}</span>
                    </a>
                </li>
            </ul>
            <ul>
                <form autocomplete="off" action="/action_page.php">
                    <div class="autocomplete mb-3 w-100" >
                      <input id="myInput" type="text" name="myCountry" placeholder="Cari Menu...." class="form-control">
                    </div>

                  </form>
            </ul>
            <ul  id="menu">
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
                        @if(auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
                        <li class="{{ Request::is('plugin') ? 'active' : ''}}" >
                            <a href="{{ route('plugin.index') }}" style="margin-bottom:5px">
                                <i class="ti ti-plug"></i><span>Plugin</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                <li>
                    <ul style="margin-top:-13px;" >
                        @include('partial.menu_plugin')
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
                        @if(auth()->user()->canAny(['akademik', 'lisensi', 'gtk', 'rfid', 'verifikasi_pengguna']))
                        <h6 class="submenu-hdr"><span>Master Data</span></h6>
                        @endif


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

                                        <li><a href="/akademik/pengaturan/walikelas" class="{{ Request::is('akademik/pengaturan/walikelas') ? 'active' : ''}}">Wali Kelas</a></li>
                                        <li><a href="/akademik/pengaturan/rombel" class="{{ Request::is('akademik/pengaturan/rombel') ? 'active' : ''}}">Rombongan Belajar</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ route('dataIndukStudentlulusan') }}" class="  {{ Request::is('akademik/lulusan') ? 'active' : ''}}">
                                        Data Lulusan
                                    </a>
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
                        @can('device')
                        <li class="{{ Request::is('device') ? 'active' : ''}}">
                            <a href="/device">
                                <i class="ti ti-devices"></i><span>Device Scanner RFID</span>
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

                        {{-- @can('Ruangan Kelas')
                            <li class="{{ Request::is('classroom*') ? 'active' : ''}}">
                        <a href="/classroom">
                            <i class="ti ti-building"></i><span>Ruangan Kelas</span>
                        </a>
                </li>
                @endcan --}}

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
                        <li><a href="/akademik/datainduk/mapel" class="{{ Request::is('akademik/datainduk/mapel') ? 'active' : ''}}">Tambah</a></li>
                        <li><a href="/class/leasson/mapel" class="{{ Request::is('class/leasson/mapel') ? 'active' : ''}}">Setel Mata Pelajaran</a></li>
                        <li><a href="/class/leasson/subject_teachers" class="{{ Request::is('class/leasson/subject_teachers') ? 'active' : ''}}">Guru Mata Pelajaran</a></li>
                        <li><a href="/class/leasson/reference" class="{{ Request::is('class/leasson/reference') ? 'active' : ''}}">Setelan Referensi</a></li>
                        <li><a href="/class/leasson/hari" class="{{ Request::is('class/leasson/hari') ? 'active' : ''}}">Hari Efektif</a></li>
                        <li><a href="/class/leasson" class="{{ Request::is('class/leasson/list*') ? 'active' : ''}}">Setel Jadwal</a></li>

                    </ul>


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
                                    <li><a href="/report/absentrfid/student?month={{ \Carbon\Carbon::now()->format('m') }}&year={{ \Carbon\Carbon::now()->format('Y') }}" class="{{ Request::is('report/absentrfid*') ? 'active' : ''}}">Laporan RFID</a></li>
                                    <li><a href="/report/absent/students?month={{ \Carbon\Carbon::now()->format('m') }}&year={{ \Carbon\Carbon::now()->format('Y') }}" class="{{ Request::is('report/absent/students') ? 'active' : ''}}">Laporan Absensi Kelas</a></li>
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

                                </ul>
                            </li>
                        </ul>
                        <ul>
                            <li class="{{ Request::is('setelan*') ? 'active' : ''}}">
                                <a href="{{ route('setelan.app') }}"><i class="ti ti-settings"></i><span>Pengaturan Aplikasi</span></a>
                            </li>
                        </ul>
                        @if(auth()->user()->role == 'superadmin')
                        <ul>
                            <li class="{{ Request::is('modules*') ? 'active' : ''}}">
                                <a href="/modules"><i class="ti ti-users"></i><span>Pengaturan Hak Akses</span></a>
                            </li>
                        </ul>
                        <ul>
                            <li class="{{ Request::is('backup/history*') ? 'active' : ''}}">
                                <a href="/backup/history"><i class="ti ti-database-cog"></i><span>Backup Database</span></a>
                            </li>
                        </ul>
                        @endif
                    </li>
                    @endcan
                </ul>


            </li>


        </div>
    </div>
</div>

<script>
function autocomplete(inp, arr) {
  var currentFocus;

  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      closeAllLists();
      if (!val) { return false; }
      currentFocus = -1;

      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");

      this.parentNode.appendChild(a);

      for (i = 0; i < arr.length; i++) {
        if (arr[i].label.substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          b = document.createElement("DIV");

          b.innerHTML = "<strong>" + arr[i].label.substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].label.substr(val.length);

          if (arr[i].description) {
            b.innerHTML += "<br><small style='color: gray;'>" + arr[i].description + "</small>";
          }

          if (arr[i].fullPath) {
            b.innerHTML += "<br><small style='color: gray;text-size:5px;'>" + arr[i].fullPath + "</small>";
          }

          b.innerHTML += "<input type='hidden' value='" + arr[i].label + "' data-url='" + arr[i].value + "'>";

          b.addEventListener("click", function(e) {
              let inputField = this.getElementsByTagName("input")[0];
              inp.value = inputField.value;
              let url = inputField.getAttribute("data-url");

              if (url) {
                window.location.href = url;
              }

              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });

  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        currentFocus++;
        addActive(x);
      } else if (e.keyCode == 38) {
        currentFocus--;
        addActive(x);
      } else if (e.keyCode == 13) {
        e.preventDefault();
        if (currentFocus > -1) {
          if (x) x[currentFocus].click();
        }
      }
  });

  function addActive(x) {
    if (!x) return false;
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    x[currentFocus].classList.add("autocomplete-active");
  }

  function removeActive(x) {
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }

  function closeAllLists(elmnt) {
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }

  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

// Ambil teks menu + linknya + keterangan + lokasi menu
function getMenuPath(item) {
    let path = [];
    let current = item;
    while (current && current.tagName !== "BODY") {
        if (current.tagName === "LI" && current.querySelector("a")) {
            let linkText = current.querySelector("a").textContent.trim();
            if (linkText) {
                path.unshift(linkText);
            }
        }
        current = current.parentElement;
    }
    return path.join(" → ");
}

let menuItems = Array.from(document.querySelectorAll("ul li a"))
    .map(item => ({
        label: item.textContent.trim(),
        value: item.href,
        description: item.getAttribute("data-description") || "",
        fullPath: getMenuPath(item.closest("li"))
    }))
    .filter(item => item.label.length > 0);

autocomplete(document.getElementById("myInput"), menuItems);

</script>
