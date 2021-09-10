@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('title','تقارير العملاء')
    
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">التقارير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تقارير
                    العملاء</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
            <!-- row -->
            <div class="row">
                <div class="col-lg-12 col-md-12">
    
                    @include('includes.alerts.success')
                    @include('includes.alerts.errors')

                    <div class="card">
                        <div class="card-header">
                            <form action="{{ route('resulte_customer_reports') }}" method="post" autocomplete="off">    
                                @csrf
                                    
                                <div class="row">
                                    <div class="col">
                                        <label for="category_id" class="control-label">القسم</label>
                                        <select name="category_id" id="category_id" class="form-control select2" >
                                            <!--placeholder-->
                                            <option value="{{ $category_id ?? '' }}" selected >حدد القسم</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"> {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error("category_id")
                                            <span class="text-danger">{{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="col">
                                        <label for="product_id" class="control-label">المنتج</label>
                                        <select id="product_id" name="product_id" class="form-control select2">
                                        </select>
                                        @error("product_id")
                                            <span class="text-danger">{{ $message }} </span>
                                        @enderror
                                    </div>

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

                                </div>

                                <div class="d-flex justify-content-center mt-5">
                                    <button type="submit" class="btn btn-primary">بحث</button>
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
            </div><!-- row closed -->
        </div><!-- Container closed -->
    </div><!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>

    <script>
        $(document).ready(function() {
            $('select[name="category_id"]').on('change', function() {
                var category_id = $(this).val();
                if (category_id) {
                    $.ajax({
                        url: "{{ URL::to('category') }}/" + category_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#product_id').empty();
                            $.each(data, function(key, value) {
                                $('#product_id').append('<option value="' +
                                    key + '">' + value + '</option>');
                            });
                        },
                    });
                }
            });
        });
    </script>

@endsection