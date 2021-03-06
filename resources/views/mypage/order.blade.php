@extends('layouts.app')
@section('title','マイページ')
@section('content')

@include('mypage.nav', ['page' => 'order'])

<div class="c-mypage__order">
  <div class="c-mypage__sale">
    <div class="c-mypage__products__title c-mypage__products__title--sale">
      <h2>販売管理</h2>
    </div>

    <div class="c-mypage__sale__thisMonth">
      <div class="c-mypage__sale__thisMonth__title">
        <p>今月の売上</p>
      </div>
      <div class="c-mypage__sale__thisMonth__price__wrapper">

        <div class="c-mypage__sale__thisMonth__total">総額</div>
        <div class="c-mypage__sale__thisMonth__price"><span class="c-mypage__sale__icon">¥</span>
          {{ number_format($this_month_amount) }}
        </div>
        <div style="width:50px;"></div>
      </div>
    </div>

    {{-- 次回振込予定 --}}
    <div class="c-mypage__sale__untransferred">
      <div class="c-mypage__sale__untransferred__title">
        <p>次回振込予定金額</p>
        @if(!empty($untransferred_sale))
        @if($untransferred_sale->status === "pending")
        <p class=c-mypage__sale__untransferred__scheduled>振込予定日：{{ $untransferred_sale->scheduled_date }}</p>
        @endif
        @if($untransferred_sale->status === ("failed" || "recombination"))
        <p class=c-mypage__sale__untransferred__failed>振込に失敗しております。大変お手数をお掛けいたしますが、運営にお問い合わせをお願い致します。</p>
        @endif
        @endif
      </div>
      <div class="c-mypage__sale__untransferred__price__wrapper">
        <div class="c-mypage__sale__untransferred__total">総額</div>

        <div class="c-mypage__sale__untransferred__price"><span class="c-mypage__sale__icon">¥</span>
          @if(!empty($untransferred_sale))
          {{ number_format($untransferred_sale->amount + $untransferred_sale->carried_balance)}}
          @else
          0
          @endif
        </div>
        <div style="width:50px;"></div>
      </div>
      <p class="c-mypage__sale__untransferred__text">
        月末時点での未振込の売上金総額が5,000円以上になると、翌月末に振込されます<br>(月末締め日の翌営業日に最新の情報に更新されます。)。
      </p>　
    </div>

    {{-- 振込履歴一覧 --}}

    <div class="c-mypage__sale__done">
      <div class="c-mypage__sale__done__title">
        <p>振込履歴</p>
      </div>
      <table>
        <thead>
          <tr>
            <th class="c-mypage__sale__list c-mypage__sale__list--day">振込日</th>
            <th class="c-mypage__sale__list c-mypage__sale__list--price">振込金額</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($paids as $paid)
          <tr>
            {{-- 日付を文字列から日付の形式に変換 --}}
            @php $timestamp = strtotime($paid->transfer_date);
            $transfer_date = date("Y年m月d日", $timestamp);
            @endphp

            <td class="day">{{ $transfer_date }}</td>
            <td>¥ {{ number_format($paid->transfer_amount) }}</td>
          </tr>
          @endforeach

        </tbody>
      </table>
      {{-- 金額が0円の場合はDOMが表示されなくなるので、これを表示 --}}
      @if ($paids == null)
      <div class="c-mypage__sale__list__text">※振込履歴はありません。</div>
      @endif
    </div>

  </div>
</div>
@endsection
