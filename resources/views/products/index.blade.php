@extends('layouts.master')
@section('title','المنتجات')

@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('page-header')
	<!-- breadcrumb -->
	<div class="breadcrumb-header justify-content-between">
		<div class="my-auto">
			<div class="d-flex">
				<a class="content-title mb-0 my-auto" href="{{route('home')}}">الصفحه الرئيسيه</a>
				<span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
			</div>
		</div>
	</div>
	<!-- breadcrumb -->
@endsection

@section('content')
		<!-- row opened -->
		<div class="row row-sm">
			<!--div-->
			<div class="col-xl-12">
				<div class="card mg-b-20">
					<div class="card-header pb-0">
						@can('اضافة منتج')
							<div class="col-sm-6 col-md-4 col-xl-3">
								<a class="btn btn-outline-primary btn-block"  href="{{ route('products.create') }}">
									<i class="fas fa-plus"></i>&nbsp; اضافه منتج
								</a>
							</div>
						@endcan
					</div>


					
					@include('includes.alerts.success')
					@include('includes.alerts.errors')
					
					<div class="card-body">
						<div class="table-responsive">
							<table class="table text-md-nowrap" id="example2">
								<thead>
									<tr>
										<th class="border-bottom-0">#</th>
										<th class="border-bottom-0">المنتج</th>
										<th class="border-bottom-0">القسم</th>
										<th class="border-bottom-0">الملاحظات</th>
										<th class="border-bottom-0">الاعدادات</th>
									</tr>
								</thead>
								<tbody>
									@if ($products->count() > 0)
										@foreach ($products as $index => $product)
											<tr>
												<td>{{ $index+1 }}</td>
												<td>{{ $product->name }}</td>
												<td>{{ $product->category->name }}</td>
												<td>{{ $product->description }}</td>
												<td>            
													@can('تعديل منتج')                                                       
														<a class="btn btn-sm btn-info" 
															href="{{ route('products.edit',$product->id) }}" 
															title="تعديل">
															<i class="las la-pen"></i>
														</a>
													@endcan 

													@can('حذف منتج') 
														<!-- delete -->
														<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
															data-toggle="modal" href="#delete" title="حذف">
															<i class="las la-trash"></i>
														</a>

														<div class="modal" id="delete">
															<div class="modal-dialog modal-dialog-centered" role="document">
																<div class="modal-content modal-content-demo">
																	<div class="modal-header">
																		<h6 class="modal-title">حذف المنتج</h6><button aria-label="Close" class="close" data-dismiss="modal"
																			type="button"><span aria-hidden="true">&times;</span></button>
																	</div>
																	<form action="{{ route('products.destroy',$product->id) }}" method="post">
																		@method('delete')
																		@csrf	

																		<div class="modal-body">
																			<p>هل انت متاكد من عملية الحذف ؟</p><br>
																		</div>
																		<div class="modal-footer">
																			<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
																			<button type="submit" class="btn btn-danger">تاكيد</button>
																		</div>
																	</form>

																</div>
															</div>
														</div>
													@endcan
										
												</td>
											</tr>
										@endforeach
									@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!--/div-->	
		</div>
		<!-- /row -->
	</div>
	<!-- Container closed -->
</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
@endsection