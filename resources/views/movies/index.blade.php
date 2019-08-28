@extends('layouts.app')
@section('content')
<?php use App\Http\Controllers\MovieController;?>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8 ">
      @guest

      <div class="card">
        <div class="card-header">Error</div>
        <div class="card-body">
          <p>You do not have access to this page</p>
        </div>
      </div>
      @else

      <div class="card text-center ">
        <div class="card-header">Movie Database</div>
        <div class="card-body">
          <form action="/search" method="get">
            <div class="input-group">
              <input type="search" name="search" placeholder="Search Movies" class="form-control">
              <span class="input-group-prepend">
                <button type="submit" class="btn btn-success">Search</button>
              </span>
            </div>
          </form>
        </div>
      </div>

      <div class="container-fluid">
      <div class="card-deck">
      @foreach($movies as $movie)

        <div class="col-sm-4">
          <div class="card text-center"  style="width: 15rem;">
            <img style="width:100%;height:400px"class="card-img-top img-center " src="{{ asset('storage/images/'.$movie->image)}}" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">{{$movie->title}}</h5>
              <h6 class="card-subtitle mb-2 text-muted">{{$movie->director}}</h6>
              <h6 class="card-subtitle mb-2 text-muted">{{$movie->runtime}} mins</h6>
              <h6 class="card-subtitle mb-2 text-muted">{{$movie->genre}}</h6>
              <h6 class="card-subtitle mb-2 text-muted">{{$movie->year}}</h6>
              <h6 class="card-subtitle mb-2 text-muted">{{ MovieController::averageRating($movie->id)}}/5 </h6>

              <div class="btn-group" role="group" aria-label="Basic example">
                <a type="button" href="{{action('MovieController@show', $movie->id)}}" class="btn btn-primary">Reviews</a>
                @if (Auth::user()->role == 1)
                <a type="button" href="{{action('MovieController@edit', $movie->id)}}" class="btn btn-warning">Edit</a>

                <form action="{{action('MovieController@destroy', $movie->id)}}"
                  method="post"> @csrf
                  <input name="_method" type="hidden" value="DELETE">
                  <button class="btn btn-danger" type="submit"> Delete</button>
                </form>
                @endif
              </div>

            </div>
          </div>
        </div>

      @endforeach
      </div>
    </div>
      <div class="col-sm-12">
        {{$movies->links() }}
      </div>


      @endguest

    </div>
  </div>
</div>
@endsection
