
@extends('layouts.layout')

@section('title', '支出登録')

@section('menu_outgoing', 'active')
@section('menu_outgoing_regist', 'active')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
支出
<small>支出の登録</small>
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
    @if (isset($editFlag))
    <h3 class="box-title">修正</h3>
    @else
    <h3 class="box-title">登録</h3>
    @endif    
  </div>
  <!-- /.box-header -->
  
  <!-- form start -->
  <form action="{{ route('outgoing.store') }}" method="POST" id="outgoingForm">
    @if (isset($editFlag))
    <input type="hidden" name="id" id="id" value="{{ $outgoing->id }}" />
    @endif  
  {{ csrf_field() }}
    <div class="box-body">
    
      <!-- １行目 -->
      <div class="row">
      
        <!-- ▼ 摘要 -->
        <div class="col-md-6">
          <div class="form-group">
            <label for="summery">摘要</label>
            <input type="text" class="form-control" id="summery" name="summery" value="{{ $outgoing->summery or '' }}" />
          </div>
        </div>
        <!-- ▲ 摘要 -->
        
        <!-- ▼ 金額 -->
        <div class="col-md-2">
          <div class="form-group">
            <label for="amount">金額</label>
            <input type="text" class="form-control text-right yen" id="amount" name="amount" value="{{ $outgoing->amount or '' }}" />
          </div>
        </div>
        <!-- ▲ 金額 -->
        
        <div class="col-md-4">&nbsp;</div>
        
      </div>
      <!-- ▲ １行目 -->

      <!-- ▼ ２行目 -->
      <div class="row">
        <!-- ▼ 勘定科目 -->
        <div class="col-md-2">
          <div class="form-group">
            <label for="accountId">勘定科目</label>
            <select type="text" class="form-control" id="accountId" name="accountId" placeholder="">
              <option value=""></option>
              @for ($i = 0; $i < count($accounts); $i++)
                @if (isset($editFlag))
                  @if ($accounts[$i]->id == $outgoing->account_id)
                  <option value="{{ $accounts[$i]->id }}" selected="selected">{{ $accounts[$i]->name }}</option>
                  @else
                  <option value="{{ $accounts[$i]->id }}">{{ $accounts[$i]->name }}</option>
                  @endif
                @else
                  <option value="{{ $accounts[$i]->id }}">{{ $accounts[$i]->name }}</option>
                @endif
              @endfor
            </select>
          </div>
        </div>
        <!-- ▲ 勘定科目 -->
        
        <!-- ▼ 支払方法 -->
        <div class="col-md-2">
          <div class="form-group">
            <label for="paymentId">支払方法</label>
            <select type="text" class="form-control" id="paymentId" name="paymentId">
              <option value=""></option>
              @for ($i = 0; $i < count($payments); $i++)
                @if (isset($editFlag))
                  @if ($payments[$i]->id == $outgoing->payment_id)
                  <option value="{{ $payments[$i]->id }}" selected="selected">{{ $payments[$i]->name }}</option>
                  @else
                  <option value="{{ $payments[$i]->id }}">{{ $payments[$i]->name }}</option>
                  @endif
                @else
                  <option value="{{ $payments[$i]->id }}">{{ $payments[$i]->name }}</option>
                @endif
              @endfor
            </select>
          </div>
        </div>
        <!-- ▲ 支払方法 -->
        
        
        <!-- ▼ 取引日 -->
        <div class="col-md-2">
          <div class="form-group">
            <label for="tradeDate">日付</label>
            <input type="text" class="form-control" id="tradeDate" name="tradeDate" placeholder="" value="{{ $outgoing->tradeDate or $today }}">
          </div>
        </div>
        <!-- ▲ 取引日 -->
        
        
        <!-- ▼ 決済日 -->
        <div class="col-md-2">
          <div class="form-group">
            <label for="settleDate">決済日</label>
            <input type="text" class="form-control" id="settleDate" name="settleDate" placeholder="" value="{{ $outgoing->settleDate or $today }}">
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

        // 日付にdatepickerを設定
        $('#tradeDate').datepicker({
            autoclose: true,
            format: 'yyyy年mm月dd日'
        });

        // 決済日にdatepickerを設定
        $('#settleDate').datepicker({
            autoclose: true,
            format: 'yyyy年mm月dd日'
        });

        // 摘要にフォーカスを設定
        $('#summery').focus();

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

            if (isEmpty($('#accountId').val())) {
                errMes = errMes + "<p>勘定科目を入力してください</p>";
                errFlag = false;
            }

            if (isEmpty($('#paymentId').val())) {
                errMes = errMes + "<p>支払方法を入力してください</p>";
                errFlag = false;
            }
            
            if (isNotDate($("#tradeDate").val())) {
                errMes = errMes + "<p>日付の入力形式が不正です</p>";
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
            $('#outgoingForm').submit();
        });
    });
</script>
<!-- エラーダイアログ -->
@endsection