<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use App\Review;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class MovieController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {

    $movies = DB::table('movies')->paginate(3);
    $reviews = Review::all()->toArray();
    $users = User::all()->toArray();
    return view('movies.index',compact('movies','reviews','users'));
  }

  public function search(Request $request){

    $reviews = Review::all()->toArray();
    $users = User::all()->toArray();
    $search = $request->get('search');
    $movies = DB::table('movies')->where('title', 'like', '%'.$search.'%')->orwhere('director', 'like', '%'.$search.'%')->paginate(3);

    if(count($movies)>0){
      return view('movies.index',compact('movies','reviews','users'));
    }
    else
    return view ('movies.index',compact('movies','reviews','users'))->withMessage('No Details found. Try to search again !');
  }

  public static function averageRating($movieID){

    $reviews=Review::all()->toArray();
    $x = 0;
    $count =0;
    foreach($reviews as $rev)
    {

      if($rev["movieid"]==$movieID)
      {
        $y = $rev['rating'];
        $x = $x+$y;
        $count++;
      }

    }

    if($count == 0){
      return $x;
    }
    else{
      $avgR = $x/$count;

      return $avgR;
    }


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
    $reviews = Review::all()->toArray();
    $users = User::all()->toArray();
    return view('movies.show',compact('movie','reviews','users'));

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



  public function upload(Request $request)
    {
      //get file
      $upload=$request->file('upload-file');
      $filePath=$upload->getRealPath();
      //open and read
      $file=fopen($filePath, 'r');
      $header= fgetcsv($file);
      // dd($header);
      $escapedHeader=[];
      /////////////////////////////////////////////////////////////////////////
      //validate
        foreach ($header as $key => $value) {
          $lheader=strtolower($value);
          $escapedItem=preg_replace('/[^a-z]/', '', $lheader);
          array_push($escapedHeader, $escapedItem);
      }
      ///////////////////////////////////////////////////////////////////
      //looping through other columns
      while($columns=fgetcsv($file))
      {
        if($columns[0]=="")
        {
          continue;
        }


        $data= array_combine($escapedHeader, $columns);

        // Table update
        $director=$data['director'];
        $title=$data['title'];
        $year=$data['year'];
        $runtime=$data['runtime'];
        $genre=$data['genre'];

        $movie= Movie::firstOrNew(['director'=>$director,'title'=>$title]);
        $movie->year=$year;
        $movie->runtime=$runtime;
        $movie->genre=$genre;
        $movie->save();

      }


              return back()->with('success', 'movies have been added');
}


}
