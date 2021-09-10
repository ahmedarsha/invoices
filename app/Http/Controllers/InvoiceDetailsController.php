<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use App\Models\InvoiceDetails;
use Illuminate\Http\Request;

class InvoiceDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoiceDetails  $invoiceDetails
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $invoice = Invoice::where('id',$id)->first();
            if (! $invoice) 
                return redirect()->route('invoices.index')->with(['error'=>"هذه الفاتوره غير موجوه او ربما تم حذفها"]);
            $invoicesDetails = InvoiceDetails::where('invoice_id',$id)->get();
            $invoicesAttachment = InvoiceAttachment::where('invoice_id',$id)->get();
            if(isset($_GET['notfyid'])){
                auth()->user()
                    ->unreadNotifications
                    ->where('id',$_GET['notfyid'])
                    ->markAsRead();
            }
            
            return view('invoices.details',compact('invoice','invoicesDetails','invoicesAttachment'));    
        } catch (\Exception $ex) {
            return $ex;
            return redirect()->route('invoices.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoiceDetails  $invoiceDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceDetails $invoiceDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoiceDetails  $invoiceDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoiceDetails $invoiceDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoiceDetails  $invoiceDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceDetails $invoiceDetails)
    {
        //
    }
}
