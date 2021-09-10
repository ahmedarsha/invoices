@extends('layouts.master')
@section('css')
    <!-- Internal Nice-select css  -->
    <link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
@endsection

@section('title')
    تعديل مستخدم    
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل
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
                        <a class="btn btn-primary btn-sm" href="{{ route('users.index') }}">رجوع</a>
                    </div>
                </div><br>

                {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}

                <div class="row mg-b-20">
                    <div class="col-md-6">
                        <label>اسم المستخدم: <span class="tx-danger">*</span></label>
                        {!! Form::text('name', null, array('class' => 'form-control','required')) !!}
                        @error("name")
                            <span class="text-danger">{{ $message }} </span>
                        @enderror
                    </div>

                    <div class="col-md-6 mg-t-20 mg-md-t-0">
                        <label>البريد الالكتروني: <span class="tx-danger">*</span></label>
                        {!! Form::text('email', null, array('class' => 'form-control','required')) !!}
                        @error("email")
                            <span class="text-danger">{{ $message }} </span>
                        @enderror
                    </div>
                </div>

                <div class="row mg-b-20">
                    <div class="col-md-6 mg-t-20 mg-md-t-0">
                        <label>كلمة المرور: </label>
                        {!! Form::password('password', array('class' => 'form-control')) !!}
                        @error("password")
                            <span class="text-danger">{{ $message }} </span>
                        @enderror
                    </div>

                    <div class="col-md-6 mg-t-20 mg-md-t-0">
                        <label> تاكيد كلمة المرور: </label>
                        {!! Form::password('confirm-password', array('class' => 'form-control')) !!}
                    </div>
                </div>

                <div class="row row-sm mg-b-20">

                    <div class="col-lg-6">
                        <label class="form-label">حالة المستخدم</label>
                        <select name="status" id="select-beast" class="form-control  custom-select">
                            <option 
                                @if ($user->status == "مفعل")
                                    value='1'
                                @elseif ($user->status == "غير مفعل")
                                    value = '0'
                                @endif
                            >
                                
                                {{ $user->status}}
                            </option>
                            <option value="1">مفعل</option>
                            <option value="0">غير مفعل</option>
                        </select>
                        @error("status")
                            <span class="text-danger">{{ $message }} </span>
                        @enderror
                    </div>
                </div>

                <div class="row mg-b-20">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>نوع المستخدم</strong>
                            {!! Form::select('roles_name[]', $roles,$userRole, array('class' => 'form-control','multiple'))!!}
                        </div>
                    </div>
                </div>
                <div class="mg-t-30">
                    <button class="btn btn-main-primary pd-x-20" type="submit">تحديث</button>
                </div>
                {!! Form::close() !!}
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

    <!-- Internal Nice-select js-->
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>

    <!-- Internal Form-validation js -->
    <script src="{{URL::asset('assets/js/form-validation.js')}}"></script>
@endsection