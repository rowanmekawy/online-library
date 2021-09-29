<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\book;
use DB;

class bookController extends Controller
{
    public function dashboard()
    {
        return view('admin-dashboard');
    }
      

    public function addBook(Request $request)
    {  
        // $this->validate($request,[
        //     'name' => 'required',
        //     'author' => 'required',
        //     'summary'=> 'required',
        //     'pdf'=> 'required',
        //     'cover_image'=> 'required',
        //     'price'=> 'required',
        // ]);
        // $books = new book ([
        //     'name' => $request->get('name'),
        //     'author' => $request->get('author'),
        //     'summary'=> $request->get('summary'),
        //     'pdf'=> $request->get('pdf'),
        //     'cover_image'=> $request->get('cover_image'),
        //     'price'=> $request->get('price'),
        // ]);
           // $data=$request->all();
        // $status=book::create($data);
        // if($status){
        //    // request()->session()->flash('success','Successfully added user');
        //     echo"book";
        // }
        // else{
        //    // request()->session()->flash('error','Error occurred while adding user');
        // }
        // return redirect()->route('my-account');
        
        $books = new book;
        $img=$request->cover_image;
        $imgname=time().'.'.$img->getClientOriginalExtension();
        $request->cover_image->move('booksImg',$imgname);
        $books->cover_image=$imgname;
        
        $pdf=$request->pdf;
        $pdfname=time().'.'.$pdf->getClientOriginalExtension();
        $request->pdf->move('booksPdf',$pdfname);
        $books->pdf=$pdfname;
        
        $books->name =$request->name;
        $books->author =$request->author;
        $books->summary =$request->summary;
        // $books->pdf =$request->pdf;
        //$books->cover_image =$request->cover_image;
        
        $books->price =$request->price;
        $books->save();
        return redirect()->route('admin-booklist');
     
    }

    public function booklist()
    {
        $books = DB::select('select * from books');
        //DB ($books);
        return view('admin-booklist',['books'=>$books]);
    }

    public function edit($id)
    {
        $book= book::find($id);
        return view('admin-editbook',['book'=>$book]);
        
    }

    public function editbook(Request $request)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'author' => 'required',
        //     'summary'=> 'required',
        //     'pdf'=> 'required',
        //     'cover_image'=> 'required',
        //     'price'=> 'required',
        // ]);

        // $book->update($request->all());
        // return redirect()->route('admin-booklist');
        $book= book::find($request->id);
        $book->name =$request->name;
        $book->author =$request->author;
        $book->summary =$request->summary;

        $img=$request->cover_image;
        $imgname=time().'.'.$img->getClientOriginalExtension();
        $request->cover_image->move('booksImg',$imgname);
        $book->cover_image=$imgname;
        
        $pdf=$request->pdf;
        $pdfname=time().'.'.$pdf->getClientOriginalExtension();
        $request->pdf->move('booksPdf',$pdfname);
        $book->pdf=$pdfname;

        $book->price =$request->price;
        $book->save();
        return redirect('admin-booklist');
        
    }

    public function destroy($id)
    {
        $book= book::find($id);
        $book->delete();
        return redirect('admin-booklist');

    }

    
}
