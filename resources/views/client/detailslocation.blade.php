@extends('layouts.index')
@section('content')


            <!-- Table Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">                    
                <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">choississez deux dates</h6>
                            <form action="{{route('filtredate')}}" method="POST">
                             
                                <ul class="list-unstyled mb-0">
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Date 1</label>
                                        <div class="col-sm-10">
                                            <input type="date" name="date1" class="form-control" id="inputEmail3">
                                        </div>
                                    </div>
                                    <div class="row mb-3" style="margin-bottom: 50px; ">
                                        <label for="inputPassword3" class="col-sm-2 col-form-label">Date 2</label>
                                        <div class="col-sm-10">
                                            <input type="date" name="date2" class="form-control" id="inputPassword3">
                                        </div>
                                    </div>
    
                                    <ul style="margin-top: 50px;">
                                        <li>
                                            <h6>Total: <span class="ms-2 fw-light"></span></h6>
                                        </li>
                                        <li>
                                            <h6>Payer: <span class="ms-2 fw-light"></span></h6>
                                        </li>
                                        <li>
                                            <h6>Reste: <span class="ms-2 fw-light"></span></h6>
                                        </li>
                                    </ul>
                                    @isset($showlocations)
                                    @foreach ($showlocations as $showlocation)
                                    <ul style="margin-top: 50px;">
                                        <li>
                                            <h6>Total: <span class="ms-2 fw-light">{{ $showlocation->total }} Ar</span></h6>
                                        </li>
                                        <li>
                                            <h6>Payer: <span class="ms-2 fw-light">{{ $showlocation->paye }} Ar</span></h6>
                                        </li>
                                        <li>
                                            <h6>Reste: <span class="ms-2 fw-light">{{ $showlocation->reste }} Ar</span></h6>
                                        </li>
                                    </ul>
                                    @endforeach
                                @endisset
                                <input type="hidden" name="idbien" value="{{$idbien}}">
                                <div style="margin-top: 50px; ">
                                    <button type="submit" class="btn btn-primary">Filtre</button>
                                </div>
                               
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table End -->


            @endsection