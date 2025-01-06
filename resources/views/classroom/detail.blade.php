@extends('classroom.layout.classRoom')

@section('content')
@foreach ($myclass as $item )

{{-- End Header --}}
<div class="pt-5">
    <div class="tab-content px-3">
    @include('classroom.partial_detail.forumTab')
    @include('classroom.partial_detail.tugasTab')
    @include('classroom.partial_detail.orangTab')
        @include('classroom.partial_detail.nilaiTab')
    </div>
</div>

@foreach ($peserta as $item )
<div class="modal fade" id="delete-modal-{{ $item->nis }}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

                <div class="modal-body text-center">
                    <div class="p-5  d-flex justify-content-center align-items-center p-4">
                        <span class="bg-danger rounded" style="width: 50px; height: 50px;">
                            <i class="ti ti-trash-x fs-1"></i>
                        </span>
                    </div>

                    <h4>Confirm Deletion</h4>
                    <p>You want to delete all the marked items, this cant be undone once you
                        delete.</p>
                    <div class="d-flex justify-content-center">
                        <a href="javascript:void(0);" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</a>
                        <a href="{{ route('classroom.deleteuserClass',$item->nis) }}" type="submit" class="btn btn-danger">Yes, Delete</a>
                    </div>
                </div>

        </div>
    </div>
</div>
@endforeach

@foreach ($task as $item)
<div class="modal fade" id="editMateri-{{ $item->id }}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">

            <form action="{{ route('classroom.quizTaskAction') }}" method="POST">
                @csrf
                <div class="modal-body ">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="" class="form-label">Nama Quiz</label>
                            <input type="text" class="form-control" name="judul" placeholder="contoh : Quiz Matematika" value="{{ $item->judul }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Durasi Pengerjaan</label>
                            <div class="d-flex justify-content-between">
                                <input type="number" name="poin" value="{{ $item->poin }}" class="form-control me-3" >
                                <div class="mt-2">Menit</div>
                            </div>
                        </div>
                        <div hidden>
                            <input type="text" class="form-control" name="task_id" value="{{ $item->id }}">
                            <input type="text" class="form-control" name="id_kelas" value="{{ $id }}">
                            <input type="text" name="description" value="Quis">
                            <input type="text" name="due_date" >
                            <input type="text" name="type" value="quiz" hidden>
                            <input type="text" name="auth" value="{{ auth()->user()->nomor }}">
                        </div>
                    </div>
                    <button class="btn btn-primary w-100">Simpan Perubahan</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endforeach

