<div id="plugin">
@can('Kalender Akademik')
<ul>
    <li class="{{ Request::is('kalender') ? 'active' : ''}}">
            <a href="/kalender">
                <i class="ti ti-calendar"></i><span>Kalender Akademik</span>
            </a>
    </li>
</ul>
@endcan 
{{--

--}}
@can('import')
<ul>
    <li class="{{ Request::is('import') ? 'active' : ''}}">
        <a href="/import">
            <i class="ti ti-file-excel"></i><span>Import Data</span>
        </a>
    </li>
</ul>
@endcan 
@can('card')
<ul>
    <li class="{{ Request::is('card') ? 'active' : ''}}">
        <a href="/card">
            <i class="ti ti-cards"></i><span>Mesin Cetak Kartu </span>
        </a>
    </li>
</ul>
@endcan 
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
{{--

--}}
{{--

--}}
{{--

--}}
{{--

--}}
{{--

--}}
{{--

--}}
</div>