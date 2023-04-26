<?php
// この「LogController」は、フレームワークがコントローラーを呼び出すまでの処理の流れを把握するために作成した。
// このコントローラーの役割は、logを呼び出すこと。

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogController extends Controller
{
    public function __construct()
    {
        Log::info('LogController has been constructed.');
    }

    public function index()
    {
        // return response('This is the LogController index.');

        $logPath = storage_path('logs/laravel.log');

        if (file_exists($logPath)) {
            $logContent = file_get_contents($logPath);
            $lines = explode(PHP_EOL, $logContent);
            $recentLines = array_slice($lines, -3);
            $displayContent = implode(PHP_EOL, $recentLines);
            return nl2br(e($displayContent));
        } else {
            return response('Log file not found.', 404);
        }
    }
}
