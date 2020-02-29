let $button = $('.c-addLesson__button');

    //レッスンの追加ボタンを押した時の
    $button.on('click', function (e) {
        e.preventDefault();
    
        //レッスンのコピー
        let $copyTaget = $('.c-lesson__block:last-child');
        $copyTaget.clone().appendTo('#c-lesson__section');
        
        let $newCopyTaget = $('.c-lesson__block:last-child');
        $newCopyTaget.find('input[type="hidden"]').remove();

        load();
    })

    
    let load = function () {
        console.log('window.load!!!');
        
        let count = 0;
        let count1 = 1;
        $('.c-lesson__block').each(function(){

        console.log(typeof count);
        console.log(typeof count1);
        console.log(count);
        console.log(count1);
        // $(this).prop('value',count);
        //コピー後のそれぞれのinput要素DOMを定義
        let $targetHidden = $('#hidden',this);
        let $targetNumber = $('#number',this);
        let $targetTitle = $('#title',this);
        let $targetLesson = $('#lesson',this);

        //カウントアップした数字をそれぞれのinputタグのname属性にセット
        $targetHidden.prop('name','lessons[' + count + '][id]');
        $targetNumber.prop('name','lessons[' + count + '][number]').val(count1);
        $targetTitle.prop('name','lessons[' + count + '][title]');
        $targetLesson.prop('name','lessons[' + count + '][lesson]');

        count += 1;
        count1 += 1;
        
    })
};
window.onload = load();