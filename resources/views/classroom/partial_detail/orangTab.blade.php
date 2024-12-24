<div class="tab-pane" id="bottom-tab3" role="tabpanel">
    <div class="bg-white p-3 border rounded-1 d-flex align-items-center justify-content-between flex-wrap mb-4 pb-0">
        <h4 class="mb-3">Daftar Peserta</h4>
        <div class="d-flex align-items-center flex-wrap">
            @if(auth()->user()->role !=="siswa")
            <div class="d-flex align-items-center flex-wrap">
                <button class="btn btn-primary btn-small mb-3" data-bs-toggle="modal" data-bs-target="#addPeserta"><span class="ti ti-circle-plus"></span> Undang Peserta</button>
            </div>
            @endif
        </div>
    </div>

    <div class="px-5">
        <h4 class="mb-3">Guru Pengajar :</h4>
        <div class="bg-light-400 rounded-2 p-3 mb-3 border">
            <div class="d-flex align-items-center">
                <a class="avatar avatar-lg flex-shrink-0"><img src="http://127.0.0.1:8000/asset/img/user-default.jpg" class="img-fluid rounded-circle" alt="img"></a>
                <div class="ms-2">
                    <h6 class="text-dark text-truncate mb-0"><a>Administrator</a></h6>
                    <p>superAdmin.sakti@gmail.com</p>
                </div>
            </div>
        </div>
        <div class="border-bottom d-flex align-items-center justify-content-between flex-wrap  pb-2">
            <h4><span class="ti ti-user"></span> Daftar Teman Sekelas</h4>
            <div class="d-flex align-items-center flex-wrap"><span class="badge badge-soft-success">{{ $peserta->count() }} Siswa</span></div>
        </div>


            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-nowrap mb-0" id="myTable2">
                    <tbody>
                        @if ($peserta->count())

                            @foreach ($peserta as $item )
                            <tr>
                            <td width="95%">
                                    <div class="d-flex align-items-center">
                                    <a href="#" class="avatar avatar-md">
                                            @if ( $item->peopleStudent->foto =='')
                                                <img src="{{ asset('asset/img/user-default.jpg') }}" class="img-fluid rounded-circle" alt="foto">
                                            @else
                                                <img src="/storage/{{ $item->peopleStudent->foto }}" class="img-fluid rounded-circle" alt="foto">
                                            @endif
                                        </a>
                                        <div class="ms-2">
                                            <p class="mb-0">{{ $item->peopleStudent->nama }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                   <small>Added {{ $item->created_at->diffForHumans() }} </small>

                                </td>
                                @can('action')
                                
                                <td>
                                  <a href="#" class="btn btn-white btn-icon btn-sm d-flex align-items-center justify-content-center rounded-circle p-0"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical fs-14"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right p-3">
                                        <li>
                                            <a class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $item->nis }}"><i
                                                    class="ti ti-trash me-2"></i>Hapus</a>
                                        </li>

                                    </ul>
                                </td>
                                    
                                @endcan
                            </tr>

                            @endforeach
                        @else
                            <tr>
                                <td>
                                    <div class="d-flex justify-content-center p-5">
                                        Belum ada peserta yang ditambahkan
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
    </div>

</div>
