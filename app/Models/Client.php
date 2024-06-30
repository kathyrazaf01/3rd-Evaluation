<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CLient extends Model
{
    use HasFactory;

    public function showlocationdetails($idbien)
    {   
        $locationdetails = DB::select('select distinct * from viewlocationclientpaiement where idbien =  ?', [$idbien]);

        return $locationdetails;
    }

    public function dureelocation($date1,$date2,$idbien)
    {      
        $dureeoriginal = DB::select('select duree from locationclient where idbien = ?', [$idbien]);
        $dureeoriginal = $dureeoriginal[0]->duree;
        $datefin = DB::select('select datefin from locationclient where idbien = ?', [$idbien]);

        if($date1 > $datefin[0]->datefin){

            $dureepredictif = DB::select(" WITH date_params AS (
            SELECT
                ?::date AS date1
            )
                SELECT
                    CASE 
                        WHEN dp.date1 > datefin THEN 
                            (date_part('year', age(dp.date1, datefin)) * 12 + date_part('month', age(dp.date1, datefin)) + 
                            CASE WHEN date_part('day', dp.date1) > date_part('day', datefin) THEN 1 ELSE 0 END)
                        WHEN date_part('year', datefin) = date_part('year', dp.date1) AND date_part('month', datefin) = date_part('month', dp.date1) THEN 1
                        ELSE (date_part('year', age(datefin, dp.date1)) * 12 + date_part('month', age(datefin, dp.date1)) + 
                            CASE WHEN date_part('day', datefin) > date_part('day', dp.date1) THEN 1 ELSE 0 END)
                    END AS months_between
                FROM
                    locationclient lc
                JOIN
                    date_params dp ON true where idbien = ? and date1 = ?"  ,[$date1,$idbien]);

            return $dureepredictif[0]->months_between;
            
        }

        return  $dureeoriginal;
    }

    public function showloyer($date1,$date2,$idbien,$duree){

        $duree = $this->dureelocation($date1,$date2,$idbien);

        $loyers = DB::select("
        WITH date_params AS (
                SELECT
                    ?::date AS date1,
                    ?::date AS date2
            ),
            loyer_per_month AS (
                SELECT
                    lc.idbien,
                    ? * b.loyer AS total
                FROM
                    locationclient lc
                JOIN
                    bien b ON lc.idbien = b.idbien
                WHERE
                    lc.idbien = ?
            ),
            payments_in_interval AS (
                SELECT
                    p.idlocation,
                    COALESCE(SUM(p.loyer_paye), 0) AS total_loyer_paye
                FROM
                    paiement p
                JOIN
                    locationclient lc ON p.idlocation = lc.idlocation
                JOIN
                    date_params dp ON p.datepaiement BETWEEN dp.date1 AND dp.date2
                GROUP BY
                    p.idlocation
            ),
              payments_without_interval AS (
                SELECT
                    p.idlocation,
                    COALESCE(SUM(p.loyer_paye), 0) AS total_loyer_paye
                FROM
                    paiement p
                JOIN
                    locationclient lc ON p.idlocation = lc.idlocation
                GROUP BY
                    p.idlocation
            )
            SELECT
                lc.idbien,
                dp.date1,
                dp.date2,
                lp.total,
                COALESCE(pi.total_loyer_paye, 0) AS paye,
                lp.total - COALESCE(pw.total_loyer_paye, 0) AS reste
            FROM
                locationclient lc
            JOIN
                loyer_per_month lp ON lc.idbien = lp.idbien
            JOIN
                date_params dp ON true
            LEFT JOIN
               payments_in_interval pi ON lc.idlocation = pi.idlocation
             LEFT JOIN
                 payments_without_interval pw ON lc.idlocation = pw.idlocation
            WHERE
                lc.idbien = ?
                AND lc.datedebut <= dp.date2", [$date1,$date2,$duree,$idbien,$idbien]);

        return $loyers;
       
    }

    
}
