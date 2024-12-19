@extends('layout.main')
@section('css')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<style>
    .suggestions {
        border-top: none;
        max-height: 150px;
        overflow-y: auto;
        position: absolute;
        width: 100%;
        background-color: white;
        z-index: 999;
    }
    .suggestion-item {
        padding: 8px;
        cursor: pointer;
    }
    .suggestion-item:hover {
        background-color: #f0f0f0;
    }
    .no-suggestions {
    padding: 10px;
    color: #999;
    font-style: italic;
    text-align: center;
    }
    html .darkmode .suggestions,
    html[data-theme=dark] .suggestions {
        background: #0f0c1c;
        border-bottom-color: #1b1632
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
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
    </div>
</div>
{{-- End Header --}}

<div class="bg-white p-3 border rounded-1 d-flex align-items-center justify-content-between flex-wrap mb-4 pb-0">
    <h4 class="mb-3">Daftar Kelas</h4>
    <div class="d-flex align-items-center flex-wrap">
        @can('action')
        <div class="d-flex align-items-center flex-wrap">
            <button class="btn btn-primary btn-small mb-3" data-bs-toggle="modal" data-bs-target="#addClass"><span class="ti ti-circle-plus"></span> Buat Kelas</button>
        </div>
        @endcan
    </div>
</div>
@can('action')
<div class="mb-2 d-flex justify-content-end">
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="/classroom">Ruangan Saya</a>
            </li>
            <li class="breadcrumb-item ">
                @php
                    $mycode = Str::random(30);
                @endphp
                <a href="/classroom?archive={{ $mycode }}">Archive</a></li>
        </ol>
    </nav>
</div>   
@endcan

<div class="row">
    @foreach ($class as $item )
    <div class="col-xxl-4 col-xl-4 col-md-6 d-flex">
        <div class="card flex-fill">
            <div class="card-header d-flex align-items-center justify-content-between" style="height: 100px; background-image: url('{{ asset('asset/img/bg.jpg') }}'); background-size: cover; background-position: center;">
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(255, 255, 255, 0.219)0.219);"></div>
                <h3 class="text-white"></h3>
                <div class="d-flex align-items-center">
                    @can('action')
                    <div class="dropdown">
                        <a href="#" class="btn btn-white btn-icon btn-sm d-flex align-items-center justify-content-center rounded-circle p-0" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical fs-14"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right p-3">
                            <li>
                                <a class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#editClass-{{ $item->id }}"><i class="ti ti-edit-circle me-2"></i>Edit</a>
                            </li>

                            @if(Request('archive'))
                            <li>
                                <a class="dropdown-item rounded-1" href="/classroom/archive/{{ $item->id }}?act={{ $mycode }}" ><i class="ti ti-archive-off me-2"></i>UnArchive</a>
                            </li>
                            @else
                            <li>
                                <a class="dropdown-item rounded-1" href="{{ route('classroom.archive',$item->id) }}" ><i class="ti ti-archive me-2"></i>Archive</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <h3 class="mb-2">
                    <a href="{{ route('classroom.detail',$item->class_code) }}">{{ $item->name }}</a>
                </h3>
                <p class="text-dark">{{ $item->description }}</p>
                <div class="bg-light-400 rounded-2 p-3 mb-3 border">
                    <div class="d-flex align-items-center">
                        <a  class="avatar avatar-lg flex-shrink-0"><img src="{{ asset('asset/img/user-default.jpg') }}" class="img-fluid rounded-circle" alt="img"></a>
                        <div class="ms-2">
                            <h6 class="text-dark text-truncate mb-0"><a>{{ $item->user->nama }}</a></h6>
                            <p>{{ $item->user->email }}</p>
                        </div>
                    </div>
                </div>
                <div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                @if($item->user->status == '2')
                    <span class="badge badge-soft-success">Status : Aktif</span>
                @else
                    <span class="badge badge-soft-danger">Status : Tidak Aktif</span>
                @endif
                <a href="{{ route('classroom.detail',$item->class_code) }}" class="btn btn-light btn-sm">View Details</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
{{-- modal edit --}}
@if($class->count())
    @foreach ($class as $item )
    <div class="modal fade" id="editClass-{{ $item->id }}" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Kelas</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="{{ route('classroom.update') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Nama Kelas (wajib)</label>
                                    <input type="text" class="form-control" placeholder="Nama Kelas" required  name="name" value="{{ $item->name }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Deskripsi kelas</label>
                                    <textarea name="description"  cols="20"  class="form-control" placeholder="Deskripsi Kelas">{{ $item->description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mata Pelajaran ( Wajib )</label>
                                    <input type="text" class="form-control mapel"   name="mapel" autocomplete="off" placeholder="Mata Pelajaran" value="{{ $item->mapel->nama }}">
                                    <div class="suggestions"></div>
                                    <input type="text" class="mapel_id" name="id_mapel" value="{{ $item->id_mapel }}" hidden>
                                </div>
                                <div class="mb-3">
                                    <small>Created by:</small>
                                    <div class="bg-light-400 rounded-2 p-3 mb-3 border">
                                        <div class="d-flex align-items-center">
                                            <a  class="avatar avatar-lg flex-shrink-0">
                                                <img src="{{ asset('asset/img/user-default.jpg') }}" class="img-fluid rounded-circle" alt="img">
                                            </a>
                                            <div class="ms-2">
                                                <h6 class="text-dark text-truncate mb-0"><a >{{ $item->user->nama }}</a></h6>
                                                <p>{{ $item->user->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div hidden>
                                    <input type="text" name="auth" value="{{ $item->auth }}">
                                </div>
                                <input type="hidden" value="{{ $item->class_code}}" name="code_class">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Buat</button>
                    </div>
                    {{-- <div class="modal-footer">
                        <a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</a>

                    </div> --}}
                </form>
            </div>
        </div>
    </div>
    @endforeach
@else
    <div class="bg-white border rounded-1 p-5 ">
        <div class="d-flex  justify-content-center ">
            <span class="ti ti-mood-confuzed"></span> Data Tidak Ditemukan
        </div>
    </div>
@endif
<!-- Modal -->
 <div class="modal fade" id="addClass" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Kelas</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="{{ route('classroom.add') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Nama Kelas (wajib)</label>
                                    <input type="text" class="form-control" placeholder="Nama Kelas" required  name="name">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Deskripsi kelas</label>
                                    <textarea name="description"  cols="20"  class="form-control" placeholder="Deskripsi Kelas"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mata Pelajaran ( Wajib )</label>
                                    <input type="text" class="form-control mapel"  name="mapel" autocomplete="off" placeholder="Mata Pelajaran" >
                                    <div  class="suggestions"></div>
                                    <input type="text" name="id_mapel" class="mapel_id" hidden >
                                </div>
                                <div class="mb-3">
                                    <small>Created by:</small>
                                    <div class="bg-light-400 rounded-2 p-3 mb-3 border">
                                        <div class="d-flex align-items-center">
                                            <a  class="avatar avatar-lg flex-shrink-0">
                                                <img src="{{ asset('asset/img/user-default.jpg') }}" class="img-fluid rounded-circle" alt="img">
                                            </a>
                                            <div class="ms-2">
                                                <h6 class="text-dark text-truncate mb-0"><a >{{ auth()->user()->nama }}</a></h6>
                                                <p>{{ auth()->user()->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div hidden>
                                    <input type="text" name="auth" value="{{ auth()->user()->nomor }}">
                                </div>
                                @php
                                    $randomCode = Str::random(7);
                                @endphp
                                <input type="hidden" value="{{ $randomCode }}" name="code_class">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Buat</button>
                    </div>
                    {{-- <div class="modal-footer">
                        <a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</a>

                    </div> --}}
                </form>
            </div>
        </div>
    </div>

@section('javascript')

<script>
     var body = document.body;
     body.classList.add("mini-sidebar");
</script>
{{-- suggenstion --}}
<script>
    const mapelInputs = document.getElementsByClassName('mapel'); // All elements with class 'mapel'
const suggestionsDivs = document.getElementsByClassName('suggestions'); // All elements with class 'suggestions'
const mapelIdInputs = document.getElementsByClassName('mapel_id'); // All elements with class 'mapel_id'

// Function to fetch and display suggestions
const fetchSuggestions = async (query, mapelInput, suggestionsDiv, mapelIdInput) => {
    try {
        const response = await axios.get('{!! route('classroom.recommend') !!}', { params: { query } });
        const mapels = response.data;

        // Dynamically set the width of the suggestions container
        suggestionsDiv.style.width = `${mapelInput.offsetWidth}px`;

        // Display suggestions or "not found" message
        if (mapels.length > 0) {
            suggestionsDiv.innerHTML = mapels.map(mapel => `
                <div class="suggestion-item" data-name="${mapel.nama}" data-id="${mapel.id}">
                    ${mapel.nama}
                </div>
            `).join('');
        } else {
            suggestionsDiv.innerHTML = `
                <div class="no-suggestions">
                    No suggestions found
                </div>
            `;
        }
    } catch (error) {
        console.error('Error fetching recommendations:', error);
    }
};

// Attach event listeners to each input
Array.from(mapelInputs).forEach((mapelInput, index) => {
    const suggestionsDiv = suggestionsDivs[index];
    const mapelIdInput = mapelIdInputs[index];

    // Trigger suggestions on input
    mapelInput.addEventListener('input', () => {
        const query = mapelInput.value;

        // Clear mapel_id if the input box is empty
        if (query.trim() === '') {
            mapelIdInput.value = '';
        }

        if (query.length < 2) {
            suggestionsDiv.innerHTML = ''; // Clear suggestions for short input
            return;
        }
        fetchSuggestions(query, mapelInput, suggestionsDiv, mapelIdInput);
    });

    // Trigger suggestions on focus
    mapelInput.addEventListener('focus', () => {
        if (mapelInput.value.length < 2) {
            fetchSuggestions('', mapelInput, suggestionsDiv, mapelIdInput); // Fetch all suggestions or a default set
        }
    });

    // Add event listener for suggestion clicks
    suggestionsDiv.addEventListener('click', (event) => {
        const clickedItem = event.target.closest('.suggestion-item');
        if (clickedItem) {
            mapelInput.value = clickedItem.dataset.name; // Set the input value with the mapel name
            mapelIdInput.value = clickedItem.dataset.id; // Set the hidden input with the mapel id
            suggestionsDiv.innerHTML = ''; // Clear the suggestions
        }
    });

    // Hide suggestions on blur
    mapelInput.addEventListener('blur', () => {
        setTimeout(() => {
            suggestionsDiv.innerHTML = ''; // Delay to allow click event to register
        }, 100);
    });
});

</script>
@endsection
@endsection
