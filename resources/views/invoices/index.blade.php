@extends('layouts.master')
@section('title','الفواتير')

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
				<a class="content-title mb-0 my-auto" href="{{route('home')}}">الصفحه الرئيسيه</a><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الفواتير</span>
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
						<div class="col-sm-6 col-md-4 col-xl-3">
							@can('اضافة فاتورة')
								<a class="btn btn-outline-primary"  href="{{ route('invoices.create') }}">
									<i class="fas fa-plus"></i>&nbsp; اضافة فاتورة
								</a>
							@endcan
							
							@can('تصدير EXCEL')
								<a class="btn btn-outline-primary"  href="{{ route('invoices.export') }}">
									تصدير اكسل
								</a>
							@endcan
						</div>
					</div>

						
					@include('includes.alerts.success')
					@include('includes.alerts.errors')
					
					<div class="card-body">
						<div class="table-responsive">
							<table id="example1" class="table key-buttons text-md-nowrap" data-page-length='10'style="text-align: center">

							{{-- <table class="table text-md-nowrap" id="example2"> --}}
								<thead>
									<tr>
										<th class="border-bottom-0">#</th>
										<th class="border-bottom-0">رقم الفاتورة</th>
										<th class="border-bottom-0">تاريخ القاتورة</th>
										<th class="border-bottom-0">تاريخ الاستحقاق</th>
										<th class="border-bottom-0">المنتج</th>
										<th class="border-bottom-0">القسم</th>
										<th class="border-bottom-0">الخصم</th>
										<th class="border-bottom-0">نسبة الضريبة</th>
										<th class="border-bottom-0">قيمة الضريبة</th>
										<th class="border-bottom-0">الاجمالي</th>
										<th class="border-bottom-0">الحالة</th>
										<th class="border-bottom-0">ملاحظات</th>
										<th class="border-bottom-0">العمليات</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($invoices as $index => $invoice)
										<tr>
											<td>{{ $index+1 }}</td>
											<td>
												<a href="{{ route('invoicesDetails',$invoice->id) }}">{{ $invoice->invoice_number }}</a>
											</td>
											<td>{{ $invoice->invoice_date }}</td>
											<td>{{ $invoice->due_date }}</td>
											<td>{{ $invoice->product->name }}</td>
											<td>{{ $invoice->category->name }}</td>
											<td>{{ $invoice->discount }}</td>
											<td>{{ $invoice->rate_VAT }}</td>
											<td>{{ $invoice->value_VAT }}</td>
											<td>{{ $invoice->total }}</td>
											<td>{{ $invoice->status }}</td>
											<td>{{ $invoice->note }}</td>
											<td> 
												<div class="dropdown">
													<button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-sm btn-primary"
													data-toggle="dropdown" id="dropdownMenuButton" type="button">العمليات <i class="fas fa-caret-down ml-1"></i></button>
													<div  class="dropdown-menu tx-13">
														@can('تعديل الفاتورة')
															<a class="dropdown-item"  href="{{ route('invoices.edit',$invoice->id) }}" 
																title="تعديل">
																<i class="text-success las la-pen"></i> تعديل الفاتوره
															</a>
														@endcan

														@can('حذف الفاتورة')
															<a class="dropdown-item" href="{{ route('invoices.destroy',$invoice->id) }}" data-effect="effect-scale" data-target="#delete{{ $invoice->id }}"
																data-toggle="modal" title="حذف">
																<i class="text-danger las la-trash"></i> حذف الفاتوره 
															</a>
														@endcan

														@can("تغير حالة الدفع")
															<a class="dropdown-item"  href="{{ route('invoices.show',$invoice->id) }}" 
																title="تغير الحاله">
																<i class="text-success fas fa-dollar-sign"></i> تعديل حاله الدفع
															</a>
														@endcan

														@can("ارشفة الفاتورة")
															<a class="dropdown-item" href="{{ route('invoices.invoicesArchiving',$invoice->id) }}" data-toggle="modal" data-target="#archive_invoice{{$invoice->id}}">
																<i class="text-warning fas fa-exchange-alt"></i>
																&nbsp;&nbsp;نقل الي الارشيف
															</a>
														@endcan
														
														@can('طباعةالفاتورة')
															<a class="dropdown-item" href="{{ route('invoices.invoicePrint',$invoice->id) }}" >
																<i class="mdi mdi-printer ml-1"></i> طباعة
															</a>
														@endcan
													</div>
												</div>
												@can('حذف الفاتورة')
													<div class="modal" id="delete{{$invoice->id}}">
														<div class="modal-dialog modal-dialog-centered" role="document">
															<div class="modal-content modal-content-demo">
																<div class="modal-header">
																	<h6 class="modal-title">حذف الفاتوره</h6><button aria-label="Close" class="close" data-dismiss="modal"
																		type="button"><span aria-hidden="true">&times;</span></button>
																</div>
																<form action="{{ route('invoices.destroy',$invoice->id) }}" method="post">
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

												@can("ارشفة الفاتورة")
													<div class="modal" id="archive_invoice{{$invoice->id}}">
														<div class="modal-dialog modal-dialog-centered" role="document">
															<div class="modal-content modal-content-demo">
																<div class="modal-header">
																	<h6 class="modal-title">نقل الفاتوره الي الارشيف</h6><button aria-label="Close" class="close" data-dismiss="modal"
																		type="button"><span aria-hidden="true">&times;</span></button>
																</div>
																<form action="{{ route('invoices.invoicesArchiving',$invoice->id) }}" method="post">
																	@method('delete')
																	@csrf	
																	<div class="modal-body">
																		<p>هل انت متاكد من عملية الارشفه ؟</p><br>
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
																		<button type="submit" class="btn btn-success">تاكيد</button>
																	</div>
																</form>

															</div>
														</div>
													</div>
												@endcan
											</td>
										</tr>
									@endforeach
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