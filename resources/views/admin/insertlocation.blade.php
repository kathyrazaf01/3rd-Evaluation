@extends('layouts.index')
@section('content')


            <!-- Form Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
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
                            <h6 class="mb-4">Insertion location</h6>
                            <form action="{{route('insertnewlocation')}}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Le client</label>
                                    <select name="idclient" class="form-select mb-3" aria-label="Default select example">
                                        @foreach ($clients as $client)
                                        <option value="{{$client->idclient}}">{{$client->email}}</option>
                                     
                                        @endforeach
                                    </select>
                        
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">liste Bien</label>
                                    <select name="idbien" class="form-select mb-3" aria-label="Default select example">
                                        @foreach ($biens as $bien)
                                        <option value="{{$bien->idbien}}">{{$bien->nombien}}</option>
                                     
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Durée de location</label>
                                    <input type="number" name="duree" class="form-control" id="exampleInputPassword1">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Date début de location</label>
                                    <input type="date" name="datedebut" class="form-control" id="exampleInputPassword1">
                                </div>
                               
                                <button type="submit" class="btn btn-primary">Ajout</button>
                                <button type="button" class="btn btn-link m-2"><a href="{{ route('indexadmin') }}">return</a></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form End -->

@endsection