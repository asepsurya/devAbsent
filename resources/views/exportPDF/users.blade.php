<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AbsensiSAKTI | Export Users</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">
    <style>
        @media print {
            @page {
                size: A4 landscape; /* Set size to A4 landscape */
                margin: 0; /* No margin for full page */
            }
            body {
                margin: 0; /* No margin for body */
                height: 100vh; /* Full height */
                width: 100vw; /* Full width */
            }
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: white; /* Background color set to white */
            margin: 0;
            padding: 20px;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #343a40; /* Darker color for better visibility */
        }
        h2 {
            font-size: 18px;
            color: #6c757d;
            margin-bottom: 20px;
        }
        a {
            color: black; /* Change link color to black */
            text-decoration: none; /* Remove underline from links */
        }
        a:hover {
            text-decoration: underline; /* Underline on hover for better visibility */
        }
        footer {
            position: fixed;
            bottom: -15mm;
            left: 0;
            right: 0;
            height: 20mm;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .table-container {
            margin-bottom: 60px; /* Ensure space for footer */
        }
        table {
            width: 100%; /* Set table width to 100% */
            border-collapse: collapse; /* Merge borders for a cleaner look */
            background-color: #f8f9fa; /* Light background for table */
        }
        th {
            background-color: #00524b; /* Bootstrap primary color */
            color: white;
            text-align: center; /* Centered header text */
            padding: 10px; /* Add padding for better spacing */
        }
        td {
            text-align: left; /* Align text to the left by default */
            padding: 8px; /* Add padding for better spacing */
            border: 1px solid #ddd; /* Add borders to table cells */
        }
        /* Center text in the first column */
        td:first-child {
            text-align: center; /* Center text in the first column */
        }
        td.status-cell {
            text-align: center; /* Ensure text is centered in the status column */
            vertical-align: middle; /* Vertically center the text */
        }
        /* Alternate row colors */
        tr:nth-child(odd) {
            background-color: #ffffff; /* White background for odd rows */
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; /* Light gray background for even rows */
        }
        tr:hover {
            background-color: #e9ecef; /* Lighter hover color */
        }
        /* Page counter */
        .page:after {
            content: counter(page);
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <h1>{{ $title }}</h1>
        <h2>Created at: {{ $date }}</h2>
        <p>Downloaded from website <a href="https://absent.saktiproject.my.id">AbsensiSAKTI</a></p>
    </header>

    <div class="container table-container">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $item)
                    <tr>
                        <td class="status-cell">{{ $loop->iteration }}</td> <!-- Rata tengah untuk nomor urut -->
                        <td>{{ $item->nomor }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->email }}</td>
                        <td class="status-cell">
                            {{ $item->status == 2 ? 'Aktif' : 'Tidak Aktif' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        &copy; 2024 AbsensiSAKTI. All rights reserved. | Page <span class="page"></span>
    </footer>

</body>
</html>
