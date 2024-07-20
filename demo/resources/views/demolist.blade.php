<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        table {
            width: 800px;
            margin: auto;
            text-align: center;
        }
        th,
        td {
            border: 1px solid;
            padding: 8px;
        }
        h1 {
            text-align: center;
            color: red;
        }
        #button {
            margin: 2px;
            margin-right: 10px;
            float: right;
        }
    </style>
</head>
<body>
    <h1>Quản lý cầu thủ</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên cầu thủ</th>
                <th>Tuổi</th>
                <th>Quốc tịch</th>
                <th>Vị trí</th>
                <th>Lương</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach($players as $player)
            <tr>
                <td>{{ $player->id }}</td>
                <td>{{ $player->Ten_cau_thu }}</td>
                <td>{{ $player->Tuoi }}</td>
                <td>{{ $player->Quoc_tich }}</td>
                <td>{{ $player->Vi_tri }}</td>
                <td>{{ $player->Luong }}</td>
                <td><a href="{{ route('players.edit', $player->id) }}">Edit</a></td>
                <td><a href="{{ route('players.delete', $player->id) }}">Delete</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('players.add') }}"><button>Quay lại trang thêm cầu thủ</button></a>
</body>
</html>
