@extends('layouts.layout')

@section('title', '勘定科目')

@section('menu_master', 'active')
@section('menu_account', 'active')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
勘定科目
<small>勘定科目の管理と新規登録</small>
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
<div class="box">
  <div class="box-header">
     <h3 class="box-title">登録</h3>
  </div>
            
  <form action="{{ route('account.store') }}" method="POST" id="accountForm">
  {{ csrf_field() }}
    <div class="box-body">
      <div class="row">
        <div class="col-md-10">
          <div class="form-group">
            <label for="exampleInputEmail1">勘定科目名称</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="">
          </div>
        </div>
        <div class="col-md-2">
            <label for="exampleInputEmail1">表示順</label>
            <input type="text" class="form-control" id="dorder" name="dorder" placeholder="">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <button type="button" class="btn btn-primary pull-right" id="btnSubmit">登録</button>
        </div>
      </div>
    </div>
    <!-- /.box-body -->
  </form>
</div>
<!-- /.box -->

<div class="box">
  <div class="box-header">
    <h3 class="box-title">勘定科目</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="example2" class="table table-bordered table-hover">
      <thead>
      <tr>
        <th class="col-md-9">名称</th>
        <th class="col-md-2">表示順</th>
        <th class="col-md-1">削除</th>
      </tr>
      </thead>
      @for($i = 0; $i < count($accounts); $i++)
      <tbody>
      <tr>
        <td>{{ $accounts[$i]->name }}</td>
        <td>{{ $accounts[$i]->dorder }}</td>
        <td>
          <form action="{{ route('account.delete', ['id' => $accounts[$i]->id ]) }}" method="GET">
            <button type="submit" class="btn">削除</button>
          </form>
        </td>
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
<div class="modal fade" id="modal-default">
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
            errMes = errMes + "<p>勘定科目名称を入力してください</p>";
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
            $('#accountForm').submit();
        } else {
            $("#err-modal").html(errMes);
            $('#modal-default').modal();
        }
    });
});
</script>
<!-- エラーダイアログ -->
@endsection