<div class="modal fade" id="addMateri" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">

            <form action="{{ route('classroom.tambahTugas') }}" method="POST">
                @csrf
                <div class="modal-body ">
                    <div class="mb-3">
                        <label for="" class="form-label">Nama Quiz</label>
                        <input type="text" class="form-control" name="judul" placeholder="contoh : Quiz Matematika">
                        <div hidden>
                            <input type="text" class="form-control" name="id_kelas" value="{{ $id }}">
                            <input type="text" name="description" value="Quis">

                            <input type="text" name="due_date" >
                            <input type="text" name="type" value="quiz" hidden>
                            <input type="text" name="auth" value="{{ auth()->user()->nomor }}">
                        </div>

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Durasi Pengerjaan</label>
                        <div class="d-flex justify-content-between">
                            <input type="number" name="poin" value="10" class="form-control me-3" >
                            <div class="mt-2">Menit</div>
                        </div>

                    </div>
                    <button class="btn btn-primary w-100">Tambah</button>
                </div>

            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addPeserta" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">+ Undang Siswa</h4>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addClass"><span
                        class="ti ti-users"></span> Undang dari Kelas</button>
                {{-- <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ti ti-x"></i>
                </button> --}}
            </div>
            <form action="{{ route('classroom.adduser') }}" method="POST">
                @csrf
                <div class="modal-body p-0 m-0">
                    <div>
                        <input type="hidden" name="id_kelas" value="{{ $id }}">
                        <input type="text" class="form-control" id="filterInput"
                            placeholder="Ketik Nama atau Nomor NIS">
                    </div>
                    <div style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-nowrap mb-0" id="myTable">
                            <tbody>
                                @foreach ($students as $item )
                                <tr>
                                    <td width="95%">
                                        <div class="d-flex align-items-center">
                                            <a href="#" class="avatar avatar-md">
                                                @if ( $item->foto =='')
                                                    <img src="{{ asset('asset/img/user-default.jpg') }}"
                                                    class="img-fluid rounded-circle" alt="foto">
                                                @else
                                                    <img src="/storage/{{ $item->foto }}"
                                                    class="img-fluid rounded-circle" alt="foto">
                                                @endif

                                            </a>
                                            <div class="ms-2">
                                                <p class="mb-0"> {{ $item->nama }}</p>
                                                <p class="mb-0 text-muted">{{ $item->nis }}</p>

                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-check-md">
                                            <input class="form-check-input mydata" name="nis[]" value="{{ $item->nis }}"
                                                type="checkbox">
                                        </div>
                                    </td>
                                </tr>

                                @endforeach
                                <center> <p id="noResults1" class="m-3" style="display: none; color: red;">No results found</p></center>

                                <!-- Additional rows as needed -->
                            </tbody>
                        </table>
                    </div>
                    <div class="m-2">
                        <button class="btn btn-primary w-100 ">Tambahkan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addClass" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">+ Undang dari Kelas</h4>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addClass"><span
                        class="ti ti-users"></span> Undang Siswa</button>
                {{-- <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ti ti-x"></i>
                </button> --}}
            </div>
            <form action="{{ route('classroom.adduserClass') }}" method="POST">
                @csrf
                <div class="modal-body p-0 m-0">
                    <div>
                        <input type="text" class="form-control" id="filterInputKelas"
                            placeholder="Ketik Nama Kelas">
                    </div>
                    <div style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-nowrap mb-0" id="tabelKelas">
                            <tbody>
                                <input type="text" name="class_code" value="{{ $id }}" hidden>
                                @foreach ($class as $item )
                                <tr>
                                    <td width="95%">
                                        <div class="d-flex align-items-center">
                                            <a href="#" class="avatar avatar-md">
                                                <img src="{{ asset('asset/img/user-default.jpg') }}"
                                                    class="img-fluid rounded-circle" alt="foto">
                                            </a>
                                            <div class="ms-2">
                                                <p class="mb-0"> {{ $item->nama_kelas }} - {{ $item->jurusanKelas->nama_jurusan }} {{ $item->sub_kelas }}</p>
                                                <p class="mb-0 text-muted">Jumlah Siswa : {{ $item->jmlRombel->count() }}</p>

                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-check-md">
                                            <input class="form-check-input mydata" name="id_kelas[]" value="{{ $item->id }}"
                                                type="checkbox">

                                        </div>
                                    </td>
                                </tr>

                                @endforeach
                                <center>  <p id="noResults2" class="m-3" style="display: none; color: red;">No results found</p></center>

                                <!-- Additional rows as needed -->
                            </tbody>
                        </table>
                    </div>
                    <div class="m-2">
                        <button class="btn btn-primary w-100 ">Tambahkan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endforeach

@section('myjavascript')
<script>
    // Filtering for the first table
    const filterInput1 = document.getElementById('filterInput');
    const table1 = document.getElementById('myTable');
    const rows1 = table1.getElementsByTagName('tr');
    const noResults1 = document.getElementById('noResults1'); // Add an element to show the message

    // Add event listener to the input
    filterInput1.addEventListener('input', () => {
        const filterText = filterInput1.value.toLowerCase();
        let hasResults = false;

        // Loop through all rows in the table
        for (let i = 0; i < rows1.length; i++) {
            const row = rows1[i];
            const nameElement = row.querySelector('p'); // Assuming the name is in a <p> tag
            if (nameElement) {
                const nameText = nameElement.textContent.toLowerCase();

                // Show or hide the row based on the filter
                if (nameText.includes(filterText)) {
                    row.style.display = ''; // Show the row
                    hasResults = true;
                } else {
                    row.style.display = 'none'; // Hide the row
                }
            }
        }

        // Show or hide the "Not Found" message
        noResults1.style.display = hasResults ? 'none' : 'block';
    });
