<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerReportRequest;
use App\Models\category;
use App\Models\Invoice;
use Illuminate\Http\Request;

class CustomerReportController extends Controller
{
    public function index(){
        try{
            $categories = category::selection()->get();
            return view('reports.customer',compact('categories'));  
        }catch(\Exception $ex){ 
            return redirect()->route('home')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }
    
    public function resulte(CustomerReportRequest $request){
        
        try {
            $start_at = $request->start_at;
            $end_at = $request->end_at;
            $categories = category::selection()->get();

            // ..في حاله تحديد التاريخ من ..الي
            if($start_at != null && $end_at != null){
                $invoices = Invoice::selection()
                    ->whereBetween('invoice_date',[$start_at,$end_at])
                    ->where('category_id',$request->category_id)
                    ->where('product_id',$request->product_id)
                    ->get(); 
                
                return view('reports.customer',compact('start_at','end_at','categories'))->withDetails($invoices);

            }else{//في حاله عدم تحديد التاريخ
                $invoices = Invoice::selection()
                    ->where('category_id',$request->category_id)
                    ->where('product_id',$request->product_id)
                    ->get(); 
            
                return view('reports.customer',compact('categories'))->withDetails($invoices);

            }
        } catch (\Exception $ex) {
            return redirect()->route('customer_reports')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }
}
