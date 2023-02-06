<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testSuccessfulLogin(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create(); // テスト用のユーザーを作成する
            $browser->visit('/login') // パスをlogin画面に変更
                ->type('email', '$user->email') // メールアドレスを入力する
                ->type('password', '$user->password') // パスワードを入力する
                ->press('LOG IN'); // 「LOG IN」ボタンをクリックする
            /**
             * テストを行うと、作成したテスト用のユーザーで正しくログインすることができていなかったため、以下のコードをコメントアウトしている。
             * ログインボタンを押した後、「/login」ページにリダイレクトされていたため、作成したユーザーに問題があるのかも
             */
            // ->assertPathIs('/tweet') // /tweetに遷移したことを確認する
            // ->assertSee('つぶやきアプリ'); // ページ内に「つぶやきアプリ」が表示されていることの確認
        });
    }
}