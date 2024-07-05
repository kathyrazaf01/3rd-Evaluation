<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AdminController extends Controller
{

    private $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }
    public function showchart(Request $request){

        $date1 = $request->input('date1');
        $date2 = $request->input('date2');
    

        $results = DB::select(" WITH date_params AS (
    SELECT
        '".$date1."'::date AS date1,
        '".$date2."'::date AS date2
),
payment_schedules AS (  
 SELECT
        lc.idbien,
        b.loyer,
        t.commission,
        generate_series(
            lc.datedebut,
            lc.datedebut + ((lc.duree-1) * interval '1 month'),
            interval '1 month'
        ) AS payment_date
    FROM
        locationclient lc
    JOIN
        bien b ON lc.idbien = b.idbien
	
	JOIN typebien t on b.idtypeb = t.idtypeb
	),
	filtered_payments AS (
    SELECT
        ps.idbien,
        ps.loyer,
        ps.commission,
        ps.payment_date
    FROM
        payment_schedules ps
    JOIN
        date_params dp ON ps.payment_date BETWEEN dp.date1 AND dp.date2
),
revenue_by_month AS (
    SELECT
        EXTRACT(YEAR FROM payment_date) AS year,
        EXTRACT(MONTH FROM payment_date) AS month,
	 TO_CHAR(payment_date, 'Month') AS month_name,
        SUM(loyer) AS total_revenue,
        SUM(loyer * commission / 100) AS total_gain
	
    FROM
        filtered_payments
	
    GROUP BY
        EXTRACT(YEAR FROM payment_date),
	 EXTRACT(MONTH FROM payment_date),
        TO_CHAR(payment_date, 'Month')

)
select * from revenue_by_month order by  month");

$formattedResults = array_map(function($result) {
    return json_decode(json_encode($result), false);
}, $results);


      $months = [];
      $totalRevenue = [];
      $totalCommission = [];

      foreach ($results as $result) {
        $months[] = $result->month_name;
        $totalRevenue[] = $result->total_revenue;
        $totalCommission[] = $result->total_gain;
    }

    return response()->json(['months' => $months, 'totalRevenue' => $totalRevenue, 'totalCommission' => $totalCommission]);

        
    }

    public function importcsvbien(Request $request){
        $file =  $request->file('bien');
        $file2 =  $request->file('typebien');
        $file3 =  $request->file('location');
        $this->admin->importcsvbien($file,$file2,$file3);
        
        // return $csv;

        return back()->with('success', 'Nouveaux biens ajoutés');
    }

    public function insertnewlocation(Request $request){
        $idbien = $request->input('idbien');
        $idclient = $request->input('idclient');
        $duree = $request->input('duree');
        $datedebut = $request->input('datedebut');

        $insertionlocation = $this->admin->insertlocation($idclient,$idbien,$duree,$datedebut);

        return $insertionlocation;
    }

    public function listebien(){
    
            $idbien = 48;
            $detailsbiens = DB::table('viewtypebien')->where('idbien',$idbien)->get();

            $detailsbiensArray = $detailsbiens->toArray();
            $idbiens = $detailsbiens->pluck('idbien')->toArray();
            $idtypebiens = $detailsbiens->pluck('idtypeb')->toArray();
            
            return view('admin/listebien', [
                'detailsbiensArray' => $detailsbiensArray,
                'idbiens' => $idbiens,
                'idtypebiens' => $idtypebiens
            ]);


    }

    public function delete(){
        $this->admin->deletedata();
        return back()->with('success', 'données réinitialisées avec succes');
    }

    public function showpaiement(){

        $paiements = $this->admin->affallpaiement();
        return $paiements;
    }



    // public function detailstypebien($idbien){
    //     $detailsbiens = $this->admin->detailstypebien($idbien);
    //     return view('admin/detailsbien', ['detailsbiens' => $detailsbiens]);
    // }
}
