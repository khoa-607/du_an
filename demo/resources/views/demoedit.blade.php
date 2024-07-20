<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Player</title>
</head>
<body>
    <h1>Edit Player</h1>
    <form action="{{ route('players.update', $player->id) }}" method="POST">
        @csrf
        <input type="text" name="name" value="{{ $player->Ten_cau_thu }}"><br>
        <input type="text" name="age" value="{{ $player->Tuoi }}"><br>
        <input type="text" name="national" value="{{ $player->Quoc_tich }}"><br>
        <input type="text" name="position" value="{{ $player->Vi_tri }}"><br>
        <input type="text" name="salary" value="{{ $player->Luong }}"><br>
        <button type="submit">Save</button>
    </form>
    <a href="{{ route('players.add') }}"><button>Quay lại trang thêm cầu thủ</button></a>
</body>
</html>
