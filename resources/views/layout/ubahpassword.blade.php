
{{-- modal tambah Hari Libur --}}
<div class="modal fade" id="changePassword" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="ti ti-pencil-plus"></span> Ubah Kata Sandi</h4>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form action="{{ route('changePassword') }}" method="POST">
                @csrf
                <div class="modal-body">

                    <div class="row">
                            <div class="col-md-12">
                                <input type="text" name="id" value="{{ auth()->user()->id }}" hidden>
                                <input type="text" name="passType" value="student" hidden>
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" value="{{ auth()->user()->nama }}" class="form-control" disabled>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kata Sandi</label>
                                    <div class="pass-group mb-3">
                                        <input type="password" class="pass-input form-control" placeholder="Masukan Kata Sandi" name="password">
                                        <span class="ti toggle-password ti-eye-off"></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ulangi Kata Sandi</label>
                                    <div class="pass-group mb-3">
                                        <input type="password" class="pass-input form-control" placeholder="Masukan Kata Sandi" name="cpassword">
                                        <span class="ti toggle-password ti-eye-off"></span>
                                    </div>
                                </div>

                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100"><span class="ti ti-pencil-plus"></span> Ubah</button>
            </form>
        </div>

    </div>
</div>
</div>

