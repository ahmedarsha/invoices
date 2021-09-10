<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceReportRequest;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceReportController extends Controller
{
    public function index(){
        return view('reports.invoices');
    }
    
    public function resulte(InvoiceReportRequest $request){
        try {
            $radio = $request->radio;
            $type = $request->type; 
            $start_at = date($request->start_at); 
            $end_at = date($request->end_at); 
            // في حالة البحث بنوع الفاتورة
            if ($radio == 1 ) {

                // في حاله تحديد التاريخ من الي
                if($start_at != null && $end_at != null){

                    // في حاله اختيار عرض جميع الفواتير 
                    if ($type !== '0' && $type !== '1' && $type !== '2') {
                        
                        $invoices = Invoice::whereBetween('invoice_date',[$start_at,$end_at])->get(); 

                    }else{// في حاله عدم اختيار عرض جميع الفواتير
                        
                        $invoices = Invoice::whereBetween('invoice_date',[$start_at,$end_at])->where('status',$type)->get(); 

                    }
                    return view('reports.invoices',compact('radio','type','start_at','end_at'))->withDetails($invoices);


                }else{//في حاله عدم تحديد التاريخ
                    
                    // في حاله اختيار عرض جميع الفواتير 
                    if ($type != '0' && $type != '1' && $type != '2') {
                        $invoices = Invoice::all(); 

                    // في حاله عدم اختيار عرض جميع الفواتير
                    }else{ 
                        $invoices = Invoice::where('status',$type)->get(); 

                    }
                    return view('reports.invoices',compact('radio','type'))->withDetails($invoices);
                }

            // في حالة البحث برقم الفاتورة
            }elseif($radio == 2){

                $invoices = Invoice::selection()->where('invoice_number',$request->invoice_number)->get();
                return view('reports.invoices',compact('radio'))->withDetails($invoices);

            }
        } catch (\Exception $ex) {
            return $ex;
            return redirect()->route('invoices_reports')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }
}
