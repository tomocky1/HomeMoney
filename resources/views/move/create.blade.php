@extends('layouts.layout')

@section('title', '移動登録')

@section('menu_move', 'active')
@section('menu_move_regist', 'active')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
移動
<small>移動の登録</small>
</h1>
<ol class="breadcrumb">
<li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
<li class="active">Here</li>
</ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- box -->
<div class="box">

  <!-- .box-header -->
  <div class="box-header">
    <h3 class="box-title">登録</h3>
  </div>
  <!-- /.box-header -->
  
  <!-- form start -->
  <form action="{{ route('move.store') }}" method="POST" id="moveForm">
  {{ csrf_field() }}
    <div class="box-body">
    
      <!-- １行目 -->
      <div class="row">
      
        <!-- ▼ 摘要 -->
        <div class="col-md-6">
          <div class="form-group">
            <label for="summery">摘要</label>
            <input type="text" class="form-control" id="summery" name="summery" placeholder="">
          </div>
        </div>
        <!-- ▲ 摘要 -->
        
        <!-- ▼ 金額 -->
        <div class="col-md-2">
          <div class="form-group">
            <label for="amount">金額</label>
            <input type="text" class="form-control text-right" id="amount" name="amount" placeholder="円" />
          </div>
        </div>
        <!-- ▲ 金額 -->
        
        <div class="col-md-4">&nbsp;</div>
        
      </div>
      <!-- ▲ １行目 -->

      <!-- ▼ ２行目 -->
	  <div class="row">
        <!-- ▼ 移動元財布 -->
        <div class="col-md-2">
          <div class="form-group">
            <label for="accountId">移動元財布</label>
            <select type="text" class="form-control" id="srcWalletId" name="srcWalletId" placeholder="">
              <option value=""></option>
              @for ($i = 0; $i < count($wallets); $i++)
                <option value="{{ $wallets[$i]->id }}">{{ $wallets[$i]->name }}</option>
              @endfor
            </select>
          </div>
        </div>
        <!-- ▲ 移動元財布 -->
        
        <!-- ▼ 移動先財布 -->
        <div class="col-md-2">
          <div class="form-group">
            <label for="receiptId">移動先財布</label>
            <select type="text" class="form-control" id="distWalletId" name="distWalletId" placeholder="">
              <option value=""></option>
              @for ($i = 0; $i < count($wallets); $i++)
                <option value="{{ $wallets[$i]->id }}">{{ $wallets[$i]->name }}</option>
              @endfor
            </select>
          </div>
        </div>
        <!-- ▲ 移動先財布 -->
        

        <!-- ▼ 取引日 -->
        <div class="col-md-2">
          <div class="form-group">
            <label for="tradeDate">取引日</label>
            <input type="text" class="form-control" id="tradeDate" name="tradeDate" placeholder="" value="{{ $today }}">
          </div>
        </div>
        <!-- ▲ 取引日 -->
        
        <!-- ▼ 決済日 -->
        <div class="col-md-2">
          <div class="form-group">
            <label for="settleDate">決済日</label>
            <input type="text" class="form-control" id="settleDate" name="settleDate" placeholder="" value="{{ $today }}">
          </div>
        </div>
        <!-- ▲ 決済日 -->
        
        <div class="col-md-4">&nbsp;</div>
        
      </div>
      <!-- ▲ ２行目 -->
      
      <!-- ▼ ３行目 -->
      <div class="row">
      
        <!-- 登録ボタン -->
        <div class="col-md-11">&nbsp;</div>
        <div class="col-md-1">
          <button type="button" class="btn btn-primary" id="btnSubmit">登録</button>
        </div>
        <!-- /登録ボタン -->
      
      </div>
      <!-- ▲ ３行目 -->
      
      
    </div>
    <!-- /.box-body -->
  </form>
</div>
<!-- /.box -->



</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- ▼ エラーダイアログ -->
<div class="modal modal-warning fade" id="errorDialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">入力に誤りがあります</h4>
      </div>
      <div class="modal-body" id="err-modal">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- ▲ エラーダイアログ -->

<!-- ▼ 登録時の確認ダイアログ -->
<div class="modal modal-default fade" id="registConfirmDialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">確認</h4>
      </div>
      <div class="modal-body" id="registConfirm">
        登録してもよろしいですか？
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="notRegistBtn">登録しない</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="registBtn">登録する</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- ▲ エラーダイアログ -->

<script type="text/javascript">
	$(function(){

		// 取引日にdatepickerを設定
	    $('#tradeDate').datepicker({
	        autoclose: true,
	        format: 'yyyy年mm月dd日'
        });

		// 決済日にdatepickerを設定
	    $('#settleDate').datepicker({
	        autoclose: true,
	        format: 'yyyy年mm月dd日'
        });

        // フォーカスの初期値を摘要に設定
        $('#summery').focus();

        // 金額を設定
        $('#amount').focus(function() {
            // カンマ・円を除去
			if($('#amount').val().length =! 0) { $('#amount').val($('#amount').val().replace(' 円', '').replace(/,/g, '')); }
            // 数値としての金額を退避する
            $(this).data('bak', $('#amount').val());
            // 選択状態にする
            $(this).select();
        });

        // 金額を設定
        $('#amount').blur(function() {
            // 数値でなければ、退避した金額から復旧
            if($(this).val() == null || isNaN($(this).val())) { $(this).val($(this).data('bak')); }
			$(this).val($(this).val().split(/(?=(?:\d{3})+$)/).join() + " 円");
        });

        // 登録ボタン押下 バリデーションを実行し登録確認ダイアログを表示
		$('#btnSubmit').click(function(){
			var errFlag = true;
			var errMes = "";
			if (isEmpty($("#summery").val())) {
				errMes = errMes + "<p>摘要を入力してください</p>";
				errFlag = false;
			}
			
	        if (isNotYen($('#amount').val())) {
				errMes = errMes + "<p>金額を数値で入力してください</p>";
				errFlag = false;
			}

			if (isEmpty($('#srcWalletId').val())) {
				errMes = errMes + "<p>移動元財布を入力してください</p>";
				errFlag = false;
			}

			if (isEmpty($('#distWalletId').val())) {
				errMes = errMes + "<p>移動先財布を入力してください</p>";
				errFlag = false;
			}

			if (isNotDate($("#settleDate").val())) {
				errMes = errMes + "<p>決済日の入力形式が不正です</p>";
				errFlag = false;
			}
			
			if (errFlag) {
				$('#registConfirmDialog').modal();
				$('#notRegistBtn').focus();
			} else {
				$("#err-modal").html(errMes);
				$('#errorDialog').modal();
			}

		});

        // 確認ダイアログから登録を実行する
		$('#registBtn').click(function() {
			$('#moveForm').submit();
		});
	});
</script>
<!-- エラーダイアログ -->
@endsection