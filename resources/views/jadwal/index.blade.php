@extends('layout.main')
@section('container')
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">{{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Jadwal Pelajaran</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">

        <div class="pe-1 mb-2">
            <button type="button" class="btn btn-outline-light bg-white btn-icon me-1" onclick="history.back()">
                <i class="ti ti-arrow-left"></i>
            </button>
        </div>
        <div class="pe-1 mb-2">
            <a href="{{ route('leassonView',$id) }}" class=" btn btn-outline-light me-1"><span class="ti ti-eye"></span>
                Tampilkan Jadwal</a>
        </div>
        <div class="pe-1 mb-2">
            <a data-bs-toggle="modal" href="#ref" class=" btn btn-outline-light me-1"><span class="ti ti-settings"></span>
                Referensi</a>
        </div>
        <div class="mb-2">
            <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-effect="effect-scale"
                data-bs-toggle="modal" data-bs-target="#add_holiday"><i
                    class="ti ti-square-rounded-plus me-2"></i>Tambah Mata Pelajaran</a>
        </div>

    </div>
</div>
{{-- End Header --}}
<div class="card">
    <div class="card-header">
        <form action="{{ route('list',$id) }}" method="get">
        <h4 class="mb-2">List Jadwal Pelajaran</h4>
        <select name="tahun_ajar" id="tahun_ajar" class="form-control select" onchange="this.form.submit()">
            @foreach ($tahun_ajar as $item )
            <option value="{{ $item->id }}" {{ request('tahun_ajar') == $item->id ? 'selected' : '' }}>Tahun Pelajaran : {{ $item->tahun_pelajaran }} - {{ $item->semester }}
            </option>
            @endforeach
        </select>
        </form>
    </div>
    <div class="card-body p-0 ">
        <div class="table-responsive">
            <table class="table table-nowrap mb-0">
                <thead>
                    <tr>
                        <th class="bg-light-400">#</th>
                        <th class="bg-light-400" width="2%"></th>
                        <th class="bg-light-400 border">Hari</th>
                        <th class="bg-light-400">Mata Pelajaran</th>
                        <th class="bg-light-400">Guru Pengajar</th>
                        <th class="bg-light-400"><span class="ti ti-clock"></span> Start</th>
                        <th class="bg-light-400"><span class="ti ti-clock"></span> End</th>
                        <th class="bg-light-400"><span class="ti ti-calendar-due"></span> Status</th>
                        <th class="bg-light-400"><span class="ti ti-certificate"></span> SK</th>
                        <th class="bg-light-400"><span class="ti ti-calendar-due"></span> Tanggal SK</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no=1;
                    @endphp

                    @if($jadwal->count())
                    @foreach ($jadwal as $item )
                    <tr>
                        <td><a href="#">{{ $no++ }}</a></td>
                        <td>
                            <div class="hstack ">
                                <a href="{{ route('leassonDelete',$item->id) }}" class="btn btn-icon btn-sm btn-soft-danger rounded-pill"><span class="ti ti-trash"></span></a>
                        </td>
                        <td class="border">
                            @if($item->day == 1)
                            Senin
                            @elseif ($item->day == 2)
                            Selasa
                            @elseif ($item->day == 3)
                            Rabu
                            @elseif ($item->day == 4)
                            Kamis
                            @elseif ($item->day == 5)
                            Jum'at
                            @elseif ($item->day == 6)
                            Sabtu
                            @elseif ($item->day == 7)
                            Minggu
                            @endif
                        </td>
                        <td>
                            @if($item->mata_pelajaran)
                            <b>{{ $item->mata_pelajaran->nama }}</b>
                            @else
                            <b>{{ $item->ref->ref }}</b>
                            @endif
                        </td>
                        <td>
                            @if($item->id_gtk == '')
                            Belum Disetel
                            @else
                            {{ $item->guru->nama }}
                            @endif
                        </td>
                        <td>
                            {{ $item->start }}
                        </td>
                        <td>
                            {{ $item->end }}
                        </td>
                        <td>
                            @if($item->status == 1)
                            <span class="badge badge-soft-success d-inline-flex align-items-center">Aktif</span>
                            @else
                            <span class="badge badge-soft-danger d-inline-flex align-items-center">Tidak AKtif</span>
                            @endif
                        </td>
                        <td>{{ $item->sk == '' ? '-' : $item->sk }}</td>
                        <td>{{ $item->tanggal_sk == '' ? '-' : $item->tanggal_sk }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="10"> <center class="m-5"> <span class="ti ti-mood-confuzed"></span> Data masih kosong</center></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- referensi --}}
