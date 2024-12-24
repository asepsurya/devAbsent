<div class="tab-pane" id="bottom-tab4" role="tabpanel">
    <div class="bg-white p-3 border rounded-1 d-flex align-items-center justify-content-between flex-wrap mb-4 pb-0">
        <h4 class="mb-3">Daftar Nilai</h4>
        <div class="d-flex align-items-center flex-wrap">
            <div class="d-flex align-items-center flex-wrap">
                <a href="{{ route('export.score',$id) }}">
                <button  class="btn btn-primary btn-small mb-3"><span class="ti ti-download"></span> Cetak PDF</button></a>
            </div>
        </div>
    </div>

    <div class="table-resphonsive">
        <table class="table">
            <thead>
                <tr>
                    <th class="border">Name</th>
                    @foreach ($task as $item)
                        <th class="border">{{ \Str::limit($item->judul, 20) }}</th>
                    @endforeach
                    <th class="border">Total Score</th>
                </tr>
            </thead>
        
            <tbody>
                @if ($peserta->count())
                    @foreach ($peserta as $item)
                        <tr class="border">
                            <td class="border">
                                <div class="d-flex align-items-center">
                                    <a href="#" class="avatar avatar-md">
                                        <!-- Check if the student has a photo, if not use default -->
                                        <img src="{{ $item->peopleStudent->foto ? '/storage/' . $item->peopleStudent->foto : asset('asset/img/user-default.jpg') }}" class="img-fluid rounded-circle" alt="foto">
                                    </a>
                                    <div class="ms-2">
                                        <p class="mb-0">{{ $item->peopleStudent->nama }}</p>
                                    </div>
                                </div>
                            </td>
                            <!-- Loop through tasks and show score for each -->
                            @foreach ($task as $taskItem)
                                @php
                                    $score = $item->getScore->where('task_id', $taskItem->id)->first();
                                @endphp
                                <td class="border">{{ $score ? $score->nilai : '0' }}</td>
                            @endforeach
        
                            <!-- Calculate the total score for the student -->
                            <td class="border">
                                @php
                                  
                                    $totalScore = $item->getScore->avg('nilai');
                                @endphp
                                <div class="badge badge-soft-success d-inline-flex align-items-center">{{ $totalScore ?? '0' }}</div>
                                
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="{{ count($task) + 2 }}" class="text-center p-5">
                            Belum ada peserta yang ditambahkan
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        
    </div>
    {{-- <div class="card p-5">
        <div class="d-flex justify-content-center">
            <p>Data tidak ditemukan</p>
        </div>
    </div>  --}}

</div>
