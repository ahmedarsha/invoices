@extends('layouts.master')
@section('title','الفواتير المؤرشفه')

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
				<a class="content-title mb-0 my-auto" href="{{route('home')}}">الصفحه الرئيسيه</a><span class="text-muted mt-1 tx-13 mr-2 mb-0">/  الفواتير المؤرشفه</span>
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
					<div class="card-body">
						<div class="table-responsive">
							<table class="table text-md-nowrap" id="example2">
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
												@can('حذف الفاتورة')
													
												@endcan
												<a class="btn btn-danger btn-sm" href="{{ route('invoices.invoiceUnArchiving',$invoice->id) }}" data-toggle="modal" data-target="#unarchive_invoice">
													الغاء الارشفه
												</a>
												
												<div class="modal" id="unarchive_invoice">
													<div class="modal-dialog modal-dialog-centered" role="document">
														<div class="modal-content modal-content-demo">
															<div class="modal-header">
																<h6 class="modal-title">نقل الفاتوره من الارشيف</h6><button aria-label="Close" class="close" data-dismiss="modal"
																	type="button"><span aria-hidden="true">&times;</span></button>
															</div>
															<form action="{{ route('invoices.invoiceUnArchiving',$invoice->id) }}" method="post">
																@method('delete')
																@csrf	
																<div class="modal-body">
																	<p>هل انت متاكد من عملية الغاء الارشفه ؟</p><br>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
																	<button type="submit" class="btn btn-success">تاكيد</button>
																</div>
															</form>

														</div>
													</div>
												</div>
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