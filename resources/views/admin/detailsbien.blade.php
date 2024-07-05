@extends('layouts.index')
@section('content')


@if(!Session::has('idclient'))
        <script>
            window.location.href = "{{ route('loginclient') }}";
        </script>
    @endif

            <!-- Table Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">                    
                    <div class="col-12">
                        <div class="bg-secondary rounded h-100 p-4">
                            <div style="margin-bottom: 1.5rem;">
                
                            </div>
                          
                            
                            <h6 class="mb-4">Liste des Biens</h6>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Type Bien</th>
                                        <th scope="col">nom bien</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Loyer</th>
                                        <th scope="col">Region</th>
                                        <th scope="col">Commission</th>
                                       
                                    </tr>
                                  
                                </thead>
                                <tbody>
                                    @foreach ($detailsbiens as $detailsbien)
                                    <tr>
                                        <td>{{$detailsbien->nomtypeb}}</td>
                                        <td>{{$detailsbien->nombien}}</td>
                                        <td>{{$detailsbien->description}}</td>
                                        <td>{{$detailsbien->loyer}}</td>
                                        <td>{{$detailsbien->region}}</td>
                                        <td>{{$detailsbien->Commission}}</td>
                                       
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table End -->


            @endsection