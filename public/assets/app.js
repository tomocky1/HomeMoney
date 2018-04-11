

/**
 * 名称：isNotDate
 * 引数：value：validation をかけたい値
 * 
 * YYYY年MM月dd日 の形式であることを確認する。99月99日などの日付の妥当性は確認しない
 * 値が不正な場合に "true" を返す
 */
function isNotDate(value) {
	if(value.match(/^\d{4}年\d{2}月\d{2}日$/)) {
		return false;
	} else {
		return true;
	}
}

/**
 * isNotYen 円形式に合致しているかどうかを確認する。最後はスペース + 円 とする
 * @param value validationをかけたい値
 * @returns 円形式にあっていなければ true を返す
 */
function isNotYen(value) {
	if (value.match(/^\d{1,3}(,\d{3})*\s円$/)) {
		return false;
	}

	return true;
	
}

/**
 * isEmpty フィールドの値がNULLかどうかをチェックする。
 * @param validationをかけたい値
 * @returns valueがnull/undefined/空文字の場合に true を返す。
 */
function isEmpty(value) {
	if(value == null || value == "") {
		return true;
	}
	
	return false;
}

$(document).ready(function() {

/**
 * ".yen" のタグについてはフォーカスインで 999999 形式とし、フォーカスアウトで 999,999 円 形式とする
 */
$(".yen").focus(function() {
    // カンマ・円を除去
    if($('#amount').val().length =! 0) { $('#amount').val($('#amount').val().replace(' 円', '').replace(/,/g, '')); }
    // 数値としての金額を退避する
    $(this).data('bak', $('#amount').val());
    // 選択状態にする
    $(this).select();
});

// 金額を設定
$('.yen').blur(function() {
    // 数値でなければ、退避した金額から復旧
    if($(this).val() == null || isNaN($(this).val())) { $(this).val($(this).data('bak')); }
    $(this).val($(this).val().split(/(?=(?:\d{3})+$)/).join() + " 円");
});




});