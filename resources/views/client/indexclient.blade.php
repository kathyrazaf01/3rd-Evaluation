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
                                @php
                                $idclient = session('idclient');
                                $client = DB::table('client')->where('idclient', $idclient)->first();
                                @endphp
                          
                                <div class="d-flex justify-content-between">
                                    <h2 class="mb-0">{{ $client->nomclient }}</h2>
                                    <button type="submit" class="btn btn-primary">
                                        <a style="color: white" href="{{route('deconnexionclient')}}">Deconnexion</a>
                                    </button>
                                </div>
                            </div>
                          
                            
                            <h6 class="mb-4">Liste des Locations</h6>
                            <table class="table">
                                <thead>
                                   
                                    <tr>
                                        <th scope="col">Location</th>
                                        
                                        <th scope="col">Details</th>
                                       
                                    </tr>
                                  
                                </thead>
                                <tbody>
                                    @foreach ($locations as $location)
                                    <tr>
                                        <th scope="row">{{$location->nombien}}</th>
                                        <td>
                                            <button type="submit" class="btn btn-primary"><a style="color: white" href="{{route('detailslocation', ['idbien' => $location->idbien])}}">Voir Details</a></button>
                                        </td>
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