<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;

class MovieController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $movies = Movie::all()->toArray();
    return view('movies.index', compact('movies'));

  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('movies.create');
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    // form validation
    $movie = $this->validate(request(), [
      'director' => 'required',
      'title' => 'required',
      'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:500',
    ]);
    //Handles the uploading of the image
    if ($request->hasFile('image')){
      //Gets the filename with the extension
      $fileNameWithExt = $request->file('image')->getClientOriginalName();
      //just gets the filename
      $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
      //Just gets the extension
      $extension = $request->file('image')->getClientOriginalExtension();
      //Gets the filename to store
      $fileNameToStore = $filename.'_'.time().'.'.$extension;
      //Uploads the image
      $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
    }
    else {
      $fileNameToStore = 'noimage.jpg';
    }
    // create a movie object and set its values from the input
    $movie = new movie;
    $movie->director = $request->input('director');

    $movie->title = $request->input('title');
    $movie->year = $request->input('year');

    $movie->runtime = $request->input('runtime');
    $movie->genre = $request->input('genre');
    $movie->created_at = now();
    $movie->image = $fileNameToStore;
    // save the movie object
    $movie->save();
    // generate a redirect HTTP response with a success message
    return back()->with('success', 'movie has been added');

  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    $movie = Movie::find($id);
    return view('movies.show',compact('movie'));

  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    $movie = Movie::find($id);
    return view('movies.edit',compact('movie'));
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {

    $movie = Movie::find($id);
    $this->validate(request(), [
      'director' => 'required',
      'title' => 'required'
    ]);
    $movie->director = $request->input('director');

    $movie->title = $request->input('title');
    $movie->year = $request->input('year');
  
    $movie->runtime = $request->input('runtime');
    $movie->genre = $request->input('genre');
    $movie->updated_at = now();
    //Handles the uploading of the image
    if ($request->hasFile('image')){
      //Gets the filename with the extension
      $fileNameWithExt = $request->file('image')->getClientOriginalName();
      //just gets the filename
      $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
      //Just gets the extension
      $extension = $request->file('image')->getClientOriginalExtension();
      //Gets the filename to store
      $fileNameToStore = $filename.'_'.time().'.'.$extension;
      //Uploads the image
      $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
    } else {
      $fileNameToStore = 'noimage.jpg';
    }
    $movie->image = $fileNameToStore;
    $movie->save();
    return redirect('movies')->with('success','Movie has been updated');
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    $movie = Movie::find($id);
    $movie->delete();
    return redirect('movies')->with('success','Movie has been deleted');
  }
}
