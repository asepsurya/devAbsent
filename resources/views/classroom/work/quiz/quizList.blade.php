@extends('layout.main')
@section('container')
   {{-- header --}}
   <div class="d-md-flex d-block align-items-center justify-content-between mb-3 ">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">{{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/dashboard">Ruangan Kelas</a>
                </li>

                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
        <a href="{{ route('classroom.detail',[$id_kelas]) }}" class="btn btn-outline-light bg-white  position-relative me-1">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
        <a class="btn btn-outline-light bg-white  position-relative me-1">
            <i class="ti ti-file-spreadsheet"></i> import Data
        </a>
    </div>
</div>
{{-- End Header --}}
<div class="bg-white p-3 border rounded-1 d-flex align-items-center justify-content-between flex-wrap mb-4 pb-0">
    <h4 class="mb-3">{{ $name_task }}</h4>
    <div class="d-flex align-items-center flex-wrap">
        <div class="d-flex align-items-center flex-wrap">
            <a href="{{ route('classroom.tambahQuiz',[$id_kelas,$task_id]) }}" class="btn btn-primary btn-small mb-3" ><span class="ti ti-circle-plus"></span> Tambah Pertanyaan</a>
        </div>
    </div>
</div>
<div class="border-bottom d-flex align-items-center justify-content-between flex-wrap  pb-2">
    <h6><span class="ti ti-question-mark"></span> Daftar Pertanyaan</h6>
    <div class="d-flex align-items-center flex-wrap"><span class="badge badge-soft-success">{{ $quest->count() }} Item</span></div>
</div>
<div class="">
    <table class="table table-nowrap mb-0" id="myTable2">
        @php
            $no=1;
        @endphp
        @if($quest->count())
            @foreach ($quest as $item)
            <tr>
                <td width="1%">{{ $no++ }}</td>
                <td width="95%"><a href="{{ route('classroom.editQuiz',[$id_kelas,$item->id,$task_id]) }}">{!! Str::words($item->soal, 10, '...') !!}</a></td>
                <td>Added {{ $item->created_at->diffForHumans() }}</td>
                <td><button class="btn btn-danger btn-sm"><span class="ti ti-trash-x"></span></button></td>
            </tr>
            @endforeach
        @else
            <tr colspan="4">
                <td>
                    <div class="d-flex justify-content-center p-5">
                        Belum menambahkan satu pertanyaan apapun 
                    </div>
                </td>
            </tr>
        @endif
    </table>
</div>

@section('javascript')
<script>
    var body = document.body;
    body.classList.add("mini-sidebar");
</script>
@endsection
@endsection
