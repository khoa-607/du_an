<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Player</title>
    <style>
        .alert {
            color: red;
        }
    </style>
</head>
<body>
    <!-- <h1>Danh sách cầu thủ</h1>
    <form action="{{ route('players.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Name"><br>
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>
        <input type="text" name="age" placeholder="Age"><br>
        @error('age')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>
        <input type="text" name="national" placeholder="Nationality"><br>
        @error('national')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>
        <input type="text" name="position" placeholder="Position"><br>
        @error('position')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>
        <input type="text" name="salary" placeholder="Salary"><br>
        @error('salary')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>
        <button type="submit"> Thêm cầu thủ </button>
    </form>

    <a href="{{ route('players.list') }}"><button>Danh sách cầu thủ</button></a> -->

    <h1>Danh sách cầu thủ:</h1>
    <form action="{{ route('players.store') }}" method="POST">
        @csrf
        <h4>Name:</h4>
        <input type="text" name="name" placeholder="Name"><br>
        @if ($errors->has('name'))
            <div class="alert alert-danger">{{ $errors->first('name') }}</div>
        @endif
        <h4>Age:</h4>
        <input type="text" name="age" placeholder="Age"><br>
        @if ($errors->has('age'))
            <div class="alert alert-danger">{{ $errors->first('age') }}</div>
        @endif
        <h4>National:</h4>
        <input type="text" name="national" placeholder="Nationality"><br>
        @if ($errors->has('national'))
            <div class="alert alert-danger">{{ $errors->first('national') }}</div>
        @endif
        <h4>Position:</h4>
        <input type="text" name="position" placeholder="Position"><br>
        @if ($errors->has('position'))
            <div class="alert alert-danger">{{ $errors->first('position') }}</div>
        @endif
        <h4>Salary:</h4>
            <input type="text" name="salary" placeholder="Salary"><br>
        @if ($errors->has('salary'))
            <div class="alert alert-danger">{{ $errors->first('salary') }}</div>
        @endif
        <br>
        <button type="submit"> Thêm cầu thủ </button>
    </form>

    <a href="{{ route('players.list') }}"><button>Danh sách cầu thủ</button></a>
</body>
</html>
