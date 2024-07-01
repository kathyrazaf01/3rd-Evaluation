@extends('layouts.index')
@section('content')


            <!-- Table Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">                    
                <div class="col-12">
                        <div class="bg-secondary rounded h-100 p-4">

                            @php
                            $idprop = session('idprop');
                            $prop = DB::table('proprietaire')->where('idprop', $idprop)->first();
                            @endphp
                      
                            <div class="d-flex justify-content-between">
                                <h2 class="mb-0">{{ $prop->nomprop }}</h2>
                                <button type="submit" class="btn btn-primary">
                                    <a style="color: white" href="{{route('deconnexionprop')}}">Deconnexion</a>
                                </button>
                            </div>
                            <h6 class="mb-4">choississez deux dates</h6>
                            <table class="table">
                                <thead>
                                   
                                    <tr>
                                        <th scope="col">Biens</th>
                                        <th scope="col">Types de bien</th>
                                        <th scope="col">Details</th>
                                    </tr>
                                  
                                </thead>
                                <tbody>
                                    @foreach ($listebiens as $listebien)
                                    <tr>
                                        <td>{{$listebien->nombien}}</td>
                                        <td>{{$listebien->nomtypeb}}</td>
                                       
                                        <td>
                                            <button type="submit" class="btn btn-primary"><a style="color: white" href="{{route('detailsbien', ['idbien' => $listebien->idbien])}}">Voir Details</a></button>
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