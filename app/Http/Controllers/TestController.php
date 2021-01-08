<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class TestController extends Controller
{
    

    public function index()
    {

            $articles=Article::all();
           
            return $articles;
    }

    public function show($id)
    {
        # code...
        $article=Article::findOrFail($id);
        return $articles;
    }

    public function store(Request $request)
    {       if($request->isMethod('post')){  
            $article= new Article($request->all());
        }

        if($request->isMethod('put')){  
                $article= Article::findOrFail($request->id);
                $article['title']=$request['title'];
                $article['body']=$request['body'];
            }

            $article->save();
               
            return $article;
    }


    public function destroy($id)
    {

            $article=Article::findOrFail($id);
            $article->delete();
           
    }
}
