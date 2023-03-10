<?php

namespace App\Http\Requests\Tweet;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'tweet' => 'required|max:140'
        ];
    }

    public function tweet(): string
    {
        return $this->input('tweet');
    }

    /**
     * idを取得できるメソッド
     * ・この処理はコントローラに実装しても同じ動作をするが、RequestForm側に実装することでコントローラでの処理が簡略化される。
     */
    public function id(): int
    {
        return (int) $this->route('tweetId');
    }
}