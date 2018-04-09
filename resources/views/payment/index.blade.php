@extends('layouts.layout')

@section('title', '支払方法管理')

@section('menu_master', 'active')
@section('menu_payment', 'active')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
支払方法管理
<small>支払方法の管理と新規登録</small>
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

<!-- ▼ 登録用 box -->
<div class="box">

  <!-- .box-header -->
  <div class="box-header">
      @if (isset($editFlag))
      <h3 class="box-title">修正</h3>
      @else
      <h3 class="box-title">登録</h3>
      @endif
  </div>
  <!-- /.box-header -->
  
  <!-- form start -->
  <form action="{{ route('payment.store') }}" method="POST" id="paymentForm">
  @if (isset($payment->id))
    <input type="hidden" id="id" name="id" value="{{ $payment->id }}" />
  @endif
  {{ csrf_field() }}
    <div class="box-body">
      <div class="row">
        <!-- 支払い方法名称 -->
        <div class="col-md-8">
          <div class="form-group">
            <label for="name">支払方法名称</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $payment->name or '' }}">
          </div>
        </div>
        <!-- /支払い方法名称 -->
        
        <!-- 関連する財布 -->
        <div class="col-md-3">
          <div class="form-group">
            <label for="walletId">関連する財布</label>
            <select type="text" class="form-control" id="walletId" name="walletId">
              <option value=""></option>
              @for ($i = 0; $i < count($wallets); $i++)
                @if (isset($payment) && $payment->wallet_id == $wallets[$i]->id)
                  <option value="{{ $wallets[$i]->id }}" selected="selected">{{ $wallets[$i]->name }}</option>
                @else
                  <option value="{{ $wallets[$i]->id }}">{{ $wallets[$i]->name }}</option>
                @endif
              @endfor
            </select>
          </div>
        </div>
        <!-- /関連する財布 -->
        
        <!-- 表示順 -->
        <div class="col-md-1">
          <div class="form-group">
            <label for="exampleInputEmail1">表示順</label>
            <input type="text" class="form-control" id="dorder" name="dorder" value="{{ $payment->dorder or '' }}">
          </div>
        </div>
        <!-- /表示順 -->
        
      </div>
      <div class="row">
      
        <!-- 登録ボタン -->
        <div class="col-md-11">&nbsp;</div>
        <div class="col-md-1">
          <button type="button" class="btn btn-primary" id="btnSubmit">登録</button>
        </div>
        <!-- /登録ボタン -->
      
      </div>
    </div>
    <!-- /.box-body -->
  </form>
</div>
<!-- ▲ 登録用 box -->

<!-- .box -->
<div class="box">
  <div class="box-header">
    <h3 class="box-title">支払方法一覧</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="paymentList" class="table table-bordered table-hover">
      <thead>
      <tr>
        <th class="col-md-5 text-center">支払方法</th>
        <th class="col-md-4 text-center">財布</th>
        <th class="col-md-1 text-center">表示順</th>
        <th class="col-md-1 text-center">修正</th>
        <th class="col-md-1 text-center">削除</th>
      </tr>
      </thead>
      @for($i = 0; $i < count($payments); $i++)
      <tbody>
      <tr>
        <td class="text-center">{{ $payments[$i]->name }}</td>
        <td class="text-center">{{ $payments[$i]->wallet->name }}</td>
        <td class="text-center">{{ $payments[$i]->dorder }}</td>
        <td class="text-center"><form action="{{ route('payment.edit', ['id' => $payments[$i]->id ]) }}" method="GET"><button type="submit" class="btn">修正</button></form>
        <td class="text-center"><form action="{{ route('payment.delete', ['id' => $payments[$i]->id ]) }}" method="GET"><button type="submit" class="btn">削除</button></form></td>
      </tr>
      </tbody>
      @endfor
    </table>
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->


</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- エラーダイアログ -->
<div class="modal modal-warning fade" id="modal-default">
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
<!-- /.modal -->

<script type="text/javascript">
	$(function(){
		$('#btnSubmit').click(function(){
			var errFlag = true;
			var errMes = "";
			if(!$("#name").val()) {
				errMes = errMes + "<p>支払方法名称を入力してください</p>";
				errFlag = false;
			}
			
			if(!$("#walletId").val()) {
				errMes = errMes + "<p>財布を選択してください</p>";
				errFlag = false;
			}

			if(!$("#dorder").val()) {
				errMes = errMes + "<p>表示順を入力してください</p>";
				errFlag = false;
			} else if( isNaN($("#dorder").val())) {
				errMes = errMes + "<p>表示順は数値を入力してください</p>";
				errFlag = false;
			}
			if(errFlag) {
				$('#paymentForm').submit();
			} else {
				$("#err-modal").html(errMes);
				$('#modal-default').modal();
			}
		});
	});
</script>
<!-- エラーダイアログ -->
@endsection