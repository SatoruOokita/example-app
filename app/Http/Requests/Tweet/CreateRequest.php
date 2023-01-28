<?php

namespace App\Http\Requests\Tweet;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return false;
        return true;    // trueだと、誰でもリクエストできるようになる。
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'tweet' => 'required | max:140'
        ];
    }

    /**
     * Requestクラスのuser関数で今自分がログインしているユーザーを取得
     */
    public function userId(): int
    {
        return $this->user()->id;
    }

    /**
     * 投稿フォームから投稿されたデータを取得するためのtweetメソッド
     */
    public function tweet(): string
    {
        return $this->input('tweet');
    }
}