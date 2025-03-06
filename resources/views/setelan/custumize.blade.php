@extends('layout.main')
@section('container')
@section('css')
<script src="{{ asset('asset/js/theme.js') }}"></script>
@endsection
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3 border-bottom">
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
<div class="row">
    <div class="col-xxl-2 col-xl-3">
        <div class="pt-3 d-flex flex-column list-group mb-4">
            <a href="{{ route('setelan.app') }}" class="d-block rounded  p-2">> Pengaturan Sekolah</a>
            <a href="{{ route('setelan.card') }}" class="d-block rounded p-2">> Pengaturan Kartu</a>
            <a href="{{ route('setelan.sistem') }}" class="d-block rounded   p-2">> Pengaturan Sistem</a>
            <a href="{{ route('setelan.customize') }}" class="d-block rounded active p-2">> Pengaturan Tampilan</a>
        </div>
    </div>
    <div class="col-xxl-10 col-xl-9">
        <div class="border-start ps-3">
            <form action="school-settings.html">
                <div class="d-flex align-items-center justify-content-between flex-wrap border-bottom pt-3 mb-3">
                    <div class="mb-3">
                        <h5 class="mb-1">Customize</h5>
                        <p>School Settings Configuration</p>
                    </div>

                </div>
                <div class="d-md-flex">
                    <div class="row flex-fill">
                        <div class="col-xl-10">
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="mb-4">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button text-dark fs-16" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#sidebarcolor"
                                                    aria-expanded="true">
                                                    Theme Colors
                                                </button>
                                            </h2>
                                            <div id="sidebarcolor" class="accordion-collapse collapse show">
                                                <div class="accordion-body pb-2">
                                                    <div class="d-flex align-items-center">
                                                        <div class="theme-colorsset me-3 mb-2">
                                                            <input type="radio" name="color" id="primaryColor"
                                                                value="primary" checked="">
                                                            <label for="primaryColor" class="primary-clr"></label>
                                                        </div>
                                                        <div class="theme-colorsset me-3 mb-2">
                                                            <input type="radio" name="color" id="violetColor"
                                                                value="violet">
                                                            <label for="violetColor" class="violet-clr"></label>
                                                        </div>
                                                        <div class="theme-colorsset me-3 mb-2">
                                                            <input type="radio" name="color" id="pinkColor"
                                                                value="pink">
                                                            <label for="pinkColor" class="pink-clr"></label>
                                                        </div>
                                                        <div class="theme-colorsset me-3 mb-2">
                                                            <input type="radio" name="color" id="orangeColor"
                                                                value="orange">
                                                            <label for="orangeColor" class="orange-clr"></label>
                                                        </div>
                                                        <div class="theme-colorsset me-3 mb-2">
                                                            <input type="radio" name="color" id="greenColor"
                                                                value="green">
                                                            <label for="greenColor" class="green-clr"></label>
                                                        </div>
                                                        <div class="theme-colorsset me-3 mb-2">
                                                            <input type="radio" name="color" id="redColor" value="red">
                                                            <label for="redColor" class="red-clr"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="mb-3">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button text-dark fs-16" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#colorsetting"
                                                    aria-expanded="true">
                                                    Top Bar Color
                                                </button>
                                            </h2>
                                            <div id="colorsetting" class="accordion-collapse collapse show" style="">
                                                <div class="accordion-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="theme-colorselect m-1 me-3">
                                                            <input type="radio" name="topbar" id="whiteTopbar"
                                                                value="white" checked="">
                                                            <label for="whiteTopbar" class="white-topbar"></label>
                                                        </div>
                                                        <div class="theme-colorselect m-1 me-3">
                                                            <input type="radio" name="topbar" id="darkTopbar"
                                                                value="dark">
                                                            <label for="darkTopbar" class="dark-topbar"></label>
                                                        </div>
                                                        <div class="theme-colorselect m-1 me-3">
                                                            <input type="radio" name="topbar" id="primaryTopbar"
                                                                value="primary">
                                                            <label for="primaryTopbar" class="primary-topbar"></label>
                                                        </div>
                                                        <div class="theme-colorselect m-1">
                                                            <input type="radio" name="topbar" id="greyTopbar"
                                                                value="grey">
                                                            <label for="greyTopbar" class="grey-topbar"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="mb-3">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button text-dark fs-16" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#modesetting"
                                                    aria-expanded="true">
                                                    Global Color Mode
                                                </button>
                                            </h2>
                                            <div id="modesetting" class="accordion-collapse collapse show">
                                                <div class="accordion-body">
                                                    <div class="row gx-3">
                                                        <div class="col-6">
                                                            <div class="theme-mode">
                                                                <input type="radio" name="theme" id="lightTheme"
                                                                    value="light" checked="">
                                                                <label for="lightTheme"
                                                                    class="p-2 rounded fw-medium w-100">
                                                                    <span
                                                                        class="avatar avatar-md d-inline-flex rounded me-2"><i
                                                                            class="ti ti-brightness-up"></i></span>Light
                                                                    Mode
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="theme-mode">
                                                                <input type="radio" name="theme" id="darkTheme"
                                                                    value="dark">
                                                                <label for="darkTheme"
                                                                    class="p-2 rounded fw-medium w-100">
                                                                    <span
                                                                        class="avatar avatar-md d-inline-flex rounded me-2"><i
                                                                            class="ti ti-moon"></i></span>Dark
                                                                    Mode
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button text-dark fs-16" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#sidebarsetting"
                                                aria-expanded="true">
                                                Sidebar Color
                                            </button>
                                        </h2>
                                        <div id="sidebarsetting" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="theme-colorselect m-1 me-3">
                                                        <input type="radio" name="sidebar" id="lightSidebar"
                                                            value="light" checked="">
                                                        <label for="lightSidebar" class="d-block rounded mb-2">
                                                        </label>
                                                    </div>
                                                    <div class="theme-colorselect m-1 me-3">
                                                        <input type="radio" name="sidebar" id="darkSidebar"
                                                            value="dark">
                                                        <label for="darkSidebar" class="d-block rounded bg-dark mb-2">
                                                        </label>
                                                    </div>
                                                    <div class="theme-colorselect m-1 me-3">
                                                        <input type="radio" name="sidebar" id="primarySidebar"
                                                            value="primary">
                                                        <label for="primarySidebar"
                                                            class="d-block rounded bg-primary mb-2">
                                                        </label>
                                                    </div>
                                                    <div class="theme-colorselect m-1 me-3">
                                                        <input type="radio" name="sidebar" id="darkblackSidebar"
                                                            value="darkblack">
                                                        <label for="darkblackSidebar"
                                                            class="d-block rounded bg-darkblack mb-2">
                                                        </label>
                                                    </div>
                                                    <div class="theme-colorselect m-1">
                                                        <input type="radio" name="sidebar" id="darkblueSidebar"
                                                            value="darkblue">
                                                        <label for="darkblueSidebar"
                                                            class="d-block rounded bg-darkblue mb-2">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@section('javascript')
