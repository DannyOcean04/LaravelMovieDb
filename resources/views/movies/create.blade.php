<!-- inherite master template app.blade.php -->
@extends('layouts.app')
<!-- define the content section -->
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10 ">
      @guest
     <div class="card">
       <div class="card-header">Error</div>
       <div class="card-body">
         <p>You do not have access to this page</p>
       </div>
     </div>
     @else
      <div class="card">
        <div class="card-header">Create an new movie</div>
        <!-- display the errors -->
        @if ($errors->any())
        <div class="alert alert-danger">
          <ul> @foreach ($errors->all() as $error)
            <li>{{ $error }}</li> @endforeach
          </ul>
        </div><br /> @endif
        <!-- display the success status -->
        @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br /> @endif
        <!-- define the form -->
        <div class="card-body">
          <form class="form-horizontal" method="POST"
          action="{{url('movies') }}" enctype="multipart/form-data">
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
              <input type="file" name="image"
              placeholder="Image file" />
            </div>
            <div class="col-md-6 col-md-offset-4">
              <input type="submit" class="btn btn-success" />
              <input type="reset" class="btn btn-primary" />
            </div>
          </form>
        </div>
      </div>

      <div class="card">
          <div class="card-header">Add movies via csv file</div>
        <form action="{{url('/upload')}}" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
        <div class="form-group">
            <label for="upload-file"></label>
            <input type="file" name="upload-file" class="form-control">
        </div>
        <input class="btn btn-success" type="submit" value="Upload Movies" name="submit">
    </form>
      </div>



      @endguest
    </div>
  </div>
</div>
@endsection
