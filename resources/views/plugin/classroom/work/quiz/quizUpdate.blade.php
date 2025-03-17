@extends('layout.main')
@section('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.6.0/tinymce.min.js" integrity="sha512-/4EpSbZW47rO/cUIb0AMRs/xWwE8pyOLf8eiDWQ6sQash5RP1Cl8Zi2aqa4QEufjeqnzTK8CLZWX7J5ZjLcc1Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
@section('container')
   {{-- header --}}
   <div class="d-md-flex d-block align-items-center justify-content-between mb-3 ">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">Form Ubah Pertanyaan</h3>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
        <a href="{{ route('classroom.quiz',[$id_kelas,$task_id]) }}" class="btn btn-outline-light bg-white  position-relative me-1">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
    </div>
</div>
{{-- End Header --}}
<div class="card flex-fill bg-info " style="background-image: url('{{ asset('asset/img/shape-05.png') }}'); background-size: cover; background-position: center;">
    <div class="card-body pt-5">
        <h1 class="text-white mb-1 "><span class="ti ti-clipboard-list"></span>{{ $title }}</h1>
    </div>
</div>
@foreach ($question as $item)
<form action="{{ route('classroom.quizUpdate') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Pertanyaan</label>
                        <textarea name="soal"  class="editor" placeholder="Buat Pertanyaan atau soal">{{ $item->soal }}</textarea>
                    </div>
                </div>
            </div>
            <div class="card mx-5">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Pilihan A</label>
                        <textarea name="pilihan_a" id="" class="editor" placeholder="Buat opsi A untuk pertanyaan diatas">{{ $item->pilihan_a }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilihan B</label>
                        <textarea name="pilihan_b" id="" class="editor" placeholder="Buat opsi B untuk pertanyaan diatas">{{ $item->pilihan_b }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilihan C</label>
                        <textarea name="pilihan_c" id="" class="editor" placeholder="Buat opsi C untuk pertanyaan diatas">{{ $item->pilihan_c }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilihan D</label>
                        <textarea name="pilihan_d" id="" class="editor" placeholder="Buat opsi D untuk pertanyaan diatas">{{ $item->pilihan_d }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilihan E</label>
                        <textarea name="pilihan_e" id="" class="editor" placeholder="Buat opsi E untuk pertanyaan diatas">{{ $item->pilihan_e }}</textarea>
                    </div>

                </div>
            </div>
            <div class="card mx-5">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="" class="form-label">Jawaban Benar</label>
                        <select name="jawaban" class="select">
                            <option value="A" {{ $item->jawaban == 'A' ?'selected':'' }}>A</option>
                            <option value="B" {{ $item->jawaban == 'B' ?'selected':'' }}>B</option>
                            <option value="C" {{ $item->jawaban == 'C' ?'selected':'' }}>C</option>
                            <option value="D" {{ $item->jawaban == 'D' ?'selected':'' }}>D</option>
                            <option value="E" {{ $item->jawaban == 'E' ?'selected':'' }}>E</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- sidebar --}}
        <div class="col-md-3 border-start bg-muted" style="min-height: 100vh; ">
            <div class="" style="position: sticky; top: 70px;">
            <div class="mb-3 border-bottom">
                <button class="btn btn-primary w-100" type="submit">
                    <span class="ti ti-send"></span> Simpan Perubahan
                </button>
            </div>
            <div class="py-2 me-2">
                <div class="mb-3">
                    <label for="" class="form-label">Untuk :</label>
                    <select class="form-control select">
                        <option value="">{{ $title }}</option>
                    </select>
                    <input type="text" value="{{ $task_id }}" name="task_id" hidden>
                    <input type="text" value="{{ $item->id }}" name="id" hidden >
                </div>
                <div class="mb-3">
                    Updated by:
                    <div class="bg-light-400 rounded-2 p-3 mb-3 border">
                        <div class="d-flex align-items-center">
                            <a class="avatar avatar-lg flex-shrink-0"><img src="{{ asset('asset/img/user-default.jpg') }}" class="img-fluid rounded-circle" alt="img"></a>
                            <div class="ms-2">
                                <h6 class="text-dark text-truncate mb-0"><a>{{ auth()->user()->nama }}</a></h6>
                                <small>{{ auth()->user()->email }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </div>
</form>
@endforeach
@section('javascript')
<script>
    var body = document.body;
    body.classList.add("mini-sidebar");

   tinymce.init({
   selector: '.editor', // Initialize TinyMCE on any element with class 'editor'
   menubar: false,
   statusbar: false,
   height:200,
   toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist',

   })
</script>
@endsection
@endsection
