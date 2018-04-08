@extends('layouts.layout')

@section('title', '受取方法')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
受取方法
<small>受取方法の管理と新規登録</small>
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
  <form action="{{ route('receipt.store') }}" method="POST" id="paymentForm">
  {{ csrf_field() }}
  {{-- receiptエンティティがある=編集、ない=新規 --}}
  @php
    if (isset($receipt)) {
      $id = $receipt->id;
      $wallet_id = $receipt->wallet->id;
      $wallet_name = $receipt->wallet->name;
      $name = $receipt->name;
      $dorder = $receipt->dorder;
    } else {
      $id = "";
      $wallet_id = "";
      $wallet_name = "";
      $name = "";
      $dorder = "";
    }
  @endphp
    <input type="hidden" id="id" name="id" value="{{ $id }}" />
    <div class="box-body">
      <div class="row">
        <!-- 支払い方法名称 -->
        <div class="col-md-8">
          <div class="form-group">
            <label for="exampleInputEmail1">受取方法名称</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="" value="{{ $name }}">
          </div>
        </div>
        <!-- /支払い方法名称 -->
        
        <!-- 関連する財布 -->
        <div class="col-md-3">
          <div class="form-group">
            <label for="exampleInputEmail1">関連する財布</label>
            <select type="text" class="form-control" id="walletId" name="walletId" placeholder="">
              <option value=""></option>
              @for ($i = 0; $i < count($wallets); $i++)
                @if ($wallets[$i]->id == $wallet_id)
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
            <input type="text" class="form-control" id="dorder" name="dorder" placeholder="" value="{{ $dorder }}">
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
<!-- /.box -->

<!-- .box -->
<div class="box">
  <div class="box-header">
    <h3 class="box-title">受取方法一覧</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="example2" class="table table-bordered table-hover">
      <thead>
      <tr>
        <th class="col-md-5">受取方法</th>
        <th class="col-md-4">財布</th>
        <th class="col-md-1">表示順</th>
        <th class="col-md-1">修正</th>
        <th class="col-md-1">削除</th>
      </tr>
      </thead>
      @for($i = 0; $i < count($receipts); $i++)
      <tbody>
      <tr>
        <td>{{ $receipts[$i]->name }}</td>
        <td>{{ $receipts[$i]->wallet->name }}</td>
        <td class="text-right">{{ $receipts[$i]->dorder }}</td>
        <td><form action="{{ route('receipt.edit', ['id' => $receipts[$i]->id ]) }}" method="GET"><button type="submit" class="btn">修正</button></form></td>
        <td><form action="{{ route('receipt.delete', ['id' => $receipts[$i]->id ]) }}" method="GET"><button type="submit" class="btn">削除</button></form></td>
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
                errMes = errMes + "<p>受取方法名称を入力してください</p>";
                errFlag = false;
            }
            
            if(!$("#walletId").val()) {
                errMes = errMes + "<p>財布を選択してください</p>";
                errFlag = false;
            }

            if(!$("#dorder").val() || isNaN($("#dorder").val())) {
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