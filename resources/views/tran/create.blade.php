@extends('layouts.layout')

@section('title', '収支登録')

@section('script')
<!-- bootstrap datepicker -->
<script src="{{ asset('assets/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ asset('assets/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<script type="text/javascript">
$(function() {
    $('#exeDate').datepicker({
        autoclose: true,
        format: 'yyyy/mm/dd'
    });
});
</script>

@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        収支登録
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
        
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">登録</h3>
            </div>
            <!-- /.box-header -->
            
            @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
              </ul>
            </div>
            @endif
            
            <!-- form start -->
            <form role="form" action="{{ action('AccountController@store') }}" method="POST">
            {{ csrf_field() }}
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="summery">摘要</label>
                      <input type="text" class="form-control" id="summery" name="summery" placeholder="" />
                    </div>
                  </div>
                </div>
                
                <div class="row">
                <!-- 支払い方法 -->
                <div class="col-md-3"> 
                  <div class="form-group">
                    <label>支払い方法</label>
                    <select class="form-control select2" id="paymentId" name="paymentId" style="width: 100%;">
                      @foreach($payments as $payment)
                      <option value="{{ $payment->id }}">{{ $payment->payment_name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <!--  ./支払い方法 -->
                
                <!-- 勘定科目 -->
                <div class="col-md-3"> 
                  <div class="form-group">
                    <label>勘定科目</label>
                    <select class="form-control select2" id="accountListId" name="accountListId" style="width: 100%;">
                      @foreach($accountLists as $accountList)
                      <option value="{{ $accountList->id }}">{{ $accountList->account_name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <!--  ./勘定科目 -->
                </div>
                
                <div class="row">
                <!-- 取引日 -->
                <div class="col-md-3"> 
                  <div class="form-group">
                    <label>取引日</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="exeDate" name="exeDate" />
                    </div>
                  </div>
                </div>
                <!--  ./取引日 -->
                
                <!-- 収入金額 -->
                <div class="col-md-3"> 
                  <div class="form-group">
                    <label>収入金額</label>
                    <div class="input-group">
                      <input type="text" class="form-control pull-right" id="inCome" name="inCome" />
                      <div class="input-group-addon">円</div>
                    </div>
                  </div>
                </div>
                <!--  ./収入金額 -->
                
                <!-- 支出金額 -->
                <div class="col-md-3"> 
                  <div class="form-group">
                    <label>支出金額</label>
                    <div class="input-group">
                      <input type="text" class="form-control pull-right" id="outCome" name="outCome" />
                      <div class="input-group-addon">円</div>
                    </div>
                  </div>
                </div>
                <!--  ./支出金額 -->
                </div>



              <div class="box-footer pull-right">
                <button type="submit" class="btn btn-primary">登録</button>
              </div>
            </form>
          </div>
          <!-- /.box -->


        </div>
        <!--/.col (left) -->

                      </div>
                      <!-- /.row -->
                      </section>
                      <!-- /.content -->
                      </div>
                      <!-- /.content-wrapper -->
@endsection