<div class="modal fade " id="ref" aria-labelledby="exampleModalToggleLabel" tabindex="-1" aria-modal="true"
    role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body m-0 p-0">
                <form action="{{ route('reference') }}" method="post">
                    @csrf
                    <div class="bg-light">
                        <div class="m-3">
                            <label class="form-label">Nama Refrensi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="ref" required placeholder="Example: Ishoma,Upacara Bendera">
                            <button class="btn btn-primary mt-2 w-100"><span class="ti ti-device-floppy"></span> Tambah</button>
                        </div>
                    </div>

                    <div class="accordion accordions-items-seperate m-3" id="accordionSpacingExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    Edit Referensi
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" style="">
                                <div class="accordion-body m-0 p-0">
                                    <div class="table-responsive">
                                        <table class="table table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="bg-light-400" width="10%"></th>
                                                    <th class="bg-light-400">Referensi</th>

                                            </thead>
                                            <tbody>
                                                @foreach ($ref as $item )
                                                <tr>
                                                    <td>
                                                        <div class="hstack gap-2 fs-15">
                                                            <a data-bs-toggle="modal" href="#edit-ref-{{ $item->ref_ID }}" class="btn btn-icon btn-sm btn-soft-info rounded-pill" >
                                                                <i class="ti ti-pencil-minus"></i>
                                                            </a>
                                                            <a href="{{ route('referenceDelete',$item->ref_ID) }}" class="btn btn-icon btn-sm btn-soft-danger rounded-pill">
                                                                <i class="ti ti-trash"></i>
                                                            </a>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <div id="ref_item">{{$item->ref}}</div>
                                                    </td>

                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{ $ref->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button data-bs-toggle="modal" href="#add_holiday" class="btn btn-outline-light me-1"> <span
                        class="ti ti-arrow-left"></span>Kembali
                </button>
            </div>
        </div>
    </div>
</div>
@foreach ($ref as $a )

{{-- Edit referensi --}}
<div class="modal fade " id="edit-ref-{{ $a->ref_ID }}" aria-labelledby="exampleModalToggleLabel" tabindex="-1" aria-modal="true"
    role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body m-0 p-0">
                <form action="{{ route('referenceEdit') }}" method="post">
                    @csrf
                    <div class="bg-light">
                        <div class="m-3">
                            <label class="form-label">Nama Refrensi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="ref_ID" required placeholder="Ex:Ishoma,Upacara" value="{{ $a->ref_ID }}" hidden>
                            <input type="text" class="form-control" name="ref" required placeholder="Ex:Ishoma,Upacara" value="{{ $a->ref }}">
                            <button class="btn btn-primary mt-2 w-100">Simpan</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button data-bs-toggle="modal" href="#ref" class="btn btn-outline-light me-1"> <span
                        class="ti ti-arrow-left"></span>Kembali
                </button>
            </div>
        </div>
    </div>
</div>

@endforeach
{{-- modal tambah Hari Libur --}}
<div class="modal fade" id="add_holiday" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="ti ti-book"></span> Tambah Mata Pelajaran</h4>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form action="{{ route('leassonAdd') }}" method="post">
                <div class="modal-body m-0 p-0">
                    @csrf
                    <div class="mb-3 bg-light p-3">
                        <div class="row">
                            <label class="col-lg-4 form-label mt-2">Tahun Pelajaran <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-8">
                                <select name="tahun_ajar" id="tahun_ajar" class="form-control select2" required>
                                    @foreach ($tahun_ajar as $item )
                                    <option value="{{ $item->id }}">{{ $item->tahun_pelajaran }} - {{ $item->semester }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 mt-0">
                        <div class="mb-2">
                            <label class="form-label">Hari <span class="text-danger">*</span></label>
                            <select name="day" id="day" class="form-control select2" required>
                                <option value="1">Senin</option>
                                <option value="2">Selasa</option>
                                <option value="3">Rabu</option>
                                <option value="4">Kamis</option>
                                <option value="5">Jum'at</option>
                                <option value="6">Sabtu</option>
                                <option value="7">Minggu</option>
                            </select>
                        </div>
                        <ul class="nav nav-tabs nav-tabs-top mb-3" role="tablist">
                            <li class="nav-item" role="presentation"><a class="nav-link active" href="#top-tab1"
                                    data-bs-toggle="tab" aria-selected="true" role="tab" id="tab1">Referensi</a></li>
                            <li class="nav-item" role="presentation"><a class="nav-link" href="#top-tab2"
                                    data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab" id="tab2">Mata
                                    Pelajaran</a></li>
                        </ul>
                        <input type="text" id="type" name="type" value="ref" hidden>
                        <div class="tab-content">
                            <div class="tab-pane show active mb-2" id="top-tab1" role="tabpanel">
                                <select name="ref" id="ref" class="form-control select2">
                                    <option value="">Pilih Referensi</option>
                                    @foreach ($ref as $a)
                                    <option value="{{ $a->ref_ID }}">{{ $a->ref }}</option>
                                    @endforeach
                                </select>
                                <div class="pt-2">

                                    <small >Tambah Referensi <a data-bs-toggle="modal" href="#ref"
                                            class="link-primary">tambah</a></small>
                                </div>
                            </div>
                            <div class="tab-pane" id="top-tab2" role="tabpanel">
                                <div class="mb-2">
                                    <label class="form-label">Mata Pelajaran / <i>Ref </i><span
                                            class="text-danger">*</span>
                                    </label>
                                    <select name="id_mapel" id="mapel" class="form-control select2">

                                        <option value="">Pilih Mata Pelajaran </option>
                                        @foreach ($mapel as $item )
                                        <option value="{{ $item->id_mapel }}">{{ $item->mata_pelajaran->nama }}</option>
                                        @endforeach

                                    </select>

                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Guru Pengajar <small><i class="text-muted">Otomatis
                                                terisi</i></small></label>
                                    <select name="id_gtk" id="id_gtk" hidden></select>
                                    <input type="text" name="status" id="status" class="form-control" value="1" hidden>
                                    <input type="text" name="id_kelas" id="id_kelas" class="form-control"
                                        value="{{ $id }}" hidden>
                                    <input type="text" name="name" id="name_gtk" class="form-control" disabled>
                                    <small>Guru pengajar belum diatur? <a href="{{ route('subject_teachers') }}"
                                            class="link-primary">setel</a></small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-lg-6">
                                <label class="form-label">Start <span class="text-danger">*</span></label>
                                <div class="date-pic">
                                    <input type="text" class="form-control entry timepicker" name="start" value=""
                                        required>
                                    <span class="cal-icon"><i class="ti ti-clock"></i></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">End <span class="text-danger">*</span></label>
                                <div class="date-pic">
                                    <input type="text" class="form-control entry timepicker" name="end" value=""
                                        required>
                                    <span class="cal-icon"><i class="ti ti-clock"></i></span>
                                </div>

                            </div>
                        </div>
                        <div class="accordions-items-seperate">
                            <div class="accordion-item mt-4">
                                <h2 class="accordion-header" id="headingSpacingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#SpacingThree" aria-expanded="false"
                                        aria-controls="SpacingThree">
                                        <i>Optional <span class="ti ti-certificate"></span></i>
                                    </button>
                                </h2>
                                <div id="SpacingThree" class="accordion-collapse collapse"
                                    aria-labelledby="headingSpacingThree" data-bs-parent="#accordionSpacingExample"
                                    style="">
                                    <div class="accordion-body">
                                        <div class="mb-2">
                                            <label class="form-label">Nomor SK</label>
                                            <input type="text" class="form-control" name="no_sk">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Tanggal SK</label>
                                            <input type="text" class="form-control datetimepicker" name="tgl_sk">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Tambah</button>
            </form>
        </div>

    </div>
</div>
</div>

@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

@if (!empty(Session::get('ref')) && Session::get('ref') == 5)
<script type="text/javascript">
    $(function() {
        $('#ref').modal('show');
    });
</script>
@endif


<script>
    let mapel = $('#mapel').val();
    let id_kelas = $('#id_kelas').val();
        var e = document.getElementById("mapel");
            function onChange() {
            var value = e.value;
            $.ajax({
                url:"{{ route('getgtk') }}",
                method:"GET",
                cache:false,
                data : {mapel:value,id_kelas:id_kelas},
                success: function(data){
                    $('#id_gtk').html(data.a);
                    $('#name_gtk').val(data.b);
                }
            });

            }
            e.onchange = onChange;
            onChange();

</script>
<script>
    var body = document.body;
    body.classList.add("mini-sidebar");
</script>
<script>
    $("#tab1").click(function(){
        $("#type").val('ref');
    });
    $("#tab2").click(function(){
        $("#type").val('mapel');
    });
</script>
@endsection
@endsection
