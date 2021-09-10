@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">

    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('title','تقارير الفواتير')
    
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">التقارير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تقارير
                الفواتير</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')

<!-- row -->
<div class="row">

    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">

                <form action="{{ route('resulte_invoices_reports') }}" method="POST" autocomplete="off">
                    @csrf

                    <div class="col-lg-3">
                        <label class="rdiobox">
                            <input 
                                @isset($radio)
                                    @if ($radio == '1')
                                        class="show"
                                    @endif
                                @endisset 
                                name="radio" type="radio" value="1" id="type_div">
                            <span>بحث بنوع الفاتورة</span>
                        </label>
                    </div>

                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                        <label class="rdiobox">
                            <input 
                                @isset($radio)
                                    @if ($radio == '2')
                                        class="show"
                                    @endif
                                @endisset 
                                checked
                                name="radio" value="2" type="radio">
                            <span>بحث برقم الفاتورة</span>
                        </label>
                    </div><br><br>
                    @error("radio")
                        <span class="text-danger">{{ $message }} </span>
                    @enderror

					@include('includes.alerts.success')
					@include('includes.alerts.errors')

                    <div class="col-lg-3 mg-t-20 mg-lg-t-0" id="invoice_number">
                        <p class="mg-b-10">البحث برقم الفاتورة</p>
                        <input type="text" class="form-control" 
                            name="invoice_number"
                            value="{{ old('invoice_number') }}">
                        @error("invoice_number")
                            <span class="text-danger">{{ $message }} </span>
                        @enderror
                    </div><!-- col-4 -->       

                    <div class="row" id="invoice_type">
                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                            <p class="mg-b-10">تحديد نوع الفواتير</p>
                            <div >        
                                <select class="select2 form-control" name="type">
                                    <option value="{{ $type ?? '' }}" selected>
                                        @php
                                            if(isset($type)){
                                                if ($type == 0) {
                                                    $type = 'الفواتير الغير مدفوعة';
                                                } elseif ($type == 1) {
                                                    $type = 'الفواتير المدفوعة';

                                                } elseif ($type == 2) {
                                                    $type = 'الفواتير المدفوعة جزئيا';

                                                }elseif  ($type == '*'){
                                                    $type = 'جميع الفواتير';
                                                }
                                            }
                                        @endphp
                                        {{  $type ?? old('type') }}
                                        
                                    </option>
                                    <option value="*" >جميع الفواتير</option>
                                    <option value="1">الفواتير المدفوعة</option>
                                    <option value="0">الفواتير الغير مدفوعة</option>
                                    <option value="2">الفواتير المدفوعة جزئيا</option>
                                </select>
                            </div>
                            @error("type")
                                <span class="text-danger">{{ $message }} </span>
                            @enderror
                        </div><!-- col-4 -->

                        <div class="col-lg-3">
                            <label for="exampleFormControlSelect1">من تاريخ</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </div>
                                <input class="form-control fc-datepicker" 
                                    value="{{ $start_at ?? old('start_at') }}"
                                    name="start_at" 
                                    placeholder="YYYY-MM-DD"
                                    type="text">
                            </div><!-- input-group -->
                            @error("start_at")
                                <span class="text-danger">{{ $message }} </span>
                            @enderror
                        </div>

                        <div class="col-lg-3">
                            <label for="exampleFormControlSelect1">الي تاريخ</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </div>
                                <input class="form-control fc-datepicker" 
                                    name="end_at"
                                    value="{{ $end_at ?? old('end_at') }}" 
                                    placeholder="YYYY-MM-DD"
                                    type="text">  
                            </div><!-- input-group -->
                            @error("end_at")
                                <span class="text-danger">{{ $message }} </span>
                            @enderror  
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-lg-2 col-sm-3 col-6  my-4">
                            <button class="btn btn-primary btn-block" type="submit">بحث</button>
                        </div>
                    </div>

                </form>

            </div>
            @if (isset($details))
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table key-buttons text-md-nowrap" style=" text-align: center">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">رقم الفاتورة</th>
                                    <th class="border-bottom-0">تاريخ الفاتورة</th>
                                    <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                    <th class="border-bottom-0">المنتج</th>
                                    <th class="border-bottom-0">القسم</th>
                                    <th class="border-bottom-0">الخصم</th>
                                    <th class="border-bottom-0">نسبة الضريبة</th>
                                    <th class="border-bottom-0">قيمة الضريبة</th>
                                    <th class="border-bottom-0">الاجمالي</th>
                                    <th class="border-bottom-0">الحالة</th>
                                    <th class="border-bottom-0">ملاحظات</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($details as $invoice)
                                    <?php $i++; ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>
                                            <a href="{{ route('invoicesDetails',$invoice->id) }}">
                                                {{ $invoice->invoice_number }}
                                            </a>
                                        </td>
                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td>{{ $invoice->product->name }}</td>
                                        <td>{{ $invoice->category->name }}</td>
                                        <td>{{ $invoice->discount }}</td>
                                        <td>{{ $invoice->rate_VAT }}%</td>
                                        <td>{{ $invoice->value_VAT }}</td>
                                        <td>{{ $invoice->total }}</td>
                                        <td>
                                            @if ($invoice->status == 'مدفوعه')
                                                <span class="text-success">{{ $invoice->status }}</span>
                                            @elseif($invoice->status == 'غير مدفوعه')
                                                <span class="text-danger">{{ $invoice->status }}</span>
                                            @else
                                                <span class="text-warning">{{ $invoice->status }}</span>
                                            @endif

                                        </td>

                                        <td>{{ $invoice->note }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- row closed -->
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
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>

    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
    <!-- Ionicons js -->
    <script src="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    
    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>

    <script>
        $(document).ready(function() {
            $('#invoice_number').hide();

            
            if ($('.show').val() == 1) {
                $('.show').attr('checked','checked');
                $('#invoice_number').hide();
                $('#invoice_type').show();
            }else {
                $('.show').attr('checked','checked');
                $('#invoice_number').show();
                $('#invoice_type').hide();
                
            }

            $('input[type="radio"]').click(function() {
                if ($(this).attr('id') == 'type_div') {
                    $('#invoice_number').hide();
                    $('#invoice_type').show();
                } else {
                    $('#invoice_number').show();
                    $('#invoice_type').hide();
                    
                }
            });
        });
    </script>

@endsection