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
            'tweet' => 'required | max:140',
            // 画像を投稿する用のバリデーションを追加（p235）
            'images' => 'array|max:4',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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

    /**
     * 画像投稿用のメソッド
     */
    public function images()
    {
        return $this->file('images', []);
    }
}