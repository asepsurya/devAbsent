@extends('layout.main')
@section('css')
<style>
    .nav-tabs .nav-link.active {
        border-color: #ddd #ddd #054c98 !important;
        color: #1a1a1a !important;
        font-weight: 500;
    }

    .nav-tabs {
        border-bottom: 1px solid #ddd;
        background-color: #fff;
    }

    .plugin-card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 0.25rem;
        box-shadow: 0 0 3px rgb(0 0 0 / 0.1);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .plugin-card .card-body {
        flex-grow: 1;
    }

    .plugin-title {
        color: #0073aa;
        font-weight: 600;
        font-size: 1rem;
        line-height: 1.2;
    }

    .plugin-meta {
        font-size: 0.75rem;
        color: #555;
    }

    .plugin-meta i.fa-check {
        color: #008000;
    }

    .btn-install {
        font-size: 0.75rem;
        color: #0073aa;
        border: 1px solid #0073aa;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        background-color: transparent;
    }

    .btn-install:hover {
        background-color: #e6f0fa;
        color: #005177;
        border-color: #005177;
    }

    .plugin-description {
        font-size: 0.75rem;
        color: #1a1a1a;
        margin-top: 0.5rem;
        max-width: 180px;
    }

    .plugin-author {
        font-size: 0.75rem;
        font-style: italic;
        color: #555;
        max-width: 180px;
    }

    .rating-stars {
        color: #f6b900;
        font-size: 0.75rem;
    }

    .rating-stars .fa-star.gray {
        color: #ccc;
    }

    .plugin-footer {
        font-size: 0.75rem;
        color: #555;
        border-top: 1px solid #ddd;
        padding: 0.5rem 1rem;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .plugin-footer .left,
    .plugin-footer .right {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .plugin-footer .right p {
        margin: 0;
    }

    .plugin-card img {
        object-fit: cover;
        height: 100px;
        width: 100px;
        border-radius: 8px;
        border: 1px solid #ccc;
    }

    .plugin-card img {
        object-fit: cover;
        height: 80px;
        width: 80px;
        border-radius: 8px;
        border: 1px solid #ccc;
    }

    .content.blank-page {
        padding: 0px;
        margin: 0px;
    }
</style>
<style>
    .plugin-footer {
        padding: 10px;
        border-top: 1px solid #eee;
    }

    .rating-stars i {
        color: #f1c40f;
    }

    .plugin-card .text-muted {
        font-size: 0.9rem;
    }

    .plugin-card .text-end p {
        font-size: 0.85rem;
    }

    .plugin-card .btn-primary:hover {
        background-color: #007bff;
        border-color: #007bff;
    }



    /* Loading Spinner */
    .spinner {
        display: none;
        width: 3rem;
        height: 3rem;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #007bff;
        border-radius: 50%;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
    footer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        z-index: 10;
    }
    .btn-close {
      color: #000;
    }
</style>
@endsection
@section('container')

    <ul class="nav nav-tabs mb-3 p-2 " id="pluginTabs" role="tablist" style="margin-top:-20px;">
        <li class="ms-2">
            <h2 class="mt-2 mb-0"><span class="ti ti-brand-appstore"></span> Apps Store</h2>
        </li>
        <li class="ms-auto d-flex align-items-center gap-2">
            <input class="form-control " id="searchPlugin" style="max-width: 200px;" type="search"
                oninput="searchPlugin()" placeholder="Cari plugin...">
        </li>
        <li>
            <a href="/plugin/import" class="ms-2 btn btn-outline-primary">Unggah Plugin</a>
        </li>
    </ul>

    <!-- Modal Detail Plugin -->
    <!-- Modal Detail Plugin -->
    <div class="modal fade" id="pluginDetailModal" tabindex="-1" aria-labelledby="pluginDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pluginDetailModalLabel">Detail Plugin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div id="pluginDetailContent"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="px-3 mb-3">
        <div class="alert alert-info alert-dismissible fade show " role="alert">
            <strong>Mohon Perhatian!</strong> Demi kenyamanan anda. Jika dibrowser ini terinstal exstensi IDM, Mohon di non-aktifkan dan restart kembali browser anda.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
 

    <div class="row g-3 mx-3" id="plugin-list">
        <!-- Plugin cards will be loaded here -->
    </div>
    <div id="loadingSpinner" style="display: none; text-align: center; margin-top: 20px;" class="pt-5 ">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>


<footer class="text-white py-2 bg-white border">
    <div class="text-center ">
        <p class="mb-0 text-muted">© 2025 ScrollWebID. All Rights Reserved.</p>
    </div>
</footer>

@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var body = document.body;
    body.classList.add("mini-sidebar");
</script>
<script>
    const API_URL = 'https://admin.scrollwebid.com/api/plugin/list?token=PZV3QbOmeSzE';
    let allPlugins = [];
    document.getElementById('loadingSpinner').style.display = 'block';
    // Fungsi untuk mengambil data dari API
    async function fetchPlugins() {
        document.getElementById('loadingSpinner').style.display = 'block'; // Show loading spinner
        try {
            const response = await fetch(API_URL);
            if (!response.ok) throw new Error('Data gagal diambil');

            const result = await response.json();
            allPlugins = result.data; // Save all plugins
            renderPlugins(allPlugins); // Render all plugins initially
        } catch (error) {
            console.error(error.message);
        } finally {
            document.getElementById('loadingSpinner').style.display = 'none'; // Hide loading spinner
        }
    }

    // Fungsi untuk menampilkan data ke halaman
        function renderPlugins(plugins) {
            const pluginList = document.getElementById('plugin-list');
            pluginList.innerHTML = '';

            // Filter plugin yang memiliki status 1 (aktif)
            const activePlugins = plugins.filter(plugin => plugin.status === '1');

            // Jika tidak ada plugin yang aktif, tampilkan pesan
            if (activePlugins.length === 0) {
                pluginList.innerHTML = '<p class="text-center p-5">Data Tidak Ditemukan.</p>';
                return;
            }

            activePlugins.forEach((plugin, index) => {
                pluginList.innerHTML += `
                    <div class="col-12 col-md-4">
                        <div class="plugin-card">
                            <div class="d-flex p-3 gap-3">
                                <img src="https://admin.scrollwebid.com/storage/${plugin.logo}"
                                    alt="${plugin.plugin_name}"
                                    class="rounded" width="80">
                                <div>
                                    <h5 class="fw-bold">${plugin.plugin_name}</h5>
                                    <div class="d-flex gap-3 mt-2">
                                        <button id="install-btn-${plugin.id}" class="btn btn-primary btn-sm" onclick="installPlugin('${plugin.plugin_name}', 'https://admin.scrollwebid.com/storage/${plugin.plugin_file}', ${plugin.id}, ${plugin.harga}, this)">Instal Sekarang</button>
                                        <a href="#" class="text-primary small align-self-center" onclick="showDetail(${index})">Rincian Lengkap</a>
                                    </div>
                                    <p class="mt-2 text-muted">
                                        ${plugin.description.length > 80 ? plugin.description.substring(0, 80) + "..." : plugin.description}
                                    </p>
                                    <p class="text-secondary small">Versi: ${plugin.versi}</p>
                                </div>
                            </div>
                            <div class="plugin-footer d-flex justify-content-between">
                                <div>
                                    <span class="rating-stars">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </span>

                                </div>
                                <div class="text-end">
                                    <p class="mb-0 fw-semibold">Diperbarui: <span class="fw-normal">${new Date(plugin.updated_at).toLocaleDateString()}</span></p>
                                    <p class="mb-0 text-success"><i class="fa-solid fa-check"></i> Kompatibel</p>
                                    <p class="mb-0">Harga : <b>${plugin.harga == 0 ? 'Gratis' : 'Rp ' + parseInt(plugin.harga).toLocaleString('id-ID')}</b></p>

                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
        }


    // Fungsi untuk menampilkan detail plugin di modal
    function showDetail(index) {
    const plugin = allPlugins[index];
    const modalContent = document.getElementById('pluginDetailContent');

    // Menambahkan HTML yang lebih terstruktur dan rapi
    modalContent.innerHTML = `
        <div class="text-center mb-3">
            <img src="https://admin.scrollwebid.com/storage/${plugin.logo}"
                 alt="${plugin.plugin_name}" class="rounded-circle mb-3" width="150">
        </div>
        <h4 class="text-primary fw-bold">${plugin.plugin_name}</h4>
        <p class="text-muted">${plugin.description}</p>

        <div class="d-flex justify-content-between mt-3">
            <div>
                <p><strong>Versi:</strong> ${plugin.versi}</p>
                <p><strong>Harga:</strong> ${plugin.harga == 0 ? 'Gratis' : 'Rp ' + parseInt(plugin.harga).toLocaleString('id-ID')}</p>
            </div>
            <div class="text-end">
                <p><strong>Terakhir Diperbarui:</strong> ${new Date(plugin.updated_at).toLocaleDateString()}</p>
                <p><strong>Hak Cipta :</strong> © ScroolWebID</p>
            </div>
        </div>

        <hr>
        <div class="text-center">
             <button id="install-btn-${plugin.id}" class="btn btn-primary w-100" onclick="installPlugin('${plugin.plugin_name}', 'https://admin.scrollwebid.com/storage/${plugin.plugin_file}', ${plugin.id}, ${plugin.harga}, this)">Instal Sekarang</button>
        </div>
    `;

    // Tampilkan modal menggunakan Bootstrap
    const myModal = new bootstrap.Modal(document.getElementById('pluginDetailModal'));
    myModal.show();
}

async function installPlugin(pluginName, pluginUrl, pluginid, harga, button) {
    if (harga > 0) {
        Swal.fire({
            title: 'Plugin Berbayar',
            text: `Plugin "${pluginName}" memiliki harga dan Anda akan diarahkan ke halaman pembayaran.`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan Pembayaran',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/plugin/payment/${pluginid}`;
            } else {
                button.innerText = 'Instal Sekarang';
                button.disabled = false;
            }
        });
        return;
    }

    button.innerText = 'Mengunduh Plugin...';
    button.disabled = true;

    try {
        // ✅ Langkah 1: Download ZIP dari server Laravel
        const downloadResponse = await fetch('/plugin/download', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                plugin_url: pluginUrl,
                plugin_name: pluginName,
                plugin_id: pluginid
            })
        });

        if (!downloadResponse.ok) throw new Error('Gagal mengunduh plugin');

        const downloadResult = await downloadResponse.json();
        if (!downloadResult.success) {
            Swal.fire({
                title: 'Gagal Mengunduh Plugin',
                text: downloadResult.message,
                icon: 'error',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-danger'
                },
                buttonsStyling: false
            }).then(() => {
                button.innerText = 'Instal Sekarang';
                button.disabled = false;
            });
            return;
        }


        // ✅ Langkah 2: Ambil Blob dari URL hasil download
        button.innerText = 'Menginstal...';

        const blob = await fetch(downloadResult.file_path).then(res => res.blob());

        // ✅ Buat FormData untuk kirim ke Laravel
        const formData = new FormData();
        formData.append('plugin_zip', blob, `${pluginName}.zip`);
        formData.append('api_id', pluginid);

        // ✅ Kirim ke Laravel untuk proses import
        const installResponse = await fetch('/plugin/import/action', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        });

        const installResult = await installResponse.json();
        if (installResult.success) {
            Swal.fire({
            title: 'Berhasil!',
            text: `Plugin "${pluginName}" berhasil diinstal!`,
            icon: 'success',
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'btn btn-success'
            },
            buttonsStyling: false
        }).then(() => {
            window.location.reload();
        });

        } else {
            Swal.fire({
                title: 'Gagal Menginstal Plugin',
                text: `${installResult.message}`,
                icon: 'error',
                confirmButtonText: 'Coba Lagi',
                customClass: {
                    confirmButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });

        }
    } catch (error) {
        console.error(error.message);
        Swal.fire({
            title: 'Terjadi Kesalahan',
            text: 'Terjadi kesalahan saat proses instalasi plugin.',
            icon: 'error',
            confirmButtonText: 'Coba Lagi',
            customClass: {
                confirmButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });

    } finally {
        button.innerText = 'Instal Sekarang';
        button.disabled = false;
    }
}



    // Fungsi pencarian plugin
    function searchPlugin() {
        const query = document.getElementById('searchPlugin').value.toLowerCase();
        const filteredPlugins = allPlugins.filter(plugin =>
            plugin.plugin_name.toLowerCase().includes(query) || plugin.description.toLowerCase().includes(query)
        );
        renderPlugins(filteredPlugins);
    }
    // Panggil fungsi ketika halaman di-load
    window.onload = fetchPlugins;
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
@endsection
