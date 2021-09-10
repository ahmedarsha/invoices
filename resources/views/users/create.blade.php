@extends('layouts.master')

@section('css')
    <!-- Internal Nice-select css  -->
    <link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
@endsection

@section('title','اضافة مستخدم')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة
                    مستخدم</span>
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
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('users.index') }}">رجوع</a>
                    </div>
                </div><br>
                <form id="selectForm2" autocomplete="off" name="selectForm2"
                    action="{{route('users.store','test')}}" method="post">
                    @csrf

                    <div class="row mg-b-20">
                        <div class="col-md-6">
                            <label>اسم المستخدم: <span class="tx-danger">*</span></label>
                            <input class="form-control form-control-sm mg-b-20"
                                value="{{ old('name') }}"
                                name="name" 
                                type="text">
                            @error("name")
                                <span class="text-danger">{{ $message }} </span>
                            @enderror
                        </div>

                        <div class="col-md-6 mg-t-20 mg-md-t-0">
                            <label>البريد الالكتروني: <span class="tx-danger">*</span></label>
                            <input class="form-control form-control-sm mg-b-20"
                                    name="email"
                                    value="{{ old('email') }}"
                                    type="email">
                            @error("email")
                                <span class="text-danger">{{ $message }} </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mg-b-20">
                        <div class="col-md-6 mg-t-20 mg-md-t-0">
                            <label>كلمة المرور: <span class="tx-danger">*</span></label>
                            <input class="form-control form-control-sm mg-b-20"
                                name="password" type="password">
                            @error("password")
                                <span class="text-danger">{{ $message }} </span>
                            @enderror
                        </div>

                        <div class="col-md-6 mg-t-20 mg-md-t-0">
                            <label> تاكيد كلمة المرور: <span class="tx-danger">*</span></label>
                            <input class="form-control form-control-sm mg-b-20"
                                name="confirm-password" type="password">
                        </div>
                    </div>

                    <div class="row row-sm mg-b-20">
                        <div class="col-lg-6">
                            <label class="form-label">حالة المستخدم</label>
                            <select name="status" id="select-beast" class="form-control  nice-select  custom-select">
                                <option value="1">مفعل</option>
                                <option value="0">غير مفعل</option>
                            </select>
                            @error("status")
                                <span class="text-danger">{{ $message }} </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mg-b-20">
                        <div class="col-xs-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label"> صلاحية المستخدم</label>
                                {!! Form::select('roles_name[]', $roles,[], array('class' => 'form-control','multiple')) !!}
                            </div>
                        </div>
                        @error("roles_name")
                            <span class="text-danger">{{ $message }} </span>
                        @enderror
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button class="btn btn-main-primary pd-x-20" type="submit">تاكيد</button>
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


<!-- Internal Nice-select js-->
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>

<!--Internal  Parsley.min js -->
<script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
<!-- Internal Form-validation js -->
<script src="{{URL::asset('assets/js/form-validation.js')}}"></script>
@endsection