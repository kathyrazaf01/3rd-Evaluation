@extends('layouts.index')
@section('content')


@if(!Session::has('idadmin'))
        <script>
            window.location.href = "{{ route('loginadmin') }}";
        </script>
    @endif
            <!-- Table Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">                    
                <div class="col-12">
                        <div class="bg-secondary rounded h-100 p-4">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                <div class="alert alert-primary" role="alert">
                                    {{ $error }}
                                </div>
                                @endforeach
                                @endif
                                @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                                @endif
                            <div class="d-flex justify-content-between p-4">
                             
                                <button type="submit" class="btn btn-success m-2">
                                    <a style="color: white" href="{{route('importcsvbien')}}">Importation Bien</a>
                                </button>

                                <button type="submit" class="btn btn-success m-2">
                                    <a style="color: white" href="{{route('insertlocation')}}">Insertion de location</a>
                                </button>

                                
                                <button type="submit" class="btn btn-success m-2">
                                    <a style="color: white" href="{{route('delete')}}">Réinitialiser donnée</a>
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <a style="color: white" href="{{route('deconnexionadmin')}}">Deconnexion</a>
                                </button>
                            </div>
                            <h6 class="mb-4">choississez deux dates</h6>
                            <form id="dateForm" action="#" method="POST">
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Date 1</label>
                                    <div class="col-sm-10">
                                        <input type="date" name="date1" class="form-control" id="date1">
                                    </div>
                                </div>
                                <div class="row mb-3" style="margin-bottom: 50px; ">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Date 2</label>
                                    <div class="col-sm-10">
                                        <input type="date" name="date2" class="form-control" id="date2">
                                    </div>
                                </div> <div style="margin-bottom: 1.5rem;">
                
                                </div>
                            
                                <h6 class="mb-4">Liste des Biens</h6>
                              {{-- {{dd($paiements)}} --}}
                              {{$sommepaiement}}
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Mois</th>
                                            <th scope="col">Nom Mois</th>
                                            <th scope="col">Reference bien</th>
                                            <th scope="col">Loyer</th>
                                            <th scope="col">Commission</th>
                                            <th scope="col">Durée de location</th>
                                            <th scope="col">Valeur de commission</th>
                                            <th scope="col">Propriétaire</th>
                                            <th scope="col">Client</th>
                                        </tr>
                                      
                                    </thead>
                                    <tbody>
                                        @foreach($paiements as $paiement)
                                        <tr>
                                           
                                            <td>{{ $paiement->mois }}</td>
                                            <td>{{ $paiement->nom_mois}}</td>
                                            <td>{{ $paiement->reference}}</td>
                                            <td>{{ $paiement->loyer}}</td>
                                            <td>{{ $paiement->commission}}</td>
                                            <td>{{ $paiement->num_mois_location}}</td>
                                            <td>{{ $paiement->valeur_commission}}</td>
                                            <td>{{ $paiement->idprop}}</td>
                                            <td>{{ $paiement->idclient}}</td>
            
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                  <button type="submit" class="btn btn-primary">Filtre</button>
                            </div>
                        </div>
                    </div>
                </div>
                                
                            
                            </form>
                                {{-- <canvas id="commission"></canvas>
                             --}}
                                <script>


// document.getElementById('dateForm').addEventListener('submit', function(e) {
//     e.preventDefault();

//     var date1 = document.getElementById('date1').value;
//     var date2 = document.getElementById('date2').value;

//     fetch("{{route('showchart')}}" + "?date1=" + date1 + "&date2=" + date2)
//        .then(response => response.json())
//        .then(data => {
//         var ctx1 = document.getElementById("commission").getContext("2d");
//         var myChart1 = new Chart(ctx1, {
//                 type: "bar",
//                 data: {
//                     labels: data.months,
//                     datasets: [{
//                         label: "Chiffre d’Affaires",
//                         data: data.totalRevenue,
//                         backgroundColor: "rgba(235, 22, 22,.7)"
//                     }, {
//                         label: "Gains",
//                         data: data.totalCommission,
//                        backgroundColor: "rgba(235, 22, 22,.5)"
//                     }]
//                 },
//                 options: {
//                  responsive: true
//                 }
//             });
//         })
//        .catch(error => console.error('Error fetching data:', error));
// });

// Appeler la fonction pour initialiser le graphique dès le chargement de la page
// initializeChart();           
                                </script>
                                    
                               
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table End -->


            @endsection