@extends('layouts.app')

@section('content')
<div class="c-productNew">

    <form id="form" method="POST" action="{{ route('products.create') }}" enctype="multipart/form-data">
        @csrf

        <div class="">
            <p class="c-productNew__title__label">タイトル</p>
            <input id="name" type="text" class="c-productNew__input-area @error('name') is-invalid @enderror"
                name="name" value="{{ old('name') }}" autocomplete="name" placeholder="教材のタイトル（例：Twitter風アプリを作ろう）">

            @error('name')
            <span class="c-productNew__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <p class="c-productNew__title__label c-productNew__title__label--tags">言語・難易度選択</p>
        <div class="c-productNew__tagbox">
            {{-- 言語選択 --}}
            <div class="c-productNew__categories">
                <p class="c-productNew__title">1. 言語を選んでね</p>
                @foreach ($category as $categories)
                <input id="c-{{ $categories->id }}" type="checkbox"
                    class="c-productNew__checkbox @error('lang') is-invalid @enderror" name="lang[]"
                    value="{{ $categories->id }}" autocomplete="lang" autofocus>
                <label class="c-productNew__label" for="c-{{ $categories->id }}">
                    {{ $categories->name }}
                </label>
                @endforeach
            </div>

            {{-- 難易度選択 --}}
            <div class="c-productNew__difficults">
                <p class="c-productNew__title">2. 難易度を選んでね</p>
                @foreach ($difficult as $difficults)
                <input id="d-{{ $difficults->id }}" type="radio"
                    class="c-productNew__checkbox @error('difficult') is-invalid @enderror" name="difficult[]"
                    value="{{ $difficults->id }}" autocomplete="difficult" autofocus>
                <label class="c-productNew__label" for="d-{{ $difficults->id }}">
                    {{ $difficults->name }}
                </label>
                @endforeach
            </div>
        </div>
        @error('lang')
        <span class="c-productNew__error" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @error('difficult')
        <span class="c-productNew__error" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        {{-- 説明 --}}
        <div class="c-productNew__detail">
            <p class="c-productNew__title__label">説明文</p>

            <textarea id="detail" type="text"
                class="c-productNew__input-area c-productNew__input-area--detail @error('detail') is-invalid @enderror"
                data-input="detail" name="detail" value="{{ old('detail') }}" rows="7">
            </textarea>
            <div class="c-productNew__modal">
                書き方のヒントは<span>こちら</span>
            </div>
            @error('detail')
            <span class="c-productNew__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        {{-- レッスン内容 --}}

        <div class="c-productNew__lessons" id="js-lesson__section">
            <div class="c-productNew__lesson__inner js-add__target">
                {{-- レッスン１　Number --}}
                <div class="c-productNew__topWrapper">
                    <div class="c-productNew__number">LESSON <span id="lesson_num"></span>
                        <input id="number" type="hidden"
                            class="c-productNew__input-area--number @error('number') is-invalid @enderror"
                            data-input="number" name="" value="" autocomplete="number" placeholder="Number1"></div>
                    <div class="c-productNew__deleteLesson js-deleteIcon"><i class="far fa-trash-alt"></i></div>
                    @error('number')
                    <span class="c-productNew__error" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                {{-- 　　レッスン1　title --}}
                <div class="">
                    <input id="title" type="text" class="c-productNew__input-area @error('title') is-invalid @enderror"
                        data-input="title" name="" value="{{ old('title') }}" autocomplete="title"
                        placeholder="レッスンのタイトル" placeholder="title１">

                    @error('title')
                    <span class="c-productNew__error" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                {{-- レッスン１ lesson --}}
                <div class="c-productNew__lesson__block js-productNew__lesson">

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

                            <label for="uploadimg" class="c-productNew__header__label">
                                <i class="far fa-image"></i>
                                <input id="uploadimg" class="c-productNew__lesson__header__input js-uploadimg"
                                    type="file" name="lesson_pic">
                            </label>

                        </div>
                    </div>

                    <div
                        class="c-productNew__lesson c-productNew__lesson--input js-lesson__block js-lesson__block--input active">
                        <textarea type="text" id="lesson"
                            class="c-productNew__lesson--textarea js-marked__textarea @error('lesson') is-invalid @enderror"
                            data-input="lessson" name="" value="{{ old('lesson') }}" autocomplete="lesson"
                            placeholder="lesson１" 　>{{ old('lesson') }}
                        </textarea>
                    </div>

                    <div id="preview"
                        class="c-productNew__lesson c-productNew__lesson--preview js-lesson__block js-lesson__block--preview ">
                    </div>

                    @error('lesson')
                    <span class="c-productNew__error" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

            </div>
        </div>
        <div class="c-productNew__lesson__addBtn js-addLesson__button">
            <button class="c-productNew__lesson__addBtn__btn"><i class="fas fa-plus-circle"></i> LESSONを追加する</button>
        </div>

        {{-- 価格 --}}
        <div class="">
            <p class="c-productNew__title__label">価格</p>
            <input id="default_price" type="text"
                class="c-productNew__input-area c-productNew__input-area--price @error('default_price') is-invalid @enderror"
                name="default_price" value="{{ old('default_price') }}" autocomplete="default_price" placeholder="価格">

            @error('default_price')
            <span class="c-productNew__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        {{-- 必要スキル --}}
        <div class="c-productNew__skills">
            <p class="c-productNew__title__label">受講に必要なスキル</p>
            <textarea id="skills" type="text"
                class="c-productNew__input-area c-productNew__input-area--skills @error('skills') is-invalid @enderror"
                data-input="skills" name="skills" value="{{ old('skills') }}" rows="7">
            </textarea>
            @error('skills')
            <span class="c-productNew__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        {{-- 画像 --}}
        <div class="c-productNew__images">
            <p class="c-productNew__title__label">画像</p>
            <div class="c-productNew__images__half">
                {{-- 画像1 --}}
                <label class="c-productNew__image__area js-area__drop">
                    <input class="c-productNew__image__input js-input__file--product" type="file" name="pic1">
                    <img src="" alt="" class="c-productNew__image__img js-prev__img">
                </label>
                {{-- 画像2 --}}
                <label class="c-productNew__image__area js-area__drop">
                    <input class="c-productNew__image__input js-input__file--product" type="file" name="pic2">
                    <img src="" alt="" class="c-productNew__image__img js-prev__img">
                </label>
                {{-- 画像3 --}}
                <label class="c-productNew__image__area js-area__drop">
                    <input class="c-productNew__image__input js-input__file--product" type="file" name="pic3">
                    <img src="" alt="" class="c-productNew__image__img js-prev__img">
                </label>
            </div>

            <div class="c-productNew__images__half">
                {{-- 画像4 --}}
                <label class="c-productNew__image__area js-area__drop">
                    <input class="c-productNew__image__input js-input__file--product" type="file" name="pic4">
                    <img src="" alt="" class="c-productNew__image__img js-prev__img">
                </label>
                {{--画像5 --}}
                <label class="c-productNew__image__area js-area__drop">
                    <input class="c-productNew__image__input js-input__file--product" type="file" name="pic5">
                    <img src="" alt="" class="c-productNew__image__img js-prev__img">
                </label>
                {{--画像6 --}}
                <label class="c-productNew__image__area js-area__drop">
                    <input class="c-productNew__image__input js-input__file--product" type="file" name="pic6">
                    <img src="" alt="" class="c-productNew__image__img js-prev__img">
                </label>
            </div>
        </div>
        <div class="c-productNew__submit c-productNew__submit--draft">
            <button type="submit"
                class="c-productNew__submit__button c-productNew__submit__button--draft js-isCheck-postType"
                data-type="draft">
                下書き保存する
            </button>
            <input type="hidden" name="" class="js-postType" value="">
        </div>
        <div class="c-productNew__submit ">
            <button type="submit" class="c-productNew__submit__button js-isCheck-postType" data-type="register">
                登録する
                <input type="hidden" name="" class="js-postType" value="">
            </button>
        </div>
    </form>
</div>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/styles/default.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/highlight.min.js"></script>
<script>
    hljs.initHighlightingOnLoad();
</script>
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>

@endsection