<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class InvoiceAttachmentController extends Controller
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
        $this->validate($request,
        [
            'file_name' => 'required|mimes:png,jpg,pdf,jpeg|max:1024',
        ],[
            'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
            'file_name.required' => 'يجب ادراج مرفق اولا',
        ]);
        
        try {
            $invoice = Invoice::find($request->invoice_id);
            if (!$invoice) {
                return redirect()->route('invoices.index')->with(['error'=>"هذه الفاتوره غير موجود او ربما تم حذفها"]);
            }
            $folder = "InvoicesAttachments";
            $file_name = $request->File('file_name');
            $filePath = uploadImage($folder,$file_name);
            InvoiceAttachment::create([
                'file_name' => $filePath,
                'Created_by' => Auth::user()->id,
                'invoice_id' => $request->invoice_id
            ]);
            return redirect()->route('invoices.index')->with(['success' => "تم اضافه المرفق بنجاح"]);    

        } catch (\Exception $ex) {
            return redirect()->route('invoices.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $attachment = InvoiceAttachment::find($id);
            if (! $attachment) {
                return redirect()->route('invoices.index')->with(['error'=>"هذا المرفق غير موجود او ربما تم حذفه"]);
            }
            $file = $attachment->file_name;
            return response()->file($file);
        } catch (\Exception $ex) {
            return redirect()->route('invoices.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $attachment = InvoiceAttachment::find($id);
            if (!$attachment) {
                return redirect()->route('invoices.index')->with(['error'=>"هذا المرفق غير موجوده او ربما تم حذفها"]);
            }
            $filePath =  \public_path($attachment->file_name);
            unlink($filePath);
            $attachment->delete();
            return redirect()->route('invoices.index')->with(['success' => "تم حذف المرفق بنجاح"]);    
        } catch (\Exception $ex) {
            return redirect()->route('invoices.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }

    public function getDownload($id)
    {
        try {
            $attachment = InvoiceAttachment::find($id);
            if (! $attachment) {
                return redirect()->route('invoices.index')->with(['error'=>"هذا المرفق غير موجود او ربما تم حذفه"]);
            }
            $file = $attachment->file_name;
            return response()->download($file);
        } catch (\Exception $ex) {
            return redirect()->route('invoices.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }

    }
}
