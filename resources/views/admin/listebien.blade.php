@extends('layouts.index')
@section('content')


{{-- @if(!Session::has('idclient'))
        <script>
            window.location.href = "{{ route('loginclient') }}";
        </script>
    @endif --}}

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
                                        
                                       
                                    </tr>
                                  
                                </thead>
                                <tbody>
                                    @foreach($detailsbiensArray as $bien)
                                    <tr>
                                       
                                        <td>{{ $bien->nombien }}</td>
                                        <td>{{ $bien->nomtypeb}}</td>
                                  
        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <p>Id biens:</p>
                            <ul>
                                @foreach($idbiens as $idbien)
                                    <li>{{ $idbien }}</li>
                                @endforeach
                            </ul>
                            <p>Id type biens:</p>
                            <ul>
                                @foreach($idtypebiens as $idtypebien)
                                    <li>{{ $idtypebien }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table End -->


            @endsection