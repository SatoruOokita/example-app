<form action="{{ route('tweet.index') }}" method="GET" class="flex items-center justify-center">
    <input type="text" name="search" placeholder="検索" value="{{ old('search', $search ?? '') }}"
        class="border border-gray-300 p-2 rounded-lg shadow-sm focus:outline-none focus:border-blue-500">
    <select name="match"
        class="border border-gray-300 p-2 rounded-lg shadow-sm ml-2 focus:outline-none focus:border-blue-500">
        <option value="partial" {{ old('match', $match ?? '') == 'partial' ? 'selected' : '' }}>部分一致</option>
        <option value="prefix" {{ old('match', $match ?? '') == 'prefix' ? 'selected' : '' }}>前方一致</option>
        <option value="suffix" {{ old('match', $match ?? '') == 'suffix' ? 'selected' : '' }}>後方一致</option>
    </select>
    <button type="submit" class="bg-gray-400 text-white font-bold p-2 rounded-lg shadow ml-2">検索</button>
</form>
