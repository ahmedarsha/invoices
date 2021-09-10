<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Models\category;
use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use App\Models\InvoiceDetails;
use App\Models\Product;
use App\Notifications\invoiceCreated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Exports\InvoicesExport;
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    function __construct(){
        
        $this->middleware('permission:قائمة الفواتير', ['only' => ['index']]);
        $this->middleware('permission:اضافة فاتورة', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل الفاتورة', ['only' => ['edit','update']]);
        $this->middleware('permission:تغير حالة الدفع', ['only' => ['show','changeStatus']]);
        $this->middleware('permission:ارشفة الفاتورة', ['only' => ['invoiceArchiving']]);
        $this->middleware('permission:طباعةالفاتورة', ['only' => ['printInvoice']]);
        $this->middleware('permission:الفواتير المدفوعة', ['only' => ['invoicesPaid']]);
        $this->middleware('permission:الفواتير الغير مدفوعة', ['only' => ['invoicesUnpaid']]);
        $this->middleware('permission:الفواتير المدفوعة جزئيا', ['only' => ['partialInvoices']]);
        $this->middleware('permission:ارشيف الفواتير', ['only' => ['invoicesArchived']]);
        $this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $invoices = Invoice::selection()->paginate(PAGINATION_COUNT);
        return view('invoices.index',compact('invoices'))
            ->with('i', ($request->input('page', 1) - 1) * PAGINATION_COUNT); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            $categories = category::selection()->get();
            return view('invoices.create',compact('categories'));  
        }catch(\Exception $ex){ 
            return redirect()->route('invoices.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceRequest $request)
    {

        try{
            DB::beginTransaction();

            $invoice_id = Invoice::insertGetId([
                'invoice_number' => $request->invoice_number,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'product_id' => $request->product_id,
                'category_id' => $request->category_id,
                'amount_collection' => $request->amount_collection,
                'amount_commission' => $request->amount_commission,
                'discount' => $request->discount,
                'value_VAT' => $request->Value_VAT,
                'rate_VAT' => $request->Rate_VAT,
                'total' => $request->total,
                'note' => $request->note
            ]);

            InvoiceDetails::create([
                'invoice_id' => $invoice_id,
                'invoice_number' => $request->invoice_number,
                'product_id' => $request->product_id,
                'category_id' => $request->category_id,
                'note' => $request->note,
                'user_id' => Auth::user()->id
            ]);

            // upload photo
            if($request->hasFile('pic')){
                $folder = "InvoicesAttachments";
                $img = $request->File('pic');
                $filePath = uploadImage($folder,$img);

                InvoiceAttachment::create([
                    'file_name' => $filePath,
                    'invoice_id' => $invoice_id,
                    'Created_by' => Auth::user()->id,
                ]);
            }

            DB::commit();

            $users = User::where('roles_name','<>','["user"]')->get();
            
            Notification::send($users, new invoiceCreated($invoice_id));

            return redirect()->route('invoices.index')->with(['success' => "تم اضافه الفاتوره بنجاح"]);    
        }catch(\Exception $ex){ 
            
            DB::rollBack();
            return redirect()->route('invoices.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $invoice = Invoice::find($id);
            if (!$invoice) {
                return redirect()->route('invoices.index')->with(['error'=>"هذه الفاتوره غير موجوده او ربما تم حذفها"]);
            }

            return view("invoices.change_status",compact('invoice'));

        } catch (\Exception $ex) {
            return redirect()->route('invoices.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $invoice = Invoice::find($id);
            if (!$invoice) {
                return redirect()->route('invoices.index')->with(['error'=>"هذه الفاتوره غير موجوده او ربما تم حذفها"]);
            }
            $categories = category::selection()->get();
            $products = Product::select('id','name')->where('category_id',$invoice->category_id)->get();
            return view('invoices.edit',compact('invoice','categories','products'));
        } catch (\Exception $ex) {
            return redirect()->route('invoices.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(InvoiceRequest $request, $id)
    {
        try {
            $invoice = Invoice::find($id);
            if (!$invoice) {
                return redirect()->route('invoices.index')->with(['error'=>"هذه الفاتوره غير موجوده او ربما تم حذفها"]);
            }
            $invoice->update([
                'invoice_number' => $request->invoice_number,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'product_id' => $request->product_id,
                'category_id' => $request->category_id,
                'amount_collection' => $request->amount_collection,
                'amount_commission' => $request->amount_commission,
                'discount' => $request->discount,
                'value_VAT' => $request->Value_VAT,
                'rate_VAT' => $request->Rate_VAT,
                'total' => $request->total,
                'note' => $request->note
            ]);
            return redirect()->route('invoices.index')->with(['success' => "تم تحديث الفاتوره بنجاح"]);    
        } catch (\Exception $ex) {
            return redirect()->route('invoices.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $invoice = Invoice::find($id);
            if (!$invoice) {
                return redirect()->route('invoices.index')->with(['error'=>"هذه الفاتوره غير موجوده او ربما تم حذفها"]);
            }
            $attachments = InvoiceAttachment::where('invoice_id',$invoice->id)->get();
            foreach ($attachments as $attachment) {
                $filePath = \public_path($attachment->file_name);
                unlink($filePath);
            }
            $invoice->forceDelete();
            return redirect()->route('invoices.index')->with(['success' => "تم حذفه الفاتوره بنجاح"]);    
        } catch (\Exception $ex) {
            return redirect()->route('invoices.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }

    // ارشفه الفاتوره
    public function invoiceArchiving($id)
    {
        try {
            $invoice = Invoice::find($id);
            if (!$invoice) {
                return redirect()->route('invoices.index')->with(['error'=>"هذه الفاتوره غير موجوده او ربما تم حذفها"]);
            }
            $invoice->delete();
            return redirect()->route('invoices.index')->with(['success' => "تم ارشفه الفاتوره بنجاح"]);    
        } catch (\Exception $ex) {
            return redirect()->route('invoices.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }

    // الغاء ارشفه الفاتوره
    public function invoiceUnArchiving($id)
    {
        try {
            $invoice = Invoice::withTrashed()->find($id);
            if (!$invoice) {
                return redirect()->route('invoices.invoicesArchived')->with(['error'=>"هذه الفاتوره غير موجوده او ربما تم حذفها"]);
            }
            $invoice->restore();
            return redirect()->route('invoices.invoicesArchived')->with(['success' => "تم الغاء الارشفه  بنجاح"]);    
        } catch (\Exception $ex) {
            return redirect()->route('invoices.invoicesArchived')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }

    public function getproducts($id){
        $products = DB::table('products')->where('category_id',$id)->pluck('name','id');
        return json_encode($products);
    }

    public function changeStatus(InvoiceRequest $request , $id){
        try {
            $invoice = Invoice::find($id);
            if (!$invoice) {
                return redirect()->route('invoices.index')->with(['error'=>"هذه الفاتوره غير موجوده او ربما تم حذفها"]);
            }
            DB::beginTransaction();

            $invoice->update([
                'status' => $request->status,
                'payment_date' => $request->Payment_Date
            ]);

            InvoiceDetails::create([
                'invoice_id' => $id,
                'invoice_number' => $request->invoice_number,
                'product_id' => $request->product_id,
                'category_id' => $request->category_id,
                'payment_date' => $request->Payment_Date,
                'status' => $request->status,
                'note' => $request->note,
                'user_id' => Auth::user()->id
            ]);
            DB::commit();

            return redirect()->route('invoices.index')->with(['success' => "تم تغير حاله الفاتوره بنجاح"]);    
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('invoices.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }
    
    // عرض الفواتير المدفوعه 
    public function invoicesPaid(){
        try {
            $invoices = Invoice::where('status','1')->get();
            return view('invoices.invoicesPaid',compact('invoices'));    
        } catch (\Exception $ex) {
            
            return redirect()->route('invoices.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }

    // عرض الفواتير الغغير مدفوعه 
    public function invoicesUnpaid(){
        try {
            $invoices = Invoice::where('status','0')->get();
            return view('invoices.invoicesUnpaid',compact('invoices'));    
        } catch (\Exception $ex) {
            
            return redirect()->route('invoices.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }

    // عرض الفواتير المدفوعه جزئيا 
    public function partialInvoices(){
        try {
            $invoices = Invoice::where('status','2')->get();
            return view('invoices.partialInvoices',compact('invoices'));    
        } catch (\Exception $ex) {
            
            return redirect()->route('invoices.index')->with(['error'=>"حدث خطا ما من فضلك اعد االمحاوله في وقت لاحق"]);
        }
    }
    
    // عرض الفواتير المؤرشفه
    public function invoicesArchived()
    {
        $invoices = Invoice::onlyTrashed()->selection()->paginate(PAGINATION_COUNT);
        return view('invoices.invoicesArchived',compact('invoices')); 
    }
    //  طباعه الفاتوره    
    public function printInvoice($id){
        try {
            $invoice = Invoice::find($id);
            return view('Invoices.print',compact('invoice'));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function export() 
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }

    public function markAsReadAll() 
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }
}

