@extends('layouts.master')
@section('title','اضافه منتج')



@section('page-header')
	<!-- breadcrumb -->
	<div class="breadcrumb-header justify-content-between">
		<div class="my-auto">
			<div class="d-flex">
				<a class="content-title mb-0 my-auto" href="{{route('home')}}">الصفحه الرئيسيه</a>
				<a class="content-title mb-0 my-auto" href="{{route('products.index')}}">/ المنتجات</a>
				<span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافه منتج جديد</span>
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

					<div class="card-content">
						<div class="card-body">
							<form action="{{ route('products.store') }}" method="post">
								@csrf

								<div class="form-body">
									<h4 class="form-section"><i class="ft-home"></i>اضافه منتج جديد  </h4>
							
									<div class="row">
										<div class="col-md-9">
											<div class="form-group">
												<label for="name">   اسم المنتج </label>
												<input type="text" value="{{ old('name') }}" id="name"
													class="form-control"
													name="name">
												@error("name")
													<span class="text-danger">{{ $message }} </span>
												@enderror       
											</div>
										</div>

										<div class="col-md-9">
											<div class="form-group">
												<label for="category_id">   القسم </label>
												<select name="category_id" id="category_id" class="form-control" required>
													<option value="" selected disabled> --اختر القسم--</option>
													@foreach ($categories as $category)
														<option value="{{ $category->id }}">{{ $category->name }}</option>
													@endforeach
												</select>
												@error("category_id")
													<span class="text-danger">{{ $message }} </span>
												@enderror       
											</div>
										</div>

										<div class="col-md-9">
											<div class="form-group">
												<label for="description">ملاحظات</label>
												<textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
												@error("description")
													<span class="text-danger">{{ $message }} </span>
												@enderror	
											</div>	
										</div>	
									</div>
								</div>

								<div class="form-actions">
									<button type="button" class="btn btn-warning mr-1"
											onclick="history.back();">
										<i class="ft-x"></i> تراجع
									</button>
									<button type="submit" class="btn btn-success">
										<i class="la la-check-square-o"></i> حفظ
									</button>
								</div>
							</form>
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