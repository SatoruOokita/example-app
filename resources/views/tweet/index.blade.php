<x-layout title="TOP | つぶやきアプリ">
    <x-layout.single>
        <h2 class="text-center text-blue-500 text-4xl font-bold mt-8 mb-8">
            つぶやきアプリ
        </h2>
        <x-tweet.search.text :search="$search ?? null" :match="$match ?? null"></x-tweet.search.text>
        <x-tweet.form.post></x-tweet.form.post>

        @if (isset($search) && $tweets->isEmpty())
            <p class="text-center mt-4">検索結果がありません。</p>
        @endif

        <x-tweet.list :tweets="$tweets" :search="$search ?? ''"></x-tweet.list>

    </x-layout.single>
</x-layout>
