@extends('layouts.master')
@section('title','تحديث القسم')



@section('page-header')
	<!-- breadcrumb -->
	<div class="breadcrumb-header justify-content-between">
		<div class="my-auto">
			<div class="d-flex">
				<a class="content-title mb-0 my-auto" href="{{route('home')}}">الصفحه الرئيسيه</a>
				<a class="content-title mb-0 my-auto" href="{{route('categories.index')}}">/ الاقسام</a>
				<span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تحديث القسم </span>
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
							<form action="{{ route('categories.update',$category->id) }}" method="post">
								@csrf
								@method('PUT')
								
								<div class="form-body">
									<h4 class="form-section"><i class="ft-home"></i>تحديث القسم  </h4>
							
									<div class="row">
										<div class="col-md-9">
											<div class="form-group">
												<label for="name">   اسم القسم </label>
												<input type="text" value="{{ $category->name }}" id="name"
													class="form-control"
													name="name">
												@error("name")
													<span class="text-danger">{{ $message }} </span>
												@enderror       
											</div>
										</div>
										<div class="col-md-9">
											<div class="form-group">
												<label for="description">ملاحظات</label>
												<textarea class="form-control" id="description" name="description" rows="4">{{ $category->description }}</textarea>
												@error("description")
													<span class="text-danger">{{ $message }} </span>
												@enderror	
											</div>	
										</div>	
									</div>
								</div>

								<div class="form-actions">
									<button type="button" class="btn btn-warning ml-3"
											onclick="history.back();">
										<i class="ft-x"></i> تراجع
									</button>
									<button type="submit" class="btn btn-success">
										<i class="la la-check-square-o"></i> تحديث
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