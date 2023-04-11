<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>席替えアプリ</title>
    <style>
        /* 全体のスタイル設定 */
        html,
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }

        /* アプリコンテナのスタイル設定 */
        #app {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1rem;
        }

        /* タイトルのスタイル設定 */
        h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 1rem;
        }

        /* ボタンのスタイル設定 */
        button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #45a049;
        }

        /* 入力フォームのスタイル設定 */
        input[type=text] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 4px;
        }

        /* テーブルのスタイル設定 */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 1rem;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
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
