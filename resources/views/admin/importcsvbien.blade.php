@extends('layouts.index')
@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">CSV Import Bien</h6>
                <div class="mb-3">
                    <form action="{{route('importcsvbien')}}" method="POST" enctype="multipart/form-data">
                        @csrf
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
                        <label for="formFile" class="form-label"></label>
                        <input class="form-control bg-dark" type="file" id="formFile" name="csv_file">

                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                        <button type="button" class="btn btn-link m-2"><a href="{{ route('indexadmin') }}">return</a></button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection