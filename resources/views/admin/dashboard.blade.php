<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f8f8;
        }

        tr:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <p>Welcome, {{ auth()->user()->name }}!</p>
        <hr>
        <h2>User List</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Bedrijfsnaam</th>
                    <th>Straat en Huisnummer</th>
                    <th>Postcode</th>
                    <th>Plaats</th>
                    <th>Land</th>
                    <th>KVK Nummer</th>
                    <th>Telefoonnummer</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->bedrijfsnaam }}</td>
                    <td>{{ $user->straat_en_huisnummer }}</td>
                    <td>{{ $user->postcode }}</td>
                    <td>{{ $user->plaats }}</td>
                    <td>{{ $user->land }}</td>
                    <td>{{ $user->kvknummer }}</td>
                    <td>{{ $user->telefoonnummer }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br><br>
        <form action="{{ route('admin.update-price') }}" method="POST">
            @csrf
            <label for="price_per_km">Prijs per kilometer:</label>
            <input type="text" id="price_per_km" name="price_per_km" value="{{ $currentPrice }}" required>
            <button type="submit">Update Prijs</button>
        </form>
    </div>
</body>
</html>
