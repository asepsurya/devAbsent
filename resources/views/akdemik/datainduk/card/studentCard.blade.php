<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table with Dropdown Detail</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .dropdown-detail {
            display: none;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2>Table with Dropdown Detail</h2>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Age</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>John Doe</td>
                <td>30</td>
                <td><button class="btn btn-info btn-sm" onclick="toggleDetail(0)">Show Details</button></td>
            </tr>
            <tr class="dropdown-detail" id="detail-0">
                <td colspan="3">
                    <div class="p-3">
                        <p>John is a software developer with 10 years of experience. He specializes in web development and enjoys hiking in his free time.</p>
                    </div>
                </td>
            </tr>

            <tr>
                <td>Jane Smith</td>
                <td>28</td>
                <td><button class="btn btn-info btn-sm" onclick="toggleDetail(1)">Show Details</button></td>
            </tr>
            <tr class="dropdown-detail" id="detail-1">
                <td colspan="3">
                    <div class="p-3">
                        <p>Jane is a project manager with expertise in Agile methodologies. She loves traveling and photography.</p>
                    </div>
                </td>
            </tr>

            <tr>
                <td>Mike Johnson</td>
                <td>35</td>
                <td><button class="btn btn-info btn-sm" onclick="toggleDetail(2)">Show Details</button></td>
            </tr>
            <tr class="dropdown-detail" id="detail-2">
                <td colspan="3">
                    <div class="p-3">
                        <p>Mike is a senior graphic designer. He has a passion for creating visually appealing designs and plays guitar in a band.</p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Add Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<script>
    function toggleDetail(rowIndex) {
        var detailRow = document.getElementById('detail-' + rowIndex);
        var toggleBtn = detailRow.previousElementSibling.querySelector('button');

        // Toggle visibility of the dropdown detail
        if (detailRow.style.display === 'table-row') {
            detailRow.style.display = 'none';
            toggleBtn.textContent = 'Show Details';
        } else {
            detailRow.style.display = 'table-row';
            toggleBtn.textContent = 'Hide Details';
        }
    }
</script>

</body>
</html>
