<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    function __construct(){
        
        $this->middleware('permission:المنتجات', ['only' => ['index']]);
        $this->middleware('permission:اضافة منتج', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل منتج', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف منتج', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::selection()->with('category')->paginate(PAGINATION_COUNT);
        return view('products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = category::selection()->get();
        return view('products.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        try{
            Product::insert($request->except('_token') );
            return redirect()->route('products.index')->with(['success' => "تم اضافه المنتج بنجاح"]);    
        }catch(\Exception $ex){ 
            return redirect()->route('products.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $product = Product::find($id);
            if(!$product)
                return redirect()->route('products.index')->with(['error'=>"هذا المنتج غير موجود او ربما تم حذفه"]);
            
            $categories = category::selection()->get();
            return view('products.edit',compact('product','categories'));     
        }catch(\Exception $ex){ 
            return redirect()->route('products.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update( $id, ProductRequest $request)
    {
        try{
            $product = Product::find($id);
            if(!$product)
                return redirect()->route('products.index')->with(['error'=>"هذا المنتج غير موجود او ربما تم حذفه"]);
            
            $product->update($request->except('_token','_method'));
            return redirect()->route('products.index')->with(['success' => "تم تحديث المنتج بنجاح"]);    
        }catch(\Exception $ex){ 
            return redirect()->route('products.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $product = Product::find($id);
            if(!$product)
                return redirect()->route('products.index')->with(['error'=>"هذا المنتج غير موجود او ربما تم حذفه"]);
            
            $product->delete();
            return redirect()->route('products.index')->with(['success' => "تم حذف المنتج بنجاح"]);    
        }catch(\Exception $ex){ 
            return redirect()->route('products.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }
}
