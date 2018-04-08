@extends('layouts.layout')

@section('title', '収支一覧');

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
収支一覧
<small></small>
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
		<!-- /.box-header -->
		<div class="box-body">
			<table id="example2" class="table table-bordered table-hover">
				<thead>
				<tr>
				<th>日付</th>
				<th>摘要</th>
				<th>支払い方法</th>
				<th>財布</th>
				<th>収入</th>
				<th>支出</th>
				<th>決済日</th>
				</tr>
				</thead>
				@foreach($accounts as $account)
				<tbody>
				<tr>
				<!-- 日付 --><td>{{ $account->exe_date }}</td>
				<!-- 摘要 --><td>{{ $account->summery }}</td>
				<!-- 支払い方法 --><td>{{ $account->payment->payment_name }}</td>
				<!-- 財布 --><td>{{ $account->payment->wallet->name }}</td>
				<!-- 収入 --><td>
				@if($account->in_out)
				    {{ $account->amount }}
				@else
				    &nbsp;
				@endif
				</td>
				<!-- 支出 --><td>
				@if($account->in_out == false)
				    {{ $account->amount }}
				@else
				    &nbsp;
				@endif
				</td>
				<!-- 決済日 --><td>{{ $account->settle_date }}</td>
				</tr>
				</tbody>
				@endforeach
				</table>
				{!! $accounts->render() !!}
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
				
				
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection
				 