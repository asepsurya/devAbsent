{{-- Plugin terpasang --}}
<div id="plugin">
@can('import')
    <li class="{{ Request::is('akademik/plugin/import') ? 'active' : ''}}">
        <a href="{{ route('dataImport') }}">
            <i class="ti ti-file-excel"></i><span>Import Data</span>
        </a>
    </li>
@endcan 
{{--

--}}
{{--

--}}

</div>
