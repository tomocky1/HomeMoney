@extends('layouts.layout')

@section('title', '収入一覧')

@section('menu_income', 'active')
@section('menu_income_list', 'active')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
収入
<small>収入の検索・更新・削除</small>
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
    <h3 class="box-title">検索条件</h3>
  </div>
  <!-- /.box-header -->

  <!-- form start -->
  <form action="{{ route('income.search') }}" method="POST" id="searchIncomeForm">
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
        
        <!-- ▼ 検索条件：勘定科目 -->
        <div class="col-md-3">
          <div class="form-group">
            <label for="accountId">勘定科目</label>
            <select type="text" class="form-control" id="accountId" name="accountId" placeholder="">
              <option value=""></option>
              @for ($i = 0; $i < count($accounts); $i++)
                @if ($req->accountId == $accounts[$i]->id)
                  <option value="{{ $accounts[$i]->id }}" selected="selected">{{ $accounts[$i]->name }}</option>
                @else
                  <option value="{{ $accounts[$i]->id }}">{{ $accounts[$i]->name }}</option>
                @endif
              @endfor
            </select>
          </div>
        </div>
        <!-- ▲ 検索条件：勘定科目 -->
        
        <!-- ▼ 検索条件：受取方法 -->
        <div class="col-md-3">
          <div class="form-group">
            <label for="receiptId">受取方法</label>
            <select type="text" class="form-control" id="receiptId" name="receiptId" placeholder="">
              <option value=""></option>
              @for ($i = 0; $i < count($receipts); $i++)
                @if ($req->receiptId == $receipts[$i]->id)
                  <option value="{{ $receipts[$i]->id }}" selected="selected">{{ $receipts[$i]->name }}</option>
                @else
                  <option value="{{ $receipts[$i]->id }}">{{ $receipts[$i]->name }}</option>
                @endif
              @endfor
            </select>
          </div>
        </div>
        <!-- ▲ 検索条件：受取方法 -->
        
      </div><!-- ./row -->

      <!-- 登録ボタン -->
      <div class="row">
        <div class="col-md-11">&nbsp;</div>
        <div class="col-md-1">
          <button type="button" class="btn btn-primary" id="btnSubmit">検索</button>
        </div>
      </div>
      <!-- /登録ボタン -->
        
    </div>
    <!-- /.box-body -->
  </form>
</div>
<!-- /.box -->

<!-- .box -->
<div class="box">
  <div class="box-header">
    <h3 class="box-title">収入一覧</h3>
  </div>
  <!-- /.box-header -->

  <div class="box-body">
    <table id="example2" class="table table-bordered table-hover">
      <thead>
        <tr>
          <th class="col-md-1 text-center">収入番号</th>
          <th class="col-md-3 text-center">摘要</th>
          <th class="col-md-1 text-center">勘定科目</th>
          <th class="col-md-1 text-center">受取方法</th>
          <th class="col-md-1 text-center">金額</th>
          <th class="col-md-1 text-center">日付</th>
          <th class="col-md-1 text-center">決済日</th>
          <th class="col-md-1 text-center">修正</th>
          <th class="col-md-1 text-center">削除</th>
        </tr>
      </thead>

      @for($i = 0; $i < count($incomes); $i++)
      <tbody>
        <tr>
          <td class="text-center">{{ $incomes[$i]->income_no }}</td>
          <td>{{ $incomes[$i]->summery }}</td>
          <td class="text-center">{{ $incomes[$i]->account->name }}</td>
          <td class="text-center">{{ $incomes[$i]->receipt->name }}</td>
          <td class="text-center">{{ $incomes[$i]->amount }}&nbsp;円</td>
          <td class="text-center">{{ $incomes[$i]->trade_date->format('Y-m-d') }}</td>
          <td class="text-center">{{ $incomes[$i]->settle_date->format('Y-m-d') }}</td>
          <td class="text-center"><form action="{{ route('receipt.edit', ['id' => $incomes[$i]->id ]) }}" method="GET"><button type="submit" class="btn">修正</button></form></td>
          <td class="text-center"><form action="{{ route('receipt.delete', ['id' => $incomes[$i]->id ]) }}" method="GET"><button type="submit" class="btn">削除</button></form></td>
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

		// 日付（範囲指定）
        $('#tradeDateRange').daterangepicker({
            locale: { format: 'YYYY年MM月DD日', cancelLabel: 'クリア', applyLabel: '適用' }
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
                $('#searchIncomeForm').submit();
            } else {
                $("#err-modal").html(errMes);
                $('#modal-default').modal();
            }
        });
    });
    </script>
    <!-- エラーダイアログ -->
@endsection