@extends('layouts.app')
@section('title','作品編集')
@section('content')

{{-- モーダルウインドウ --}}
<div class="modal js-modal">
    <div class="modal__bg js-modal-close"></div>
    <div class="modal__contents">
        <div class="modal__head__fixed">
            <div class="modal__title">
                Markdown記法<br>のヒント
            </div>
            <a class="modal__close js-modal-close" href=""><i class="fas fa-times"></i></a>
        </div>
        <div class="modal__contents__inner">

            <div class="modal__content__header">
                見出し
            </div>
            <div class="modal__content">
                # 見出し1<br>## 見出し2<br>### 見出し3
            </div>
            <div class="modal__content__header">
                コード
            </div>
            <div class="modal__content">
                ```hmtl<br>
                コード<br>
                ```
            </div>
            <div class="modal__content__header">
                リンク
            </div>
            <div class="modal__content">
                [リンク](http://...)
            </div>
            <div class="modal__content__header">
                強調
            </div>
            <div class="modal__content">
                **強調**<br>**強調**
            </div>
            <div class="modal__content__header">
                リスト
            </div>
            <div class="modal__content">
                - リスト 1<br>- リスト 2<br> - リスト 2-1
            </div>

            <div class="modal__content">
                1. 番号付きリスト 1<br>2. 番号付きリスト 2<br>3. 番号付きリスト 3
            </div>
        </div>
    </div>
</div>

<div class="c-productEdit">

    <form id="form-product" method="POST" action="{{ route('products.update',$product->id) }}"
        enctype="multipart/form-data">
        @csrf
        <div class="c-productNew__wrapper">
            {{-- 名前 --}}
            <div class="">
                <p class="c-productNew__title__label">タイトル<span class="required">必須</span></p>
                <input id="name" type="text" class="c-productEdit__input-area @error('name') is-invalid @enderror"
                    name="name" value="{{old('name')?old('name'):$product->name}}" autocomplete="name"
                    placeholder="教材のタイトル（例：Twitter風アプリを作ろう）" required>

                @error('name')
                <span class="error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <p class="c-productNew__title__label c-productNew__title__label--tags">言語・難易度選択<span
                    class="required">必須</span></p>
            <div class="c-productEdit__tagbox">

                {{-- 言語選択 --}}
                <div class="c-productEdit__categories">
                    <p class="c-productEdit__title">1. 言語を選んでね</p>

                    @foreach ($category as $categories)
                    <input id="c-{{ $categories->id }}" type="checkbox"
                        class="c-productEdit__checkbox @error('lang') is-invalid @enderror" name="lang[]"
                        value="{{ $categories->id }}" autocomplete="lang" @if(in_array($categories->id, old('lang',
                    $product->categories->pluck('id')->toArray()))) checked @endif required>
                    <label class="c-productEdit__label" for="c-{{ $categories->id }}">
                        <span>{{ $categories->name }}</span>
                    </label>
                    @endforeach

                    {{-- 難易度選択 --}}
                    <div class="c-productEdit__difficults">
                        <p class="c-productEdit__title">2. 難易度を選んでね</p>
                        @foreach ($difficult as $difficults)
                        <input id="d-{{ $difficults->id }}" type="radio"
                            class="c-productEdit__checkbox @error('difficult') is-invalid @enderror" name="difficult[]"
                            value="{{ $difficults->id }}" autocomplete="difficult" @if(in_array($difficults->id,
                        old('difficult',$product->difficulties->pluck('id')->toArray()))) checked @endif required>
                        <label class="c-productEdit__label" for="d-{{ $difficults->id }}">
                            <span>{{ $difficults->name }}</span>
                        </label>
                        @endforeach
                    </div>

                    @error('name')
                    <span class="error" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            {{-- 説明 --}}
            <div class="c-productEdit__detail">
                <p class="c-productNew__title__label">説明文<span class="required">必須</span></p>
                <textarea id="detail" type="text"
                    class="c-productEdit__input-area c-productEdit__input-area--detail @error('detail') is-invalid @enderror"
                    data-input="detail" name="detail" value="" rows="7"
                    required>{{old('detail')?old('detail'):$product->detail}}</textarea>

                @error('detail')
                <span class="error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        {{-- レッスン内容 --}}
        <p class="c-productNew__lessons__head">LESSON登録</p>
        <div class="c-productNew__modal">
            マークダウン記法のヒントは<a href="javascript:void(0)" class="js-modal-open c-productNew__modal__link">こちら</a>

        </div>
        <div class="c-productNew__lessons" id="js-lesson__section">
            @foreach( $lessons as $lesson )
            <div class="c-productNew__lesson__inner js-add__target">
                {{-- ↓↓　PC用wrapperここから --}}
                <div class="c-productNew__lesson__pcWrapper">
                    <input id="hidden" type="hidden" name="" value="{{ $lesson->id }}">
                    {{-- レッスン　Number --}}
                    <div class="c-productNew__topWrapper">
                        <div class="c-productNew__number">LESSON <span id="lesson_num">{{ $lesson->number }}</span><span
                                class="required">必須</span>
                            <input id="number" type="hidden"
                                class="c-productNew__input-area--number @error('number') is-invalid @enderror"
                                data-input="number" name="" value="" autocomplete="number" placeholder="Number1"></div>
                        <div class="c-productNew__deleteLesson js-deleteIcon"><i class="far fa-trash-alt"></i></div>

                        @error('number')
                        <span class="error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    {{-- 　　レッスン　title --}}
                    <div class="">
                        <input id="title" type="text"
                            class="c-productNew__input-area @error('title') is-invalid @enderror" data-input="title"
                            name="" value="{{ $lesson->title }}" autocomplete="title" placeholder="レッスンのタイトル"
                            placeholder="title１">
                    </div>
                </div>
                {{-- ↑↑　PC用wrapperここまで --}}
                {{-- レッスン lesson --}}
                <div class="c-productNew__lesson__block js-productNew__lesson">
                    {{--↓↓　PC用wrapperここから --}}
                    <div class="c-productNew__lesson__pcWrapper">
                        <div class="c-productNew__lesson__header">
                            <p class="c-productNew__lesson__header__title">本文</p>
                            {{-- 編集アイコン --}}
                            <div class="c-productNew__lesson__header__toggleIcon js-toggleTab js-toggleTab__input"
                                data-status="input">
                                <i class="far fa-edit"></i>
                            </div>
                            {{-- プレビューアイコン --}}
                            <div class="c-productNew__lesson__header__toggleIcon js-toggleTab js-toggleTab__preview active"
                                data-status="preview">
                                <i class="far fa-eye"></i>
                            </div>
                            {{-- 画像アイコン --}}
                            <div class="c-productNew__lesson__header__imgIcon js-insertImg" data-status="preview">

                                <label for="uploadimg" class="c-productNew__header__label js-imgInputlabel">
                                    <span class="c-productNew__lesson__header__imgIcon__icon"><i
                                            class="far fa-image"></i></span>
                                    <input id="uploadimg" class="c-productNew__lesson__header__input js-lessonUploadImg"
                                        type="file" name="lesson_pic">
                                </label>

                            </div>
                        </div>

                        <div
                            class="c-productNew__lesson c-productNew__lesson--input js-lesson__block js-lesson__block--input active">
                            <textarea type="text" id="lesson"
                                class="c-productNew__lesson--textarea js-marked__textarea @error('lesson') is-invalid @enderror"
                                data-input="lessson" name="" value="{{ old('lesson') }}" autocomplete="lesson"
                                placeholder="lessonの内容" required>{{ $lesson->lesson }}</textarea>
                        </div>
                    </div>

                    <div id="preview"
                        class="c-productNew__lesson c-productNew__lesson--preview js-lesson__block js-lesson__block--preview js-edit-preview">
                    </div>
                </div>

            </div>
            @endforeach
        </div>
        @error('lessons.*.title')
        <span class="error" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @error('lessons.*.lesson')
        <span class="error" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        {{-- レッスン追加ボタン --}}
        <div class="c-productNew__lesson__addBtn">
            <button class="c-productNew__lesson__addBtn__btn js-addLesson__button"><i class="fas fa-plus-circle"></i>
                LESSONを追加する</button>
        </div>
        <div class="c-productNew__wrapper">
            {{-- 価格 --}}
            <div class="c-productEdit__price">
                <p class="c-productNew__title__label">価格<span class="required">必須</span></p>
                <div class="c-productNew__price--wrap">
                    <div class="c-productNew__price--icon">¥</div>
                    <div class="c-productNew__price__inputWrapper">
                        <input id="default_price" type="tel"
                            class="c-productNew__input-area c-productNew__input-area--price @error('default_price') is-invalid @enderror"
                            name="default_price"
                            value="{{old('default_price')?old('default_price'):$product->default_price}}"
                            autocomplete="default_price" placeholder="価格" required>
                    </div>

                </div>
                @error('default_price')
                <span class="error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            {{-- 割引価格 --}}
            <div class="c-productEdit__discount-price">
                <p class="c-productNew__title__label c-productNew__title__label--discount">割引価格<span
                        class="options">任意</span></p>
                <div class="c-productNew__price--wrap c-productNew__price--wrap--discount">
                    <div class="c-productNew__price--icon c-productNew__price--icon--discount">¥</div>
                    <input type="number" id="discount_price"
                        class="c-productNew__input-area c-productNew__input-area--discount @error('discount_price') is-invalid @enderror"
                        name="discount_price"
                        value="@if($discount_price){{ $discount_price->discount_price }}@elseif(old('discount_price')){{ old('discount_price') }}@endif"
                        autocomplete="discount_price">
                </div>
                <div class="c-productNew__price--wrap date">
                    <div class="c-productEdit__discount-price__date">
                        <span class="c-productEdit__discount-price__label">開始日</span><input type="text"
                            name="start_date"
                            class="c-productNew__input-area c-productNew__input-area--discount js-date_picker @error('sale_price') is-invalid @enderror"
                            value="@if($discount_price){{ $discount_price->start_date }}@elseif(old('start_date')){{ old('start_date') }}@endif">
                    </div>
                    <div class="c-productEdit__discount-price__date">
                        <span class="c-productEdit__discount-price__label">終了日</span><input type="text" name="end_date"
                            class="c-productNew__input-area c-productNew__input-area--discount js-date_picker @error('sale_price') is-invalid @enderror"
                            value="@if($discount_price){{ $discount_price->end_date }}@elseif(old('end_date')){{ old('end_date') }}@endif">
                    </div>
                </div>
                @error('discount_price')
                <span class="error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @error('start_date')
                <span class="error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @error('end_date')
                <span class="error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            {{-- 必要スキル --}}
            <div class="c-productNew__skills">
                <p class="c-productNew__skills__title">受講に必要なスキル<span class="required">必須</span></p>
                <textarea id="skills" type="text"
                    class="c-productNew__input-area c-productNew__input-area--skills @error('skills') is-invalid @enderror"
                    data-input="skills" name="skills" value="" rows="7"
                    required>{{old('skills')?old('skills'):$product->skills}}</textarea>
                @error('skills')
                <span class="error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            {{-- 画像 --}}
            <div class="c-productNew__images">
                {{-- モーダルウィンドウ --}}
                <div class="c-productNew__imgModal js-imgModal">
                    <div class="c-productNew__imgModal__bg js-imgModal-close"></div>
                    <div class="c-productNew__imgModal__inner">

                        <div class="c-productNew__imgModal__label">画像を削除しますか？</div>
                        <div class="c-productNew__imgModal__img">
                            <img src="" alt="" class="js-img-insert-target">
                        </div>
                        <div class="c-productNew__imgModal__buttons">
                            <div class="c-productNew__imgModal__button c-productNew__imgModal__button--cansel">
                                <a href="javascript:void(0)" class="js-imgModal-close">キャンセル</a>
                            </div>
                            <div class="c-productNew__imgModal__button c-productNew__imgModal__button--delete">
                                <a href="javascript:void(0)" class="js-imgModal-delete">削除する</a>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="c-productNew__title__label">画像 <span class="c-productNew__title__label--picText">(
                        画像１がサムネイルとして表示されます )</span>
                </p>
                <div class="c-productNew__images__half">
                    {{-- 画像1 --}}
                    <div class="c-productNew__image js-image-parents">
                        <label class="c-productNew__image__area area1 js-area__drop">
                            <input type="hidden" value="" name="flgpic1" class="js-flg-delete">
                            <input class="c-productNew__image__input js-input__file--product" type="file" name="pic1"
                                value="">
                            <img src="/storage/{{ $product->pic1 }}" alt=""
                                class="c-productNew__image__img js-prev__img" data-modal="pic1">
                        </label>
                        <div class="c-productNew__modal c-productNew__modal--img">
                            <a href="javascript:void(0)" class="js-imgModal-open c-productNew__modal__delete"
                                data-modal="pic1">削除</a>
                        </div>
                    </div>
                    {{-- 画像2 --}}
                    <div class="c-productNew__image js-image-parents">
                        <label class="c-productNew__image__area area2 js-area__drop">
                            <input type="hidden" value="" name="flgpic2" class="js-flg-delete">
                            <input class="c-productNew__image__input js-input__file--product" type="file" name="pic2">
                            <img src="/storage/{{ $product->pic2 }}" alt=""
                                class="c-productNew__image__img js-prev__img" data-modal="pic2">
                        </label>
                        <div class="c-productNew__modal c-productNew__modal--img">
                            <a href="javascript:void(0)" class="js-imgModal-open c-productNew__modal__delete"
                                data-modal="pic2">削除</a>
                        </div>
                    </div>
                    {{-- 画像3 --}}
                    <div class="c-productNew__image js-image-parents">
                        <label class="c-productNew__image__area area3 js-area__drop">
                            <input type="hidden" value="" name="flgpic3" class="js-flg-delete">
                            <input class="c-productNew__image__input js-input__file--product" type="file" name="pic3">
                            <img src="/storage/{{ $product->pic3}}" alt="" class="c-productNew__image__img js-prev__img"
                                data-modal="pic3">
                        </label>
                        <div class="c-productNew__modal c-productNew__modal--img">
                            <a href="javascript:void(0)" class="js-imgModal-open c-productNew__modal__delete"
                                data-modal="pic3">削除</a>
                        </div>
                    </div>
                </div>
                @error('pic1')
                <span class="c-productNew__error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @error('pic2')
                <span class="c-productNew__error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @error('pic3')
                <span class="c-productNew__error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <div class="c-productNew__images__half">
                    {{-- 画像4 --}}
                    <div class="c-productNew__image js-image-parents">
                        <label class="c-productNew__image__area area4 js-area__drop">
                            <input type="hidden" value="" name="flgpic4" class="js-flg-delete">
                            <input class="c-productNew__image__input js-input__file--product" type="file" name="pic4">
                            <img src="/storage/{{ $product->pic4 }}" alt=""
                                class="c-productNew__image__img js-prev__img" data-modal="pic4">
                        </label>
                        <div class="c-productNew__modal c-productNew__modal--img">
                            <a href="javascript:void(0)" class="js-imgModal-open c-productNew__modal__delete"
                                data-modal="pic4">削除</a>
                        </div>
                    </div>
                    {{--画像5 --}}
                    <div class="c-productNew__image js-image-parents">
                        <label class="c-productNew__image__area area5 js-area__drop">
                            <input type="hidden" value="" name="flgpic5" class="js-flg-delete">
                            <input class="c-productNew__image__input js-input__file--product" type="file" name="pic5">
                            <img src="/storage/{{ $product->pic5 }}" alt=""
                                class="c-productNew__image__img js-prev__img" data-modal="pic5">
                        </label>
                        <div class="c-productNew__modal c-productNew__modal--img">
                            <a href="javascript:void(0)" class="js-imgModal-open c-productNew__modal__delete"
                                data-modal="pic5">削除</a>
                        </div>
                    </div>
                    {{--画像6 --}}
                    <div class="c-productNew__image js-image-parents">
                        <label class="c-productNew__image__area area6 js-area__drop">
                            <input type="hidden" value="" name="flgpic6" class="js-flg-delete">
                            <input class="c-productNew__image__input js-input__file--product" type="file" name="pic6">
                            <img src="/storage/{{ $product->pic6 }}" alt=""
                                class="c-productNew__image__img js-prev__img" data-modal="pic6">
                        </label>
                        <div class="c-productNew__modal c-productNew__modal--img">
                            <a href="javascript:void(0)" class="js-imgModal-open c-productNew__modal__delete"
                                data-modal="pic6">削除</a>
                        </div>
                    </div>
                </div>
            </div>
            @error('pic4')
            <span class="c-productNew__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            @error('pic5')
            <span class="c-productNew__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            @error('pic6')
            <span class="c-productNew__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <div class="js-postType__parentDom">
                <input type="hidden" name="postType" class="js-postType" value="">
                <div class="c-productNew__submit c-productNew__submit--draft js-popup" data-type="draft">
                    <button type="submit" class="c-productNew__submit__button c-productNew__submit__button--draft"
                        name="postType" value="draft">
                        下書き保存する
                    </button>
                </div>
                <div class="c-productNew__submit" data-type="register" name="postType" value="register">
                    <button type="submit" class="c-productNew__submit__button js-popup">
                        登録する
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>

</script>
@endsection