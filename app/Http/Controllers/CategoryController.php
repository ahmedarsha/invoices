<?php

namespace App\Http\Controllers;

use App\Http\Requests\categoryRequest;
use App\Models\category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    function __construct(){
        $this->middleware('permission:الاقسام', ['only' => ['index']]);
        $this->middleware('permission:اضافة قسم', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل قسم', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف قسم', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = category::selection()->paginate(PAGINATION_COUNT);
        return view('categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(categoryRequest $request)
    {
        try{
            category::insert([
                'name' => $request->name,
                'description' =>$request->description,
                'created_by' =>Auth::user()->name 
            ]);
            return redirect()->route('categories.index')->with(['success' => "تم اضافه القسم بنجاح"]);    
        }catch(\Exception $ex){ 
            return redirect()->route('categories.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $category = category::find($id);
            if(!$category)
                return redirect()->route('categories.index')->with(['error'=>"هذا القسم غير موجود او ربما تم حذفه"]);
            
            return view('categories.edit',compact('category'));
        }catch(\Exception $ex){ 
            return redirect()->route('categories.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update($id,categoryRequest $request)
    {
        try{
            $category = category::find($id);
            if(!$category)
                return redirect()->route('categories.index')->with(['error'=>"هذا القسم غير موجود او ربما تم حذفه"]);
            $category->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);
            return redirect()->route('categories.index')->with(['success' => "تم تحديث القسم بنجاح"]);    
        }catch(\Exception $ex){ 
            return redirect()->route('categories.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $category = category::find($id);
            if(!$category)
                return redirect()->route('categories.index')->with(['error'=>"هذا القسم غير موجود او ربما تم حذفه"]);
            
            $category->delete();
            return redirect()->route('categories.index')->with(['success' => "تم حذف القسم بنجاح"]);    
        }catch(\Exception $ex){ 
            return redirect()->route('categories.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }
}
