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
@endsection
@section('title')
    تعديل الفاتورة
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
				<a class="content-title mb-0 my-auto" href="{{route('home')}}">الصفحه الرئيسيه</a>
				<a class="content-title mb-0 my-auto" href="{{route('invoices.index')}}">/ الفواتير</a>
				<span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل الفاتورة</span>
			</div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('invoices.update',$invoice->id) }}" method="post" enctype="multipart/form-data"
                        autocomplete="off">    
                        @csrf
                        @method('PUT')
                        
                        {{-- 1 --}}
                        <div class="row">
                            <div class="col">
                                <label for="invoice_number" class="control-label">رقم الفاتورة</label>
                                <input type="text" class="form-control" id="invoice_number" name="invoice_number"
                                    title="يرجي ادخال رقم الفاتورة" value="{{ $invoice->invoice_number }}">
                                @error("invoice_number")
                                    <span class="text-danger">{{ $message }} </span>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="invoice_date" class="control-label">تاريخ الفاتورة</label>
                                <input class="form-control fc-datepicker" id="invoice_date" name="invoice_date" placeholder="YYYY-MM-DD"
                                    type="text" value="{{ $invoice->invoice_date}}" >
                                @error("invoice_date")
                                    <span class="text-danger">{{ $message }} </span>
                                @enderror    
                            </div>

                            <div class="col">
                                <label for="due_date" class="control-label">تاريخ الاستحقاق</label>
                                <input class="form-control fc-datepicker" id="due_date" name="due_date" placeholder="YYYY-MM-DD"
                                    type="text"  value="{{ $invoice->due_date}}">
                                @error("due_date")
                                    <span class="text-danger">{{ $message }} </span>
                                @enderror
                            </div>

                        </div>

                        {{-- 2 --}}
                        <div class="row">
                            <div class="col">
                                <label for="category_id" class="control-label">القسم</label>
                                <select name="category_id" id="category_id" class="form-control SlectBox" >
                                    <!--placeholder-->
                                    @foreach ($categories as $category)
                                        <option
                                            @if ($invoice->category_id == $category->id)
                                                selected
                                            @endif
                                            value="{{ $category->id }}"> {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error("category_id")
                                    <span class="text-danger">{{ $message }} </span>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="product_id" class="control-label">المنتج</label>
                                <select id="product_id" name="product_id" class="form-control">
                                    @foreach ($products as $product)
                                        <option
                                            @if ($invoice->product_id == $product->id)
                                                selected
                                            @endif
                                            value="{{ $product->id }}"> {{ $product->name }}</option>
                                    @endforeach
                                </select>
                                @error("product_id")
                                    <span class="text-danger">{{ $message }} </span>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="amount_collection" class="control-label">مبلغ التحصيل</label>
                                <input type="text" class="form-control" id="amount_collection" name="amount_collection"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    value="{{ $invoice->amount_collection }}"
                                    onchange="myFunction()">
                            
                                @error("amount_collection")
                                    <span class="text-danger">{{ $message }} </span>
                                @enderror
                            </div>

                        </div>


                        {{-- 3 --}}

                        <div class="row">

                            <div class="col">
                                <label for="amount_commission" class="control-label">مبلغ العمولة</label>
                                <input type="text" class="form-control form-control-lg" id="amount_commission"
                                    name="amount_commission" title="يرجي ادخال مبلغ العمولة "
                                    value="{{ $invoice->amount_commission }}"
                                    onchange="myFunction()"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                
                                @error("amount_commission")
                                    <span class="text-danger">{{ $message }} </span>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="discount" class="control-label">الخصم</label>
                                <input type="text" class="form-control form-control-lg" id="discount" name="discount"
                                    title="يرجي ادخال مبلغ الخصم "
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    value={{ $invoice->discount }} 
                                    onchange="myFunction()">
                                @error("discount")
                                    <span class="text-danger">{{ $message }} </span>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="Rate_VAT" class="control-label">%نسبة ضريبة القيمة المضافة</label>
                                <input type="number" name="Rate_VAT" value="{{ $invoice->rate_VAT }}" id="Rate_VAT" class="form-control" onchange="myFunction()">
                                @error("Rate_VAT")
                                    <span class="text-danger">{{ $message }} </span>
                                @enderror
                            </div>

                        </div>

                        {{-- 4 --}}

                        <div class="row">
                            <div class="col">
                                <label for="Value_VAT" class="control-label">قيمة ضريبة القيمة المضافة</label>
                                <input type="text" class="form-control" id="Value_VAT" name="Value_VAT" readonly  value="{{ $invoice->value_VAT }}">
                                @error("Value_VAT")
                                    <span class="text-danger">{{ $message }} </span>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="total" class="control-label">الاجمالي شامل الضريبة</label>
                                <input type="text" class="form-control" id="total" name="total" readonly  value="{{ $invoice->total }}">
                                @error("total")
                                    <span class="text-danger">{{ $message }} </span>
                                @enderror
                            </div>
                        </div>

                        {{-- 5 --}}
                        <div class="row">
                            <div class="col">
                                <label for="note">ملاحظات</label>
                                <textarea class="form-control" id="note" name="note" rows="3"> {{ $invoice->note }}</textarea>
                                @error("note")
                                    <span class="text-danger">{{ $message }} </span>
                                @enderror
                            </div>
                        </div><br>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">تعديل البيانات</button>
                        </div>


                    </form>
                </div>
            </div>
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
                } else {
                    console.log('AJAX load did not work');
                }
            });
        });
    </script>


    <script>
        function myFunction() {
            var Amount_Commission = parseFloat(document.getElementById("amount_commission").value);
            var Discount = parseFloat(document.getElementById("discount").value);
            var Rate_VAT = parseFloat(document.getElementById("Rate_VAT").value);
            var Value_VAT = parseFloat(document.getElementById("Value_VAT").value);
            var Amount_Commission2 = Amount_Commission - Discount;
            if (typeof Amount_Commission === 'undefined' || !Amount_Commission) {
                alert('يرجي ادخال مبلغ العمولة ');
            } else {
                var intResults = Amount_Commission2 * Rate_VAT / 100;
                var intResults2 = parseFloat(intResults + Amount_Commission2);
                sumq = parseFloat(intResults).toFixed(2);
                sumt = parseFloat(intResults2).toFixed(2);
                document.getElementById("Value_VAT").value = sumq;
                document.getElementById("total").value = sumt;
            }
        }
    </script>


@endsection