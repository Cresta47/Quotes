<?php

namespace App\Http\Controllers;

use App\Author;
use App\Quote;
use Illuminate\Http\Request;

use App\Http\Requests;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($author=null)
    {

        if(!is_null($author))
        {
           $quote_author=Author::where('name',$author)->first();
            if($quote_author){
                $quotes=$quote_author->quotes()->orderBy('created_at','desc')->paginate(6);
            }
        }
        else{
            $quotes=Quote::orderBy('created_at','desc')->paginate(6);
        }

        return view('index',['quotes'=>$quotes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'author'=>'required|max:60|alpha',
            'quote'=>'required|max:500'
        ]);
        $authorText=ucfirst($request['author']);
        $quoteText=$request['quote'];

        $author=Author::where('name',$authorText)->first();
        if(!$author){
            $author=new Author();
            $author->name=$authorText;
            $author->save();
        }
        $quote=new Quote();
        $quote->quote=$quoteText;
        $author->quotes()->save($quote);

        return redirect()->route('index')->with([
            'success'=>'Quote saved'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quote=Quote::find($id);

        $author_deleted=false;
        if(count($quote->author->quotes)===1){
            $quote->author->delete();
            $author_deleted=true;
        }
        $quote->delete();
        $msg=$author_deleted ?'Quote and author deleted':'Quote deleted';
        return redirect()->route('index')->with(['success'=>$msg]);
    }
}
