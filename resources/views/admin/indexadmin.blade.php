@extends('layouts.index')
@section('content')


            <!-- Table Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">                    
                <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <div class="d-flex justify-content-between p-4">
                             
                                <button type="submit" class="btn btn-success m-2">
                                    <a style="color: white" href="{{route('importcsvbien')}}">Importation Bien</a>
                                </button>

                                
                                <button type="submit" class="btn btn-success m-2">
                                    <a style="color: white" href="{{route('importcsvlocation')}}">Importation Location</a>
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
                                </div>
                              <button type="submit" class="btn btn-primary">Filtre</button>
                            </form>
                                <canvas id="commission"></canvas>
                            
                                <script>


document.getElementById('dateForm').addEventListener('submit', function(e) {
    e.preventDefault();

    var date1 = document.getElementById('date1').value;
    var date2 = document.getElementById('date2').value;

    fetch("{{route('showchart')}}" + "?date1=" + date1 + "&date2=" + date2)
       .then(response => response.json())
       .then(data => {
        var ctx1 = document.getElementById("commission").getContext("2d");
        var myChart1 = new Chart(ctx1, {
                type: "bar",
                data: {
                    labels: data.months,
                    datasets: [{
                        label: "Chiffre d’Affaires",
                        data: data.totalRevenue,
                        backgroundColor: "rgba(235, 22, 22,.7)"
                    }, {
                        label: "Gains",
                        data: data.totalCommission,
                       backgroundColor: "rgba(235, 22, 22,.5)"
                    }]
                },
                options: {
                 responsive: true
                }
            });
        })
       .catch(error => console.error('Error fetching data:', error));
});

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