<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>席替え結果</title>
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
    <h1>席替え結果</h1>
    @if (isset($seats))

        <table>
            <thead>
                <tr>
                    @for ($col = 1; $col <= count($seats[0]); $col++)
                        <th> {{ $col }}列目</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach ($seats as $rowIndex => $row)
                    <tr>
                        @foreach ($row as $seat)
                            <td>{{ $seat }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>席替えが生成されていません。 <a href="{{ route('sekigae.index') }}">こちら</a> から席替えを生成してください。</p>
    @endif
    <!-- 席替えをやり直すボタン -->
    <button id="retry" class="btn btn-primary">席替えをやり直す</button>
    <a href="{{ route('sekigae.index') }}">席替えページに戻る</a>
</body>
<script>
    document.getElementById('retry').addEventListener('click', function() {
        // ページをリロードして、席替えをやり直す
        location.reload();
    });
</script>

</html>
