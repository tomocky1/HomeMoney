@extends('layouts.layout')

@section('title', 'メニュー');

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      メニュー
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
      <li class="active">Here</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content container-fluid">
  
    <!-- ▼ 収入 -->
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">収支</h3>
      </div>
      
      <!-- /.box-header -->
      <div class="box-body">
        <div>
          <a href="{{ route('income.index') }}">収入一覧</a><br />
        </div>
        <div>
          <a href="{{ route('income.create') }}">収入登録</a><br />
        </div>
        
       
      </div>
      <!-- /.box-body -->
    </div>
    <!-- ▲ 収入 -->
  
    <!-- ▼ 支出 -->
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">支出</h3>
      </div>
      
      <!-- /.box-header -->
      <div class="box-body">
        <div>
          <a href="{{ route('outgoing.index') }}">支出一覧</a><br />
        </div>
        <div>
          <a href="{{ route('outgoing.create') }}">支出登録</a><br />
        </div>
        
       
      </div>
      <!-- /.box-body -->
    </div>
    <!-- ▲ 支出 -->
  
    <!-- ▼ マスタ管理ｗ -->
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">マスタ管理</h3>
      </div>
      
      <!-- /.box-header -->
      <div class="box-body">
        <div>
          <a href="{{ route('wallet.index') }}">財布</a><br />
        </div>
        <div>
          <a href="{{ route('payment.index') }}">支払方法</a><br />
        </div>
        <div>
          <a href="{{ route('receipt.index') }}">受取方法</a><br />
        </div>
        <div>
          <a href="{{ route('account.index') }}">勘定科目</a><br />
        </div>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- ▲ マスタ管理 -->
    
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection