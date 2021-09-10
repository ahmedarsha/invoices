@extends('layouts.master')
@section('title', 'تفاصيل الفاتوره')

@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <a class="content-title mb-0 my-auto" href="{{ route('home') }}">الصفحه الرئيسيه</a>
                <a class="content-title mb-0 my-auto" href="{{ route('invoices.index') }}">/ الفواتير</a>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل الفاتوره</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- row opened -->
    <div class="col-xl-12">
        <!-- div -->
        <div class="card mg-b-20" id="tabs-style2">
            <div class="card-body">
                <div class="text-wrap">
                    <div class="example">
                        <div class="panel panel-primary tabs-style-2">
                            <div class=" tab-menu-heading">
                                <div class="tabs-menu1">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs main-nav-line">
                                        <li><a href="#invoicesDetails" class="nav-link active" data-toggle="tab">معلومات
                                                الفاتورة</a></li>
                                        <li><a href="#invoicesStatus" class="nav-link" data-toggle="tab">حالات الدفع</a>
                                        </li>
                                        <li><a href="#invoicesAttachment" class="nav-link" data-toggle="tab">المرفقات</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="invoicesDetails">
                                        <div class="table-responsive mt-15">

                                            <table class="table table-striped" style="text-align:center">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">رقم الفاتورة</th>
                                                        <th scope="row">تاريخ الاصدار</th>
                                                        <th scope="row">تاريخ الاستحقاق</th>
                                                        <th scope="row">القسم</th>
                                                        <th scope="row">المنتج</th>
                                                        <th scope="row">مبلغ التحصيل</th>
                                                        <th scope="row">مبلغ العمولة</th>
                                                        <th scope="row">الخصم</th>
                                                        <th scope="row">نسبة الضريبة</th>
                                                        <th scope="row">قيمة الضريبة</th>
                                                        <th scope="row">الاجمالي مع الضريبة</th>
                                                        <th scope="row">الحالة الحالية</th>
														<th scope="row">ملاحظات</th>
                                                    </tr>

                                                    <tr>
                                                        <td>{{$invoice->invoice_number}}</td>
                                                        <td>{{$invoice->invoice_date}}</td>
                                                        <td>{{$invoice->due_date}}</td>
                                                        <td>{{$invoice->category->name}}</td>
                                                        <td>{{$invoice->product->name}}</td>
                                                        <td>{{$invoice->amount_collection}}</td>
                                                        <td>{{$invoice->amount_commission}}</td>
                                                        <td>{{$invoice->discount}}</td>
                                                        <td>{{$invoice->rate_VAT}}</td>
                                                        <td>{{$invoice->value_VAT}}</td>
                                                        <td>{{$invoice->total}}</td>
                                                        <td>{{$invoice->status}}</td>
                                                        <td>{{$invoice->note}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>

                                    <div class="tab-pane" id="invoicesStatus">
                                        <div class="table-responsive mt-15">
                                            <table class="table center-aligned-table mb-0 table-hover"
                                                style="text-align:center">
                                                <thead>
                                                    <tr class="text-dark">
                                                        <th>#</th>
                                                        <th>رقم الفاتورة</th>
                                                        <th>نوع المنتج</th>
                                                        <th>القسم</th>
                                                        <th>حالة الدفع</th>
                                                        <th>تاريخ الدفع </th>
                                                        <th>ملاحظات</th>
                                                        <th>تاريخ الاضافة </th>
                                                        <th>المستخدم</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
													@foreach ($invoicesDetails as $index => $details)
														<tr>
															<td>{{ $index+1 }}</td>
															<td>{{ $details->invoice_number }}</td>
															<td>{{ $invoice->product->name }}</td>
															<td>{{ $invoice->category->name }}</td>
															<td>
                                                                @if ($details->status == 'مدفوعه')
                                                                    <span class='text-success'>{{ $details->status }}</span>
                                                                @elseif($details->status == 'غير مدفوعه')
                                                                    <span class='text-danger'>{{ $details->status }}</span>
                                                                @else
                                                                    <span class='text-warning'>{{ $details->status }}</span>
                                                                @endif
                                                                
                                                            </td>
															<td>{{ $details->payment_date }}</td>
															<td>{{ $details->note }}</td>
															<td>{{ $details->created_at }}</td>
															<td>{{ $details->user->name }}</td>
														</tr>
													@endforeach
													
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="invoicesAttachment">
                                        @can('اضافة مرفق')
                                            <form class="my-3" method="POST" action="{{ route('invoicesAttachment.store')}}" enctype="multipart/form-data">
                                                @csrf 

                                                <input type="hidden" name="invoice_number" value="{{$invoice->invoice_number}}">
                                                <input type="hidden" name="invoice_id" value="{{$invoice->id}}">

                                                <p class="text-danger">* صيغة المرفق pdf, jpeg , jpg , png </p>
                                                <h5 class="card-title">اضافه مرفق جديد</h5>
                                                <div class="col-sm-12 col-md-12">
                                                    <input type="file" name="file_name" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                        data-height="70"/>
                                                    @error("file_name")
                                                        <span class="text-danger">{{ $message }} </span>
                                                    @enderror
                                                </div><br>
                        
                                                <div class="d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-primary">اضافه</button>
                                                </div>                    
                                            </form>
                                        @endcan
                                        
                                        <div class="table-responsive mt-15">
                                            <table class="table center-aligned-table mb-0 table table-hover"
                                                style="text-align:center">
                                                <thead>

                                                    <tr class="text-dark">
                                                        <th scope="col">#</th>
                                                        <th scope="col">اسم الملف</th>
                                                        <th scope="col">قام بالاضافة</th>
                                                        <th scope="col">تاريخ الاضافة</th>
                                                        <th scope="col">العمليات</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($invoicesAttachment as $i => $attachment)
                                                        <tr>
                                                            <td>{{ $i+1 }}</td>
                                                            <td>{{ $attachment->file_name }}</td>
                                                            <td>{{ $attachment->Created_by }}</td>
                                                            <td>{{ $attachment->created_at }}</td>
                                                            <td colspan="2">

                                                                <a class="btn btn-outline-success btn-sm" href="{{ route('invoicesAttachment.show', $attachment->id) }}"
                                                                    role="button"><i class="fas fa-eye"></i>&nbsp;
                                                                    عرض</a>

                                                                <a class="btn btn-outline-info btn-sm" href="{{ route('invoicesAttachment.download', $attachment->id) }}"
                                                                    role="button"><i class="fas fa-download"></i>&nbsp;
                                                                    تحميل</a>
                                                                
                                                                @can('حذف المرفق')
                                                                    <!-- delete -->
                                                                    <a class="modal-effect btn btn-sm btn-danger"
                                                                        data-effect="effect-scale" data-toggle="modal"
                                                                        href="#delete" title="حذف">
                                                                        <i class="las la-trash"></i>
                                                                    </a>

                                                                    <div class="modal" id="delete">
                                                                        <div class="modal-dialog modal-dialog-centered"
                                                                            role="document">
                                                                            <div class="modal-content modal-content-demo">
                                                                                <div class="modal-header">
                                                                                    <h6 class="modal-title">حذف القسم</h6>
                                                                                    <button aria-label="Close" class="close"
                                                                                        data-dismiss="modal" type="button"><span
                                                                                            aria-hidden="true">&times;</span></button>
                                                                                </div>
                                                                                <form action="{{ route('invoicesAttachment.destroy', $attachment->id) }}" method="post">
                                                                                    @method('delete')
                                                                                    @csrf

                                                                                    <div class="modal-body">
                                                                                        <p>هل انت متاكد من عملية الحذف ؟</p><br>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button"
                                                                                            class="btn btn-secondary"
                                                                                            data-dismiss="modal">الغاء</button>
                                                                                        <button type="submit"
                                                                                            class="btn btn-danger">تاكيد</button>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /div -->
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection

@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>
@endsection
