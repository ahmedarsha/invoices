<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

    //=================احصائية نسبة تنفيذ الحالات======================



      $count_all =Invoice::count();

      // الفواتير المدفوعه
      $count_invoices_paid = Invoice::where('status', 1)->count();
      $ratio_invoices_paid = $count_invoices_paid / $count_all * 100;

      // الفواتير المدفوعه جزئيا
      $count_invoices_partialPaid = Invoice::where('status', 2)->count();
      $ratio_invoices_partialPaid = $count_invoices_partialPaid / $count_all * 100;
      
      // الفواتير الغير مدفوعه
      $count_invoices_unpaid = Invoice::where('status', 0)->count();
      $ratio_invoices_unpaid = $count_invoices_unpaid / $count_all * 100;



        $barjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['الفواتير الغير مدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#ec5858'],
                    'data' => [$ratio_invoices_unpaid]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#13a676'],
                    'data' => [$ratio_invoices_paid]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#ff9642'],
                    'data' => [$ratio_invoices_partialPaid]
                ],


            ])
            ->options([]);


        $piejs = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#13a676','#ff9642'],
                    'data' => [$ratio_invoices_unpaid, $ratio_invoices_paid,$ratio_invoices_partialPaid]
                ]
            ])
            ->options([]);

        return view('index',compact('barjs','piejs'));
    }
}
