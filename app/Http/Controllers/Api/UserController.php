<?php

namespace HomeMoney\Http\Controllers\Api;

use Illuminate\Http\Request;
use HomeMoney\Http\Controllers\Controller;
use HomeMoney\Http\Requests\Api\UserLoginRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Apiとしてユーザテーブル関連の情報を扱うクラス
 * @author tomocky1
 *
 */
class UserController extends Controller
{
	/**
	 * Api経由でログインを実施する。ただし、Api通信はステートレスで行うため
	 * このメソッドではユーザ名・パスワードの組み合わせで存在確認のみ行う
	 */
	public function login(UserLoginRequest $request) {

    	if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
    		$return = 'true';
    	} else {
    		$return = 'false';
    	}
    	return $return;
	}
}
