{{-- Plugin terpasang --}}
<div id="plugin">
@can('Ruangan Kelas')
<ul>
    <li class="{{ Request::is('classroom*') ? 'active' : ''}}">
        <a href="/classroom">
            <i class="ti ti-building"></i><span>Ruangan Kelas</span>
        </a>
    </li>
</ul>
@endcan
{{--

--}}
{{--

--}}
{{--

--}}
{{--

--}}
@can('Kalender Akademik')
<ul>
    <li class="{{ Request::is('kalender') ? 'active' : ''}}">
            <a href="/kalender">
                <i class="ti ti-calendar"></i><span>Kalender Akademik</span>
            </a>
    </li>
</ul>
@endcan

@can('import')
<ul>
    <li class="{{ Request::is('akademik/plugin/import') ? 'active' : ''}}">
        <a href="{{ route('dataImport') }}">
            <i class="ti ti-file-excel"></i><span>Import Data</span>
        </a>
    </li>
</ul>
@endcan


</div>
