@extends('layouts.layout')

@section('title', '移動一覧')

@section('menu_move', 'active')
@section('menu_move_list', 'active')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
移動
<small>移動の検索・更新・削除</small>
</h1>
<ol class="breadcrumb">
<li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
<li class="active">Here</li>
</ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

<!-- ▼ エラーメッセージ -->
@if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
<!-- ▼ エラーメッセージ -->

<!-- ▼ 検索 box -->
<div class="box">

<!-- .box-header -->
<div class="box-header">
<h3 class="box-title">検索条件</h3>
</div>
<!-- /.box-header -->

<!-- form start -->
<form action="{{ route('move.index') }}" method="POST" id="moveSearchForm">
{{ csrf_field() }}
<div class="box-body">
<div class="row">

<!-- ▼ 検索条件：日付 -->
<div class="col-md-4">
<!-- Date range -->
<div class="form-group">
<label>日付:</label>

<div class="input-group">
<div class="input-group-addon">
<i class="fa fa-calendar"></i>
</div>
<input type="text" class="form-control pull-right" id="tradeDateRange" name="tradeDateRange" value="{{ $req->tradeDateRange }}">
</div>
<!-- /.input group -->
</div>
<!-- /.form group -->
 
</div>
<!-- ▲ 検索条件：日付 -->

<!-- ▼ 検索条件：移動元財布 -->
<div class="col-md-3">
<div class="form-group">
<label for="srcWalletId">移動元財布</label>
<select type="text" class="form-control" id="srcWalletId" name="srcWalletId" placeholder="">
<option value=""></option>
@for ($i = 0; $i < count($wallets); $i++)
@if ($req->srcWalletId == $wallets[$i]->id)
<option value="{{ $wallets[$i]->id }}" selected="selected">{{ $wallets[$i]->name }}</option>
@else
<option value="{{ $wallets[$i]->id }}">{{ $wallets[$i]->name }}</option>
@endif
@endfor
</select>
</div>
</div>
<!-- ▲ 検索条件：移動元財布 -->

<!-- ▼ 検索条件：移動先財布 -->
<div class="col-md-3">
<div class="form-group">
<label for="distWalletId">移動先財布</label>
<select type="text" class="form-control" id="distWalletId" name="distWalletId" placeholder="">
<option value=""></option>
@for ($i = 0; $i < count($wallets); $i++)
	@if ($req->distWalletId == $wallets[$i]->id)
		<option value="{{ $wallets[$i]->id }}" selected="selected">{{ $wallets[$i]->name }}</option>
		@else
<option value="{{ $wallets[$i]->id }}">{{ $wallets[$i]->name }}</option>
@endif
@endfor
</select>
</div>
</div>
<!-- ▲ 検索条件：移動先財布 -->

</div><!-- ./row -->

<!-- ▼ 検索ボタン -->
<div class="row">
<div class="col-md-11">&nbsp;</div>
<div class="col-md-1">
<button type="button" class="btn btn-primary" id="btnSubmit">検索</button>
</div>
</div>
<!-- ▲ 検索ボタン -->

</div>
<!-- /.box-body -->
</form>
</div>
<!-- /.box -->

<!-- .box -->
<div class="box">
<div class="box-header">
<h3 class="box-title">移動一覧</h3>
</div>
<!-- /.box-header -->

<div class="box-body">
<table id="example2" class="table table-bordered table-hover">
<thead>
<tr>
<th class="col-md-1 text-center">移動番号</th>
<th class="col-md-3 text-center">摘要</th>
<th class="col-md-1 text-center">移動元財布</th>
<th class="col-md-1 text-center">移動先財布</th>
<th class="col-md-1 text-center">金額</th>
<th class="col-md-1 text-center">日付</th>
<th class="col-md-1 text-center">決済日</th>
<th class="col-md-1 text-center">修正</th>
<th class="col-md-1 text-center">削除</th>
</tr>
</thead>

@for($i = 0; $i < count($moves); $i++)
<tbody>
<tr>
<td class="text-center">{{ $moves[$i]->move_no }}</td>
<td class="text-center">{{ $moves[$i]->summery }}</td>
<td class="text-center">{{ $moves[$i]->srcWallet->name }}</td>
<td class="text-center">{{ $moves[$i]->distWallet->name }}</td>
<td class="text-center">{{ $moves[$i]->amount }}&nbsp;円</td>
<td class="text-center">{{ $moves[$i]->trade_date->format('Y-m-d') }}</td>
<td class="text-center">{{ $moves[$i]->settle_date->format('Y-m-d') }}</td>
<td class="text-center"><form action="{{ route('outgoing.edit', ['id' => $moves[$i]->id ]) }}" method="GET"><button type="submit" class="btn">修正</button></form></td>
<td class="text-center"><form action="{{ route('outgoing.delete', ['id' => $moves[$i]->id ]) }}" method="GET"><button type="submit" class="btn">削除</button></form></td>
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
		<button type="button" class="btn btn-default" data-dismiss="modal" id="btn-close-errdiag">閉じる</button>
		</div>
		</div>
		<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
		</div>
							<!-- /.modal -->

    <script type="text/javascript">
    $(function(){

		// 日付（範囲指定）
        $('#tradeDateRange').daterangepicker({
            locale: { format: 'YYYY年MM月DD日', cancelLabel: 'クリア', applyLabel: '適用' },
            startDate: '{{ $startDate }}',
            endDate: '{{ $endDate }}',
        });
        $('#tradeDateRange').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('YYYY年MM月DD日') + ' - ' + picker.endDate.format('YYYY年MM月DD日'));
        });
        $('#tradeDateRange').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
        });

        // 検索ボタン押下時のチェック
        $('#btnSubmit').click(function(){

            // エラーフラグ エラーならtrue
            var errFlag = false;
            var errMes = "";

			// 日付範囲のチェック
            if($("#tradeDateRange").val() == null) {

            } else if(!$("#tradeDateRange").val().match(/\d\d\d\d年\d\d月\d\d日\s-\s\d\d\d\d年\d\d月\d\d日/u)) {
                errMes = errMes + "<p>日付は範囲指定してください</p>";
                errFlag = true;
            }


			
            if(!errFlag) {
                $('#moveSearchForm').submit();
            } else {
                $("#err-modal").html(errMes);
                $('#modal-default').modal();
                $('#btn-close-errdiag').focus();
            }
        });
    });
    </script>
    <!-- エラーダイアログ -->
@endsection