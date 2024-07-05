<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class Admin extends Model
{
    use HasFactory;

    public function importcsvbien($file,$file2,$file3){
        if (empty($file)||empty($file2||$file3)) {
            // Retourne une erreur ou arrête le processus
            return redirect()->back()->withErrors(['emptyfile' => 'there\'s no file']);
        }

        $newbien = $file;
        $newtypebien = $file2;
        $newlocation = $file3;


        $extensionbien = $newbien->getClientOriginalExtension();
        $extensiontypebien = $newtypebien->getClientOriginalExtension();
        $extensionlocation = $newlocation->getClientOriginalExtension();

        if($extensionbien != 'csv'){
            return redirect()->back()->withErrors(['error' => 'wrong format']);
        }

        if($extensiontypebien != 'csv'){
            return redirect()->back()->withErrors(['error' => 'wrong format']);
        }

        if($extensionbien != 'csv'){
            return redirect()->back()->withErrors(['error' => 'wrong format']);
        }

        if($extensionlocation != 'csv'){
            return redirect()->back()->withErrors(['error' => 'wrong format']);
        }


        $newBienContents = file($newbien->getPathname());
        $newTypeBienContents = file($newtypebien->getPathname());
        $newLocationContents = file($newlocation->getPathname());

        ///////////////////////////////

        $rowbien = 0;

        foreach($newBienContents as $newBienContent){
            $rowbien ++;

            if ($rowbien == 1) {
                continue;
            }

            $databien= str_getcsv($newBienContent, ",");
            

                //Régler le problème d'accent avec l'encodage
            array_walk($databien, function(&$value) {
                $value = mb_convert_encoding($value, 'UTF-8', 'auto');
                // Régler le problème de cédille (ç) avec l'encodage
                $value = str_replace(['ç', 'Ç'], ['ç', 'Ç'], $value);
            });
                $databienInsert[] =[
                    'reference' => $databien[0],
                    'nom' => $databien[1],
                    'Description' => $databien[2],
                    'Type' =>$databien[3],
                    'region' => $databien[4],
                    'loyer_mensuel' => $databien[5],
                    'Proprietaire' => $databien[6],
                   
                ];

        }

        

        echo '<pre>';
        print_r($databienInsert);
        echo '</pre>';


        foreach ($databienInsert as $key =>$value){
            $exist = DB::table('importcsvbien')
            ->where('reference',$value['reference'])
            ->where('nom',$value['nom'])
            ->where('Description',$value['Description'])
            ->where('Type',$value['Type'])
            ->where('region',$value['region'])
            ->where('loyer_mensuel',$value['loyer_mensuel'])
            ->where('Proprietaire',$value['Proprietaire'])
            ->first();
            if ($exist){
                unset($databienInsert[$key]);
            }
        }

        
        DB::table('importcsvbien')->insert($databienInsert);



/////////////////////////////////////////////////////
        $rowtypebien = 0;

        foreach($newTypeBienContents  as $newTypeBienContent){
            $rowtypebien ++;

            if ($rowtypebien == 1) {
                continue;
            }

            $datatypebien= str_getcsv($newTypeBienContent, ",");
            $dataresult = str_ireplace(',','.',$datatypebien[1]);
            $pourcentage = str_ireplace('%','',$dataresult);

            

           
                $datatypebienInsert[] =[
                    'Type' => $datatypebien[0],
                    'Commission' => $pourcentage,
                   
                ];

        }

        echo '<pre>';
        print_r($datatypebienInsert);
        echo '</pre>';


        foreach ($datatypebienInsert as $key =>$value){
            $exist = DB::table('importcsvtypebien')
            ->where('Type',$value['Type'])
            ->where('Commission',$value['Commission'])
            ->first();
            if ($exist){
                unset($datatypebienInsert[$key]);
            }
        }

        DB::table('importcsvtypebien')->insert($datatypebienInsert);


        /////////////////////////////////////////////////


        $rowlocation = 0;

        foreach($newLocationContents  as $newlocationContent){
            $rowlocation ++;

            if ($rowlocation == 1) {
                continue;
            }

            $datalocation= str_getcsv($newlocationContent, ",");
            $datelocation = Carbon::createFromFormat('d/m/Y', $datalocation[1])->format('Y-m-d');
      

            
                $datalocationInsert[] =[
                    'reference' => $datalocation[0],
                    'Date_debut' => $datelocation,
                    'duree_mois' => $datalocation[2],
                    'client' => $datalocation[3],
     
                ];

        }

        echo '<pre>';
        print_r($datalocationInsert);
        echo '</pre>';


        foreach ($datalocationInsert as $key =>$value){
            $exist = DB::table('importcsvlocation')
            ->where('reference',$value['reference'])
            ->where('Date_debut',$value['Date_debut'])
            ->where('duree_mois',$value['duree_mois'])
            ->where('client',$value['client'])
            ->first();
            if ($exist){
                unset($datalocationInsert[$key]);
            }
        }

        DB::table('importcsvlocation')->insert($datalocationInsert);

        // insertion typebien 
        DB::select('
       WITH new_typebien AS (
        INSERT INTO typebien (nomtypeb, commission)
        SELECT "Type", "Commission"
        FROM importcsvtypebien 
        WHERE "Type" NOT IN (SELECT nomtypeb FROM typebien) 
        AND "Commission" NOT IN (SELECT commission FROM typebien)
        RETURNING idtypeb, nomtypeb, commission
    )
    SELECT idtypeb, nomtypeb, commission FROM new_typebien
        ');

        //insert foreign key idtype in bien
        DB::select('
      WITH new_typebien2 AS(
            Select idtypeb,nomtypeb from typebien 
            where nomtypeb in (select "Type" from importcsvtypebien)
        ),
        new_bientypearg AS(
                    select imp.reference,imp.nom,
                    nt.idtypeb,imp."Description",imp.region,imp.loyer_mensuel
                    from importcsvbien imp
                    join new_typebien2 nt on imp."Type" = nt.nomtypeb
                )
        INSERT INTO public.bien(nombien, region, loyer, idtypeb, reference, description)
        select nom, region, loyer_mensuel, idtypeb, reference, "Description" from 
                new_bientypearg where
				nom not in (select nombien from bien)
	
	
        ');

    //     //insertion proprietaire
        DB::select('
        Insert into proprietaire(telephone)
        select distinct "Proprietaire" from importcsvbien where "Proprietaire" 
        not in (select telephone from proprietaire)
        ');

        //relation proprio-bien
        DB::select('
              with prop as(
            select idprop,telephone from proprietaire where telephone in
            (select "Proprietaire" from importcsvbien)
        ),
        bienha as(
            select b.idbien,p.idprop,b.nombien from 
            bien b join importcsvbien imp on imp.nom = b.nombien
            join proprietaire p on imp."Proprietaire" = p.telephone
        )
		 INSERT INTO public.proprietebien(idprop, idbien)
	 select idprop,idbien from bienha where idbien not in(select idbien
	from proprietebien)	
        ');

        //insert client
        DB::select(" Insert into client (email) select distinct client from importcsvlocation where client 
        not in (select email from client)");

        //insert location

        DB::select(' with clientha as (
        select idclient, email from client where email in 
        (select client from importcsvlocation)
    ),
    bienha as(
        select b.idbien,c.idclient,imp.reference,
        imp."Date_debut",
        imp.duree_mois
        from 
        bien b join importcsvlocation imp on imp.reference = b.reference
        join client c on imp.client = c.email
    )
    INSERT INTO locationclient(
        idbien,idclient,datedebut,duree)
    select idbien,idclient,"Date_debut",duree_mois from bienha where idbien not in (select idbien from locationclient)');

        
        $datas = DB::select('select * from locationclient where idbien in (select idbien from importcsvlocation)');
        
        foreach($datas as $data){
           DB::table('locationclient')
            ->where('idclient',$data->idclient)
            ->where('idbien',$data->idbien)
            ->where('duree',$data->duree)
            ->where('datedebut',$data->datedebut)
            ->exists();
           

                $this->generateincsv($data->idclient,$data->idbien,$data->duree,$data->datedebut);
            
        } 
    }

    public function selectWhereViewLocation($idbien)
    {

        $location = DB::table('viewtypebien')
        ->where('idbien', $idbien)
        ->get();

        $idbien = $location->pluck('idbien')->toArray();
        $commission = $location->pluck('commission')->toArray();
        $idprop = $location->pluck('idprop')->toArray();
        $loyer = $location->pluck('loyer')->toArray();
        $idbien = $location->pluck('reference')->toArray();


        return $location;
    }

    public function insertlocation($idclient,$idbien,$duree,$datedebut){
        if(empty($idclient) || empty($idbien) || empty($duree) || empty($datedebut)){
            return back()->with('error', 'Veuillez remplir les champs');
        }


     
     
            $insertion = DB::table('locationclient')->insert([
                'idbien' => $idbien,
                'idclient' => $idclient,
                'datedebut' => $datedebut,
                'duree' => $duree
            
            ]);

            $data =$this-> selectWhereViewLocation($idbien);
            $commission = $data->pluck('commission')->toArray();
            $idprop = $data->pluck('idprop')->toArray();
            $loyer = $data->pluck('loyer')->toArray();
            $reference = $data->pluck('reference')->toArray();
    
            $this->generate($datedebut,$duree,$reference[0],$loyer[0],$idprop[0],$commission[0],$idclient);
    
            return back()->with('success', 'Nouvelle location ajoutée');

        // return response()->json($data);
       
    }

    public function generateincsv($idclient,$idbien,$duree,$datedebut){

        $data =$this-> selectWhereViewLocation($idbien);
        $commission = $data->pluck('commission')->toArray();
        $idprop = $data->pluck('idprop')->toArray();
        $loyer = $data->pluck('loyer')->toArray();
        $reference = $data->pluck('reference')->toArray();

        
        $this->generate($datedebut,$duree,$reference[0],$loyer[0],$idprop[0],$commission[0],$idclient);
    
        return back()->with('success', 'Nouvelle location ajoutée');


    }

   

    public function generate($datedebut, $duree, $reference, $loyer, $idprop, $commission, $idclient)
    {
        $startDate = Carbon::createFromFormat('Y-m-d', date('Y-m-01', strtotime($datedebut)));
    
        for ($i = 0; $i < $duree; $i++) {
            $currentDate = $startDate->copy()->addMonths($i);
    
            if ($i == 0) {
                DB::insert(
                    'insert into paiement (mois, reference, loyer, commission, num_mois_location, valeur_commission,idprop,idclient)
                    values (?, ?, ?, ?, ?, ?, ?, ?)',
                    [$currentDate, $reference, $loyer * 2, 100, $i + 1, $loyer, $idprop, $idclient]
                );
            } else {
                DB::insert(
                    'insert into paiement (mois, reference, loyer, commission, num_mois_location, valeur_commission,idprop, idclient)
                    values (?, ?, ?, ?, ?, ?, ?, ?)',
                    [$currentDate, $reference, $loyer, $commission, $i + 1, ($loyer * ($commission / 100)), $idprop, $idclient]
                );
            }
        }
    }
    
    public function affallpaiement(){
        $paiements = DB::select('select * from paiement');
        $sommepaiementresult = DB::select('select sum(valeur_commission) as total from paiement');
        $sommepaiement = $sommepaiementresult[0]->total;
        
        return view('admin/indexadmin', ['paiements' => $paiements,'sommepaiement' => $sommepaiement]);
    }

    public function detailstypebien($idbien){
        $idbien = 48;
        $typebien = DB::table('viewtypebien')->where('idbien',$idbien)->get();
        return $typebien;
    }


    public function deletedata(){
        DB::table('photo')->delete();
        DB::table('locationclient')->delete();
        DB::table('paiement')->delete();

        
        DB::table('proprietebien')->delete();
        DB::table('locationclient')->delete();
        DB::table('proprietaire')->delete();
        DB::table('client')->delete();
        DB::table('bien')->delete();
        DB::table('typebien')->delete();
       
        DB::table('importcsvbien')->delete();
        DB::table('importcsvlocation')->delete();
        DB::table('importcsvtypebien')->delete();

    }
}

