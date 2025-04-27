@extends('layout.main')
@section('css')
<!-- TinyMCE CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.6.0/tinymce.min.js" integrity="sha512-/4EpSbZW47rO/cUIb0AMRs/xWwE8pyOLf8eiDWQ6sQash5RP1Cl8Zi2aqa4QEufjeqnzTK8CLZWX7J5ZjLcc1Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
    /* .myeditorView .tox-tinymce {

    } */
    .cc {
        background-color: white;
    }

    html .darkmode .cc,
    html[data-theme=dark] .cc {
        background: #0f0c1c;
        border-bottom-color: #1b1632
    }


    @media (max-width: 767.98px) {
        .nav-tabs {
            border-bottom: 0;
            position: relative;
            background-color: #fff;
            border: none;
            padding: 5px 0;
            border-radius: 3px;
        }

        .scrollable-table {
            max-height: 300px;
            /* Adjust height as needed */
            overflow-y: auto;
            border: 1px solid #dee2e6;
            /* Optional border for clarity */
        }

    }


</style>

@endsection
@section('container')
{{-- header --}}

<ul class="nav nav-tabs nav-tabs-bottom mb-3 border-bottom mt-0 cc  " role="tablist" style="position: fixed; z-index: 998; width: 100%; top:55px; ">
    <li class="nav-item" role="presentation">
        <a
        @if(Request::is('classroom/detail/tugas*'))
            class="btn" onclick="event.preventDefault(); setTimeout(function(){ window.location.href='/classroom/detail/{{ $id_kelas }}'; }, 50);"
        @else
             class="nav-link "
            href="#bottom-tab1"
            data-bs-toggle="tab"
            aria-selected="true"
            role="tab"
        @endif
            ><strong><span class="ti ti-cast"></span> Forum</strong></a>
    </li>
    @if(auth()->user()->role !=="siswa")
        <li class="nav-item" role="presentation">
            <a
            @if(Request::is('classroom/detail/tugas*'))
                 class="btn" onclick="event.preventDefault(); setTimeout(function(){ window.location.href='/classroom/detail/{{ $id_kelas }}'; }, 50);"
            @else
                class="nav-link"
                href="#bottom-tab2"
                data-bs-toggle="tab"
                aria-selected="true"
                role="tab"
            @endif
            ><strong><span class="ti ti-text-plus"></span> Tugas Kelas</strong></a>
        </li>
    @endif

    <li class="nav-item" role="presentation">
        <a
        @if(Request::is('classroom/detail/tugas*'))
             class="btn" onclick="event.preventDefault(); setTimeout(function(){ window.location.href='/classroom/detail/{{ $id_kelas }}'; }, 50);"
        @else
            class="nav-link"
            href="#bottom-tab3"
            data-bs-toggle="tab"
            aria-selected="true"
            role="tab"
        @endif
        ><strong><span class="ti ti-friends"></span> Orang</strong></a>
    </li>

    @if(auth()->user()->role !=="siswa")
    <li class="nav-item" role="presentation">
        <a
        @if(Request::is('classroom/detail/tugas*'))
            class="btn" onclick="event.preventDefault(); setTimeout(function(){ window.location.href='/classroom/detail/{{ $id_kelas }}'; }, 50);"
        @else
            class="nav-link"
            href="#bottom-tab4"
            data-bs-toggle="tab"
            aria-selected="true"
            role="tab"
        @endif
        ><strong><span class="ti ti-brand-coreos"></span> Nilai</strong></a>
    </li>
    @endif
</ul>

    @yield('content')

    @section('javascript')
        @yield('myjavascript')

        <script>
            var body = document.body;
            body.classList.add("mini-sidebar");
            // Select all elements with the 'blank-page' class
            var elements = document.querySelectorAll('.blank-page');
            document.querySelector('.header').style.borderBottom = 'none';
            // Loop through the elements and remove the class from each
            elements.forEach(function(element) {
            element.classList.remove('blank-page');
            element.classList.remove('content');
            });

        </script>
    @endsection
@endsection
