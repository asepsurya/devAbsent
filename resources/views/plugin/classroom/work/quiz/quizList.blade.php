@extends('layout.main')
@section('css')
<style>
    html .darkmode .table tbody tr td a,
    html[data-theme=dark] .table tbody tr td a {
        color: #898e9b;;
}
</style>
@endsection
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
        <a  data-bs-toggle="modal" data-bs-target="#import" class="btn btn-outline-light bg-white  position-relative me-1">
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
                <td><a href="{{ route('classroom.quizDelete',$item->id) }}" class="btn btn-danger btn-sm"><span class="ti ti-trash-x"></span></button></a>
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

<div class="modal fade effect-sign " id="import" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered text-center" role="document">
        <div class="modal-content modal-content-demo">

            <div class="modal-header">
                <h4 class="modal-title">Import Pertanyaan</h4><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal"></button>
            </div>
            <div class="alert alert-primary overflow-hidden p-0 m-2" role="alert">
                <div class="p-3 bg-primary text-fixed-white d-flex justify-content-between">
                    <h6 class="aletr-heading mb-0 text-fixed-white">Informasi Singkat</h6>

                </div>

                <div class="p-2" align="left">
                    <p class="my-1">Berikut ini informasi yang harus diperhatikan :</p>
                    <p class="my-1 mx-2">1. Untuk Contoh Format Dokumen anda bisa download di link ini. <a href="{{ asset('asset/import_sample/question.xlsx') }}" target="_blank" rel="noopener noreferrer"> Download </a> </p>
                    <p class="my-1 mx-2">2. File yang di Import Harus bertype .xlsx atau type file Excel</p>

                </div>
            </div>
            <form id="fileUploadForm" action="{{ route('preview.excel') }}"  method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body text-start">
                    <input type="text" name="id_kelas" value="{{ $id_kelas }}" hidden>
                    <input type="text" name="task_id" value="{{ $task_id }}" hidden>
                    <input type="file" name="excel_file" class="form-control" required  id="excel_file" accept=".xlsx, .xls, .csv" >


                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary w-100"><span class="ti ti-cloud-upload"></span> Import Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@section('javascript')
<script>
    var body = document.body;
    body.classList.add("mini-sidebar");
</script>
@endsection
@endsection