</script>
<!-- Script for embedding YouTube videos in the modal -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const videoLinks = document.querySelectorAll('.lightbox-video');
        videoLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const videoUrl = this.getAttribute('data-video-url');
                const videoEmbedUrl = `https://www.youtube.com/embed/${getYouTubeID(videoUrl)}`;
                document.getElementById('videoIframe').src = videoEmbedUrl;
            });
        });

        function getYouTubeID(url) {
            const regExp = /^https:\/\/(?:www\.)?youtube\.com\/(?:.*[?&]v=|.*\/)([a-zA-Z0-9_-]{11})/;
            const match = url.match(regExp);
            return match ? match[1] : null;
        }
    });
</script>
<script>
    // Filtering for the second table
    const filterInput2 = document.getElementById('filterInputKelas');
    const table2 = document.getElementById('tabelKelas');
    const rows2 = table2.getElementsByTagName('tr');
    const noResults2 = document.getElementById('noResults2'); // Add an element to show the message

    // Add event listener to the input
    filterInput2.addEventListener('input', () => {
        const filterText = filterInput2.value.toLowerCase();
        let hasResults = false;

        // Loop through all rows in the table
        for (let i = 0; i < rows2.length; i++) {
            const row = rows2[i];
            const nameElement = row.querySelector('p'); // Assuming the name is in a <p> tag
            if (nameElement) {
                const nameText = nameElement.textContent.toLowerCase();

                // Show or hide the row based on the filter
                if (nameText.includes(filterText)) {
                    row.style.display = ''; // Show the row
                    hasResults = true;
                } else {
                    row.style.display = 'none'; // Hide the row
                }
            }
        }

        // Show or hide the "Not Found" message
        noResults2.style.display = hasResults ? 'none' : 'block';
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.nav-tabs .nav-link');
    const activeTabKey = 'activeTab'; // Key for localStorage

    // Check if a tab is stored in localStorage and activate it
    const savedTab = localStorage.getItem(activeTabKey);
    if (savedTab) {
        const tabToActivate = document.querySelector(`[href="${savedTab}"]`);
        if (tabToActivate) {
            tabToActivate.classList.add('active');
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active', 'show'));
            document.querySelector(savedTab).classList.add('active', 'show');
        }
    }

    // Add click event to each tab to store the active tab
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const href = tab.getAttribute('href');
            localStorage.setItem(activeTabKey, href);
        });
    });
});

</script>
<script>
 tinymce.init({
    selector: '.editor', // Initialize TinyMCE on any element with class 'editor'
    menubar: false,
    statusbar: false,

    toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist',
    height: 200, // Set the height of the editor to 100px
    setup: function(editor) {
      editor.on('keydown', function(e) {
        // Check if the Enter key is pressed
        if (e.key === 'Enter') {
          // Increase the editor's height
          var currentHeight = parseInt(editor.getContainer().style.height, 10) || 100;
          editor.getContainer().style.height = (currentHeight + 30) + 'px'; // Increase height by 30px
        }
      });
    }

    });
</script>
<script>
    tinymce.init({
    selector: '.myeditor', // Your textarea class or ID
     menubar: false,
    statusbar: false,

    plugins: [
    'autolink', 'lists', 'link', 'image', 'charmap', 'preview', 'anchor', 'searchreplace',
    'wordcount', 'fullscreen', 'insertdatetime', 'media', 'table', 'code', 'codesample'
  ],
  toolbar: [
    'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright | outdent indent | bullist  | blockquote | link image media  fullscreen',

  ],
    setup: function(editor) {
        editor.on('change', function() {
        tinymce.triggerSave(); // Save the content to the textarea before submitting
        });
    }
    });
</script>

<script>
    tinymce.init({
    selector: '.myeditorView', // Your textarea class or ID
     menubar: false,
    statusbar: false,
    toolbar: false,
    width:'750px',
    height:'500px',
    setup: function(editor) {
        editor.on('change', function() {
        tinymce.triggerSave(); // Save the content to the textarea before submitting
        });
    }
    });
</script>


@endsection
@endsection
