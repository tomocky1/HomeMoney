<?php

namespace HomeMoney\Http\Controllers\Mst;

use Illuminate\Http\Request;
use HomeMoney\Http\Controllers\Controller;
use HomeMoney\Http\Requests\AccountStoreRequest;
use HomeMoney\Models\Account;

/**
 * 勘定科目の登録・編集
 * @author tomocky1
 */
class AccountController extends Controller
{
	/**
	 * コンストラクタ
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	/**
	 * トップメニューから遷移した際の一覧画面を表示
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
    public function index()
    {
    	$data['accounts'] = Account::where('sys_deleted_flag', false)->where('enable_flag', true)->get();
    	return view('account.index', $data);
    }
    
    /**
     * 勘定科目を保存・新規／修正
     * @param AccountStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AccountStoreRequest $request)
    {
    	$account = isset($request->id) ? Receipt::find($request->id) : new Account();
    	$account->name = $request->name	;
    	$account->dorder = $request->dorder;
    	$account->saveDefault();
    	return redirect()->route('account.index');
    }
    
    /**
     * 勘定科目を削除
     * @param unknown $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
    	// $id で取得できる勘定科目を削除
    	$account = Account::find($id);
    	$account->deleteDefault();
    	
    	return redirect()->route("account.index");
    	
    }
    
    /**
     * 勘定科目修正画面を開く
     * @param unknown $id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit($id)
    {
    	// 一覧表示用の勘定科目
    	$data['accounts'] = Account::where('sys_deleted_flag', false)->where('enable_flag', true)->orderBy('dorder', 'asc')->get();

    	// 編集用の勘定科目
    	$data['account'] = Account::find($id);
    	
    	// 編集画面であることを示すフラグ
    	$data['editFlag'] = true;
    	
    	// 一覧画面へ遷移
    	return view('account.index', $data);
    }
}
