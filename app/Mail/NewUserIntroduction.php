<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

// テキストp186
use App\Models\User;

/**
 * この種類のメールは常にQueueを経由して送信するべきだとあらかじめ分かっている場合は、メールクラスの方にShouldQueueインターフェイスを実装させて、Queueするべきだという印をつけることができる。
 */
class NewUserIntroduction extends Mailable implements ShouldQueue   // 『implements ShouldQueue』を追記（p202）
{
    use Queueable, SerializesModels;

    public $subject = '新しいユーザーが追加されました!';

    // テキストp186
    public User $toUser;
    public User $newUser;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $toUser, User $newUser)
    {
        $this->toUser = $toUser;
        $this->newUser = $newUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    // public function build()
    // {
    //     return $this->view('view.name');
    // }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'New User Introduction',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            // view: 'email.new_user_introduction',
            markdown: 'email.new_user_introduction',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}