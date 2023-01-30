<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0 maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>つぶやきアプリ</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body>
    <h1>つぶやきアプリ</h1>
    {{-- つぶやきが投稿できるフォーム（『プロフェッショナルWebプログラミング』p075の内容） --}}
    @auth
        <div>
            <p>投稿フォーム</p>
            {{-- 削除が成功した際の通知（『プロフェッショナルWebプログラミング』p096の内容） --}}
            @if (session('feedback.success'))
                <p style="color: green">{{ session('feedback.success') }}</p>
            @endif
            <form action="{{ route('tweet.create') }}" method="POST">
                @csrf
                <label for="tweet-content">つぶやき</label>
                <span>140文字まで</span>
                <textarea name="tweet" id="tweet-content" placeholder="つぶやきを入力"></textarea>
                @error('tweet')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
                <button type="submit">投稿</button>
            </form>
        </div>
    @endauth
    <div>
        {{-- コントローラから渡された$tweetsを、@foreachで一つずつ取り出していく。$tweetsから$tweetを一つずつ取得し、そのcontentを表示する。 --}}
        {{-- @foreach ($tweets as $tweet)
            <p>{{ $tweet->content }}</p>
        @endforeach --}}

        {{-- テキストp093：一覧画面から編集画面へ遷移できるように導線を追加 --}}
        @foreach ($tweets as $tweet)
            <details>
                <summary>{{ $tweet->content }} ：TweetId {{ $tweet->id }} by {{ $tweet->user->name }}</summary>
                {{-- テキストp141の内容：編集や削除の権限がない人には、ボタンを非表示にします。 --}}
                @if (\Illuminate\Support\Facades\Auth::id() === $tweet->user_id)
                    <div>
                        <a href="{{ route('tweet.update.index', ['tweetId' => $tweet->id]) }}">編集</a>
                        <form action="{{ route('tweet.delete', ['tweetId' => $tweet->id]) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <button type="submit">削除</button>
                        </form>
                    </div>
                @else
                    編集できません
                @endif
            </details>
        @endforeach
    </div>
</body>

</html>
