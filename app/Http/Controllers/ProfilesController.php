<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\Category;
use App\Difficulty;
use App\CategoryProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfilesController extends Controller
{
    /**
     * 詳細表示機能
     */
    public function show($id)
    {
        if (!ctype_digit($id)) {
            return redirect('/products')->with('flash_message', __('もう一度やり直してください'));
        }

        Log::debug('SHOW!!!');

        // ユーザー情報の取得
        $user = User::find($id);

        Log::debug('$user');
        Log::debug($user);

        //ログインユーザーのプロダクト（ページング）
        $products = Product::where('user_id', $id)
            ->where('open_flg', 0)
            ->latest()->paginate(10);

        //画像有無判定フラグ
        $is_image = false;
        if (Storage::disk('local')->exists('public/profile_images/' . Auth::id() . '.jpg')) {
            $is_image = true;
        }

        $product_category = Product::all();
        $product_difficulty = Product::all();

        return view('profile.show', [
            'products' => $products,
            'product_categories' => $product_category,
            'product_difficulties' => $product_difficulty,
            'is_image' => $is_image,
            'user' => $user,
        ]);
    }

    /**
     * 編集機能
     */
    public function edit($id)
    {
        //自分以外は編集権限を持たない
        if ($id != Auth::user()->id) {
            return redirect('/')->with('flash_message', __('権限がありません'));
        }
        // GETパラメータが数字かどうかをチェックする
        // 事前にチェックしておくことでDBへの無駄なアクセスが減らせる（WEBサーバーへのアクセスのみで済む）
        if (!ctype_digit($id)) {
            return redirect('/products')->with('flash_message', __('もう一度やり直してください'));
        }

        $user = User::find($id);
        return view('profile.edit', ['user' => $user]);
    }

    /**
     * 更新機能
     */
    public function update(Request $request, $id)
    {
        Log::debug('プロフィール更新');
        // GETパラメータが数字かどうかをチェックする
        if (!ctype_digit($id)) {
            return redirect('/products/mypage')->with('flash_message', __('もう一度やり直してください'));
        }
        Log::debug('<<<<<<<<<<<<     request       >>>>>>>>>>>>>>');
        Log::debug($request);

        $user = User::find($id);
        $user->fill($request->all())->save();

        if ($request->pic) {

            $path = $request->pic->store('public/profile_images'); //もともとこっち

            Log::debug('$request->pic');
            Log::debug($request->pic);
            $user->pic = str_replace('public/', '', $path);
            $user->save();
        }

        return redirect()->route('profile.show', $id)->with('flash_message', 'プロフィールを変更しました');
    }

    /**
     * 退会機能
     */

    //表示
    public function deleteShow(Request $request, $id)
    {
        // GETパラメータが数字かどうかをチェックする
        // 事前にチェックしておくことでDBへの無駄なアクセスが減らせる（WEBサーバーへのアクセスのみで済む）
        if (!ctype_digit($id)) {
            return redirect('/profiles')->with('flash_message', __('もう一度やり直してください'));
        }

        //自分以外のユーザーがあくせすできないようにする
        if ($id != Auth::user()->id) {
            return redirect()->route('home')->with('flash_message', __('権限がありません'));
        }



        $user = User::find($id);
        return view('profile.delete', ['user' => $user]);
    }

    //削除
    public function deleteData(Request $request, $id)
    {
        Log::debug('<< deleteData >>');
        Log::debug($request);
        Log::debug($id);

        // GETパラメータが数字かどうかをチェックする
        // 事前にチェックしておくことでDBへの無駄なアクセスが減らせる（WEBサーバーへのアクセスのみで済む）
        if (!ctype_digit($id)) {
            return redirect('/profiles')->with('flash_message', __('もう一度やり直してください'));
        }

        $user = User::find($request->input('id'));
        $user->delete();

        return redirect('/products')->with('flash_message', '退会しました');
    }
}
