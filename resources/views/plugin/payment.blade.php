@extends('layout.main')
@section('container')
<div class="container mt-5">
    <h2 class="text-center mb-4">Form Pembayaran</h2>
    <form id="paymentForm" class="bg-light p-4 rounded shadow">
        <div class="mb-3">
            <label for="pluginName" class="form-label">Nama Plugin</label>
            <input type="text" class="form-control" id="pluginName" disabled value="Nama Plugin">
        </div>
        <div class="mb-3">
            <label for="pluginPrice" class="form-label">Harga Plugin</label>
            <input type="text" class="form-control" id="pluginPrice" disabled value="Rp 100.000">
        </div>
        <div class="mb-3">
            <label for="paymentMethod" class="form-label">Metode Pembayaran</label>
            <select class="form-select" id="paymentMethod">
                <option value="">Pilih Metode Pembayaran</option>
                <option value="bank_transfer">Transfer Bank</option>
                <option value="credit_card">Kartu Kredit</option>
                <option value="e_wallet">E-Wallet (OVO, GoPay, dll.)</option>
            </select>
        </div>
        <div class="mb-3" id="additionalDetails" style="display: none;">
            <label for="details" class="form-label">Informasi Pembayaran Tambahan</label>
            <input type="text" class="form-control" id="details" placeholder="Nomor rekening, email, dsb.">
        </div>
        <button type="submit" class="btn btn-primary w-100">Lanjutkan Pembayaran</button>
    </form>
</div>

@endsection


