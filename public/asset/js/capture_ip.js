async function getPublicIP() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');  // Ambil CSRF token

    try {
        // Mengambil IP publik dengan menggunakan ipify API
        const response = await fetch('https://api.ipify.org?format=json');
        const data = await response.json();
        const ipAddress = data.ip;  // IP publik

        console.log("IP publik ditemukan:", ipAddress);

        // Kirim IP ke server
        fetch("/store-local-ip", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken  // Gunakan csrfToken yang diambil dari meta tag
            },
            body: JSON.stringify({ ip_address: ipAddress })  // Kirim IP dalam JSON
        })
        .then(response => response.json())
        .then(data => console.log("IP berhasil disimpan."))
        .catch(error => console.error("Gagal menyimpan IP:", error));
    } catch (error) {
        console.error("Gagal mendapatkan IP publik:", error);
    }
}

// Panggil fungsi saat halaman selesai diload
window.onload = getPublicIP;
