@extends('layouts.layout')

@section('title', '残高一覧')

@section('menu_balance', 'active')
@section('menu_balance_list', 'active')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
残高
<small>残高の照会</small>
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


<!-- .box -->
<div class="box">
  <div class="box-header">
    <h3 class="box-title">残高一覧</h3>
  </div>
  <!-- /.box-header -->

  <div class="box-body">
    <table id="example2" class="table table-bordered table-hover">
      <thead>
        <tr>
          <th class="col-md-3 text-left">財布</th>
          <th class="col-md-2 text-center">金額</th>
          <th class="col-md-3 text-center">最終更新日</th>
          <th class="col-md-4">&nbsp;</th>
          
        </tr>
      </thead>

      @for($i = 0; $i < count($balances); $i++)
      <tbody>
        <tr>
          <td class="text-left">{{ $balances[$i]->wallet->name }}</td>
          <td class="text-center">{{ $balances[$i]->balance }}&nbsp;円</td>
          <td class="text-center">{{ $balances[$i]->update_tsp }}</td>
          <td>&nbsp;</td>
        </tr>
      </tbody>
      @endfor
    </table>
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection