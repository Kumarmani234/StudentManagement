
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Information</title>
    <style>
        /* Style the table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Style the image */
        .staff-image {
            max-width: 100px;
            max-height: 100px;
        }
    </style>
</head>
<body>
    <div class="container" style="margin-top:20px">
    <h5 style="text-align: center;color:black"><b>Staff Details</b></h5>
        <table>
            <thead>
                <tr >
                <th style="text-align: center;">Image</th>
                    <th style="text-align: center;">Staff ID</th>
                    <th style="text-align: center;">Name</th>
                    <th style="text-align: center;">Gender</th>
                    <th style="text-align: center;">Date of Birth</th>
                    <th style="text-align: center;">Phone Number</th>
                    <th style="text-align: center;">Email</th>
                    <th style="text-align: center;">Staff Type</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($staffs as $staff)
                <tr>
                <td style="text-align: center;">
                        <img src="{{ asset('storage/' . $staff->image_path) }}" alt="Staff Image" height="50" width="50" class="staff-image">
                    </td>
                    <td style="text-align: center;">{{ $staff->staff_id }}</td>
                    <td style="text-align: center;">{{ $staff->first_name }} {{ $staff->last_name }}</td>
                    <td style="text-align: center;">{{ $staff->gender }}</td>
                    <td style="text-align: center;">{{ $staff->dob }}</td>
                    <td style="text-align: center;">{{ $staff->phone_no }}</td>
                    <td style="text-align: center;">{{ $staff->email }}</td>
                    <td style="text-align: center;">{{ $staff->staff_type }}</td>
            <td style="text-align: center;"><button style="background-color: blue;border-radius:5px;color:white">Edit</button>
        <button style="background-color: green;border-radius:5px;color:white">Active</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