<script>
   document.addEventListener("DOMContentLoaded", function () {
    const themeRadios = document.querySelectorAll('input[name="theme"]'); const sidebarRadios = document.querySelectorAll('input[name="sidebar"]'); const colorRadios = document.querySelectorAll('input[name="color"]'); const layoutRadios = document.querySelectorAll('input[name="LayoutTheme"]'); const topbarRadios = document.querySelectorAll('input[name="topbar"]'); const sidebarBgRadios = document.querySelectorAll('input[name="sidebarbg"]'); const resetButton = document.getElementById('resetbutton'); const sidebarBgContainer = document.getElementById('sidebarbgContainer'); const sidebarElement = document.querySelector('.sidebar'); function setThemeAndSidebarTheme(theme, sidebarTheme, color, layout, topbar) {
        if (!sidebarElement) { console.error('Sidebar element not found'); return; }
        document.documentElement.setAttribute('data-theme', theme); document.documentElement.setAttribute('data-sidebar', sidebarTheme); document.documentElement.setAttribute('data-color', color); document.documentElement.setAttribute('data-layout', layout); document.documentElement.setAttribute('data-topbar', topbar); if (layout === 'mini') { document.body.classList.add("mini-sidebar"); document.body.classList.remove("layout-box-mode"); } else if (layout === 'box') { document.body.classList.add("layout-box-mode"); document.body.classList.remove("mini-sidebar"); } else { document.body.classList.remove("layout-box-mode", "mini-sidebar"); }
        localStorage.setItem('theme', theme); localStorage.setItem('sidebarTheme', sidebarTheme); localStorage.setItem('color', color); localStorage.setItem('layout', layout); localStorage.setItem('topbar', topbar); if (layout === 'box' && sidebarBgContainer) { sidebarBgContainer.classList.add('show'); } else if (sidebarBgContainer) { sidebarBgContainer.classList.remove('show'); }
    }
    function handleSidebarBgChange() { const sidebarBg = document.querySelector('input[name="sidebarbg"]:checked') ? document.querySelector('input[name="sidebarbg"]:checked').value : null; if (sidebarBg) { document.body.setAttribute('data-sidebarbg', sidebarBg); localStorage.setItem('sidebarBg', sidebarBg); } else { document.body.removeAttribute('data-sidebarbg'); localStorage.removeItem('sidebarBg'); } }
    function handleInputChange() { const theme = document.querySelector('input[name="theme"]:checked').value; const sidebarTheme = document.querySelector('input[name="sidebar"]:checked').value; const color = document.querySelector('input[name="color"]:checked').value; const layout = document.querySelector('input[name="LayoutTheme"]:checked').value; const topbar = document.querySelector('input[name="topbar"]:checked').value; setThemeAndSidebarTheme(theme, sidebarTheme, color, layout, topbar); }
    function resetThemeAndSidebarThemeAndColorAndBg() {
        setThemeAndSidebarTheme('light', 'light', 'primary', 'default', 'white'); document.body.removeAttribute('data-sidebarbg'); document.getElementById('lightTheme').checked = true; document.getElementById('lightSidebar').checked = true; document.getElementById('primaryColor').checked = true; document.getElementById('defaultLayout').checked = true; document.getElementById('whiteTopbar').checked = true; const checkedSidebarBg = document.querySelector('input[name="sidebarbg"]:checked'); if (checkedSidebarBg) { checkedSidebarBg.checked = false; }
        localStorage.removeItem('sidebarBg');
    }
    themeRadios.forEach(radio => radio.addEventListener('change', handleInputChange)); sidebarRadios.forEach(radio => radio.addEventListener('change', handleInputChange)); colorRadios.forEach(radio => radio.addEventListener('change', handleInputChange)); layoutRadios.forEach(radio => radio.addEventListener('change', handleInputChange)); topbarRadios.forEach(radio => radio.addEventListener('change', handleInputChange)); sidebarBgRadios.forEach(radio => radio.addEventListener('change', handleSidebarBgChange)); resetButton.addEventListener('click', resetThemeAndSidebarThemeAndColorAndBg); const savedTheme = localStorage.getItem('theme') || 'light'; const savedSidebarTheme = localStorage.getItem('sidebarTheme') || 'light'; const savedColor = localStorage.getItem('color') || 'primary'; const savedLayout = localStorage.getItem('layout') || 'default'; const savedTopbar = localStorage.getItem('topbar') || 'white'; const savedSidebarBg = localStorage.getItem('sidebarBg') || null; setThemeAndSidebarTheme(savedTheme, savedSidebarTheme, savedColor, savedLayout, savedTopbar); if (savedSidebarBg) { document.body.setAttribute('data-sidebarbg', savedSidebarBg); } else { document.body.removeAttribute('data-sidebarbg'); }
    if (document.getElementById(`${savedTheme}Theme`)) { document.getElementById(`${savedTheme}Theme`).checked = true; }
    if (document.getElementById(`${savedSidebarTheme}Sidebar`)) { document.getElementById(`${savedSidebarTheme}Sidebar`).checked = true; }
    if (document.getElementById(`${savedColor}Color`)) { document.getElementById(`${savedColor}Color`).checked = true; }
    if (document.getElementById(`${savedLayout}Layout`)) { document.getElementById(`${savedLayout}Layout`).checked = true; }
    if (document.getElementById(`${savedTopbar}Topbar`)) { document.getElementById(`${savedTopbar}Topbar`).checked = true; }
    if (savedSidebarBg && document.getElementById(`${savedSidebarBg}`)) { document.getElementById(`${savedSidebarBg}`).checked = true; }
    if (savedLayout !== 'box' && sidebarBgContainer) { sidebarBgContainer.classList.remove('show'); }
});
</script>
@endsection

@endsection
