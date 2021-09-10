@extends('layouts.master')
@section('css')
@endsection
@section('title')
    تغير حالة الدفع
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
				<a class="content-title mb-0 my-auto" href="{{route('home')}}">الصفحه الرئيسيه</a>
				<a class="content-title mb-0 my-auto" href="{{route('invoices.index')}}">/ الفواتير</a>
				<span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تغير حالة الدفع</span>
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
                    <form action="{{ route('invoices.changeStatus',$invoice->id)}}" method="post" autocomplete="off">
                        @csrf
                        @method('PUT')
                        
                        {{-- 1 --}}
                        <div class="row">
                            <div class="col">
                                <label for="invoice_number" class="control-label">رقم الفاتورة</label>
                                <input type="text" class="form-control" id="invoice_number" name="invoice_number"
                                    title="رقم الفاتورة" value="{{ $invoice->invoice_number }}" readonly>
                                @error("invoice_number")
                                    <span class="text-danger">{{ $message }} </span>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="invoice_date" class="control-label">تاريخ الفاتورة</label>
                                <input class="form-control fc-datepicker" id="invoice_date" name="invoice_date" placeholder="YYYY-MM-DD"
                                    type="text" value="{{ $invoice->invoice_date}}"  readonly>
                                @error("invoice_date")
                                    <span class="text-danger">{{ $message }} </span>
                                @enderror    
                            </div>

                            <div class="col">
                                <label for="due_date" class="control-label">تاريخ الاستحقاق</label>
                                <input class="form-control fc-datepicker" id="due_date" name="due_date" placeholder="YYYY-MM-DD"
                                    type="text"  value="{{ $invoice->due_date}}" readonly>
                                @error("due_date")
                                    <span class="text-danger">{{ $message }} </span>
                                @enderror
                            </div>

                        </div>

                        {{-- 2 --}}
                        <div class="row">
                            <div class="col">
                                <label for="category_id" class="control-label">القسم</label>
                                <select name="category_id" id="category_id" class="form-control" readonly >
                                    <!--placeholder-->
                                    <option value="{{ $invoice->category_id }}"> {{ $invoice->category->name }}</option>
                                </select>
                                @error("category_id")
                                    <span class="text-danger">{{ $message }} </span>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="product_id" class="control-label">المنتج</label>
                                <select id="product_id" name="product_id" class="form-control" readonly>
                                    <option value="{{ $invoice->product_id }}"> {{ $invoice->product->name }}</option>
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
                                    readonly >
                            
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
                                    readonly
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
                                    readonly>
                                @error("discount")
                                    <span class="text-danger">{{ $message }} </span>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="Rate_VAT" class="control-label">%نسبة ضريبة القيمة المضافة</label>
                                <input type="number" name="Rate_VAT" value="{{ $invoice->rate_VAT }}" id="Rate_VAT" class="form-control"  readonly>
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
                        <div class="row">
                            <div class="col">
                                <label for="status">حالة الدفع</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option selected="true" disabled="disabled">-- حدد حالة الدفع --</option>
                                    <option value="1">مدفوعة</option>
                                    <option value="2">مدفوعة جزئيا</option>
                                    
                                </select>
                            </div>

                            <div class="col">
                                <label>تاريخ الدفع</label>
                                <input class="form-control fc-datepicker" name="Payment_Date" placeholder="YYYY-MM-DD"
                                    type="text" required value="{{ date('Y-m-d') }}">
                            </div>


                        </div><br>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">تحديث حالة الدفع</button>
                        </div>

                    </form>
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
@endsection