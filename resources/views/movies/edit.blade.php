@extends('layouts.app')
@section('content')
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
      <div class="card">
        <div class="card-header">Edit and update the movie</div>
        @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div><br />
        @endif
        @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
        @endif
        <div class="card-body">
          <form class="form-horizontal" method="POST" action="{{ action('MovieController@update',
          $movie['id']) }} " enctype="multipart/form-data" >
          @method('PATCH')
          @csrf
          <div class="col-md-8">
            <label >Director</label>
            <input type="text" name="director"
            placeholder="Director" />
          </div>
          <div class="col-md-8">
            <label >Title</label>
            <input type="text" name="title"
            placeholder="Title" />
          </div>

          <div class="col-md-8">
            <label >Genre</label>
            <input type="text" name="genre"
            placeholder="Genre" />
          </div>
          <div class="col-md-8">
            <label >Runtime</label>
            <input type="text" name="runtime"
            placeholder="Runtime" />
          </div>

          <div class="col-md-8">
            <label >Year</label>
            <input type="text" name="year"
            placeholder="Year" />
          </div>

          <div class="col-md-8">
            <label>Image</label>
            <input type="file" name="image" />
          </div>
          <div class="col-md-6 col-md-offset-4">
            <input type="submit" class="btn btn-primary" />
            <input type="reset" class="btn btn-primary" />
          </a>
        </div>
      </form>
    </div>
  </div>
  @endguest
</div>
</div>
</div>
@endsection
