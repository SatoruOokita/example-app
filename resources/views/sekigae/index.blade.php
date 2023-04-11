<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>席替えアプリ</title>
</head>

<body>
    <h1>席替えアプリ</h1>

    <form action="{{ route('sekigae.generate') }}" method="post">
        @csrf
        <label for="students">生徒の人数:</label>
        <input type="number" id="students" name="students" value="{{ old('students', $students ?? '') }}" required>
        <br>
        <label for="rows">座席の行の数:</label>
        <input type="number" id="rows" name="rows" value="{{ old('rows', $rows ?? '') }}" required>
        <br>
        <label for="columns">座席の列の数:</label>
        <input type="number" id="columns" name="columns" value="{{ old('columns', $columns ?? '') }}" required>
        <br>
        <button type="submit">
            {{ isset($seats) ? '席替えのやり直し' : '席替えを生成する' }}
        </button>
    </form>

    @if (isset($seats))
        <h2>席替え結果</h2>
        <table border="1">
            @foreach ($seats as $row)
                <tr>
                    @foreach ($row as $seat)
                        <td>{{ $seat }}</td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    @endif
</body>

</html>
