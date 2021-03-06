<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\PasswordResetNotification;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pic',
        'account_name',
        'account_title',
        'account_detail',
        'email',
        'password',
        'bank_name',
        'bank_branch',
        'bank_account_num',
        'bank_code',
        'bank_branch_code',
        'bank_account_holder_name',
        'bank_account_type',
        'bank_account_number',
    ];

    /**
     * ログインしているユーザーのみ表示する
     */

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function contacts()
    {
        return $this->hasMany('App\Product');
    }

    /**
     * 削除済みユーザー以外を表示する
     */
    use SoftDeletes;

    protected $table = 'users';
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * パスワードリセット通知の送信をオーバーライド
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }

    public function buyEmail($options)
    {
        Log::debug('<<<<<<<<  buyEmail  >>>>>>>>>');

        $thisOrder = Order::join('users', 'orders.user_id', 'users.id')
            ->where('orders.id', $options->id)
            ->select('orders.id as o_id', 'account_name', 'email')
            ->first();
        $thisOrder->notify(new \App\Notifications\BuyContents());
    }
    public function saleEmail($options)
    {
        Log::debug('<<<<<<<<  saleEmail  >>>>>>>>>');

        $thisOrder = Order::join('products', 'orders.product_id', 'products.id')
            ->join('users', 'products.user_id', 'users.id')
            ->where('orders.id', $options->id)
            ->select('orders.id as o_id', 'account_name', 'email')
            ->first();
        $thisOrder->notify(new \App\Notifications\SaleContents());
    }
}
