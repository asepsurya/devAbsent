<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export PDF</title>
    <!-- Include Bootstrap 4 CDN (or Bootstrap 5 if you're using that) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        .badge {
            display: inline-block;
            padding: 3px 6px;
            background-color: #28a745;
            color: white;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="my-4">Participant Scores</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    @foreach ($task as $item)
                        <th>{{ \Str::limit($item->judul, 20) }}</th>
                    @endforeach
                    <th>Total Score</th>
                </tr>
            </thead>
            <tbody>
                @if ($peserta->count())
                    @foreach ($peserta as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    
                                    {{ $item->peopleStudent->nama }}
                                </div>
                            </td>
                            @foreach ($task as $taskItem)
                                @php
                                    $score = $item->getScore->where('task_id', $taskItem->id)->first();
                                @endphp
                                <td>{{ $score ? $score->nilai : '0' }}</td>
                            @endforeach
                            <td>
                                @php
                                    $totalScore = $item->getScore->avg('nilai');
                                @endphp
                                <span class="badge">{{ $totalScore ?? '0' }}</span>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="{{ count($task) + 2 }}" class="text-center py-4">
                            No participants added yet.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</body>
</html>
