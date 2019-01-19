<?php

namespace HomeMoney\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use HomeMoney\Services\MoveServiceInterface;
use HomeMoney\Http\Requests\MoveStoreRequest;
use HomeMoney\Models\Wallet;
use HomeMoney\Http\Requests\MoveIndexRequest;

class MoveController extends Controller
{
    private $moveService;
    
    public function __construct(MoveServiceInterface $moveServiceInterface)
    {
    	$this->middleware('auth');
    	$this->moveService = $moveServiceInterface;
    }
    
    public function index(MoveIndexRequest $request)
    {
		// 画面表示用の情報を取得
    	$data = $this->moveService->index($request);
    	
    	// 画面表示用のリクエストデータを設定
    	$data['req'] = $request;
    	
    	return view('move.index', $data);
    }
    
    public function create()
    {
    	$data = $this->moveService->create();
    	return view('move.create', $data);
    }
    
    public function store(MoveStoreRequest $request)
    {
    	DB::transaction(function() use($request) {
    		$this->moveService->store($request);
    	}, 5);
    		
    	return redirect()->route('move.create');
    }
    
}
