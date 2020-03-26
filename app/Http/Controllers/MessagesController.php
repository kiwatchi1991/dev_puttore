<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class MessagesController extends Controller
{
    /**
     * メッセージ新規登録
     */
    public function create(Request $request)
    {
        Log::debug('メッセージ：create');

        Log::debug('これからDBへデータ挿入');
        Log::debug('リクエスト内容↓↓');
        Log::debug($request);

        //注文台帳・プロダクト・ユーザーテーブル結合して情報取得
        $id = $request->id;
        $saleUserId = Order::where('orders.id', $request->id)
            ->join('products', 'orders.product_id', 'products.id')
            ->select('products.user_id')
            ->first();

        Log::debug('$saleUserId');
        Log::debug($saleUserId);

        $message = new Message;
        $message->order_id = $id;
        $message->send_user_id = Auth::user()->id;
        $message->recieve_user_id = $saleUserId->user_id;
        $message->msg = $request->messages;
        $message->save();

        //メッセージの最終更新日を更新
        $thisOrder = Order::find($request->id);
        $thisOrder->msg_updated_at = $message->created_at;
        $thisOrder->save();
        Log::debug('$thisorder');
        Log::debug($thisOrder);
        Log::debug('$thisorder');
        Log::debug($thisOrder->msg_updated_at);


        // リダイレクトする
        // その時にsessionフラッシュにメッセージを入れる
        return back()->withInput();
    }
}
