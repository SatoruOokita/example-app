{{-- 新しいユーザーが追加されました。 --}}
{{-- {{ $toUser->name }}さんこんにちは！新しく{{ $newUser->name }}さんが参加しましたよ！ --}}

{{-- メールをMarkdown形式に書き換える（テキストp189） --}}
@component('mail::message')
    # 新しいユーザーが追加されました！

    {{ $toUser->name }}さんこんにちは！

    新しく{{ $newUser->name }}さんが参加しましたよ！

    @component('mail::button', ['url' => route('tweet.index')])
        つぶやきを見に行く
    @endcomponent
@endcomponent
