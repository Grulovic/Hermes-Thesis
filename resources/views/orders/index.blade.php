@section('title', 'HERMES - Orders')

@extends('layouts.layout')

@include('orders.second_navigation')

@section('scripts')
	<script type="text/javascript" src="{{ asset('js/orders.js') }}"></script>
@endsection

@section('content')
<div class="row">
	<div class="col-lg-4">

	<div class="card mt-3 ml-lg-3">
		<div class="card-header">
			<h1>Orders: </h1>
		</div>
		
		<div id="orders" class="card-body adjust_height" style="overflow-y: auto;">
			<div class="list-group">
			@foreach ($orders as $order)
				@include('orders.order')
			@endforeach
			</div>	
		</div>
		<div class="card-header border-top">
			<div class="btn btn-sm border p-2 float-left" style="background-color: white;">
				Showing <span class="font-weight-bold text-primary">{{$showing_orders}}</span> 
				of <span class="font-weight-bold text-primary">{{$num_of_orders}}</span>
			</div>
			<div class="simple-paginate float-right">{{$orders->links()}}</div>
		</div>
	</div>
	
		
	</div>

	<div id="show_page" class="col-lg-8">
		@if($show_order != null)
		<?php
			$order = $show_order;
		?>
			@include('orders.show')
		@endif
	</div>

	<!-- <div class="col-lg-3">
		<div id="show_tertiary">
			
		</div>
		<div id="show_user">
			
		</div>
	</div> -->
@endsection