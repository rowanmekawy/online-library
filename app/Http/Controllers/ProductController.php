<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use App\Models\book;
use App\Models\cart;
use App\Models\user;
use App\Models\user_book_cart;
use App\Models\wishlist;
use App\Models\user_book_wishlist;
//use DB;
use Session;

class ProductController extends Controller
{
    public function details($id)
    {
       
        
        $book= book::find($id);
        return view('product-details',['book'=>$book]);
        
    }

    

    public function remove(Request $request)
    {
     if($request->id) {

        $cart = session()->get('cart');

        if(isset($cart[$request->id])) {

            unset($cart[$request->id]);

            session()->put('cart', $cart);
        }

        session()->flash('success', 'Product removed successfully');
        }
    }
    
    public function addToWishlist(Request $request)
    
    {   
        // $books= book::find($id);
        if (!wishlist::where('book_id',$request->book_id)->where('user_id',Auth::id())->exists()){
            if(Auth::check())
            {
                
            $wishlist=new wishlist;
            $wishlist ->user_id=Auth::id();
            $wishlist ->book_id=$request->book_id;
            $wishlist->save();
            // return view('index');
            return $this->wishlist();

            }
            else 
            {
                return redirect ('login');
            }
        }

        else 
        {
            // return view('index');
            return $this->wishlist();
        }
            
    }

    public function addToCart(Request $request)
    {
       
        
        // $books= book::find($id);
        $cart = session()->get('cart');
        if (!cart::where('book_id',$request->book_id)->where('user_id',Auth::id())->exists()){
            if(Auth::check()) {
                // $cart = [
                //         $id => [
                //             "name" => $books->name,
                //             "quantity" => 1,
                //             "price" => $books->price,
                //             "photo" => $books->cover_image
                //         ]
                // ];
                // session()->put('cart', $cart);
                
                $cart = new cart;
                $cart ->user_id=Auth::id();
                $cart ->book_id=$request->book_id;
                $cart->save();
                // return view('cart',['books'=>$books]);
            //    return view ('index');
            return $this->cartList();
    
            }
            else 
            {
                return redirect ('login');
            }
        }
        else 
        {
            // return view('index');
            return $this->cartList();

        }
           
        // if(isset($cart[$id])) {
        //     $cart[$id]['quantity']++;
        //     session()->put('cart', $cart);
            
        // $cart = new cart;
        // $cart ->user_id=Auth::id();
        // $cart ->book_id=$request->book_id;
        // $cart->save();
        //     return view('cart',['book'=>$book]);
        // }

        // $cart[$id] = [
        //     "name" => $book->name,
        //     "quantity" => 1,
        //     "price" => $book->price,
        //     "photo" => $book->cover_image
        // ];
        // session()->put('cart', $cart);
        
        // $cart = new cart;
        //     $cart ->user_id=Auth::id();
        //     $cart ->book_id=$request->book_id;
        //     $cart->save();
        // return view('cart',['book'=>$book]);


    }

    static function cartItems()
    {
        $user_id = Auth::id();
        return cart:: where ('user_id', $user_id)->count();
    }
   
    public function cartList()
    {
        $user_id = Auth::id();
        
        // $books = DB :: table('carts')
        // ->join('books','carts.book_id','=','book_id')
        // -> where ('carts.user_id','LIKE','%'.$user_id.'%')
        // ->select('books.*')
        // ->get();
        $books = DB :: select('
        SELECT books.*
        FROM ((carts
        INNER JOIN books ON carts.book_id = books.id))
        where carts.user_id = '.$user_id.' ;
        ');
        return view ('cart',['books'=>$books]);
    }

    public function wishlist()
    {
        $user_id = Auth::id();
        // $books = DB :: table('wishlists')
        // ->join('books','wishlists.book_id','=','book_id')
        // // ->join ('users','wishlists.user_id','=','user_id')
        // -> where ('wishlists.user_id',$user_id)
        // ->select('books.*')
        // ->get();
        // return view ('wishlist',['books'=>$books]);
        $books = DB :: select('
        SELECT books.*
        FROM ((wishlists
        INNER JOIN books ON wishlists.book_id = books.id))
        where wishlists.user_id = '.$user_id.' ;
        ');
        return view ('wishlist',['books'=>$books]);
    }

    // public function addToWishlist($id)
    // {
       
        
    //     $book= book::find($id);
    //     if(!$book) {
    //         abort(404);
    //     }
    //     $wishlist = session()->get('wishlist');
    //     if(!$wishlist) {
    //         $wishlist = [
    //                 $id => [
    //                     "name" => $book->name,
    //                     "price" => $book->price,
    //                     "photo" => $book->cover_image
    //                 ]
    //         ];
    //         session()->put('wishlist', $wishlist);
    //         return view('wishlist',['book'=>$book]);
    //     }

    //     if(isset($wishlist[$id])) {
    //         // $cart[$id]['quantity']++;
    //         // session()->put('cart', $cart);
    //         return view('wishlist',['book'=>$book]);
    //     }

    //     // $cart[$id] = [
    //     //     "name" => $book->name,
    //     //     "quantity" => 1,
    //     //     "price" => $book->price,
    //     //     "photo" => $book->cover_image
    //     // ];
    //     // session()->put('cart', $cart);
    //     // return view('cart',['book'=>$book]);
    // }
    
    public function destroy_wishlist($book_id)
    {
        $wishlist= wishlist::
        where ('book_id','=',$book_id);
        $wishlist->delete();
        // return view('index');
        return $this->wishlist();

    }

    public function destroy_cartList($book_id)
    {
        // $cart= cart::find($book_id);
        $cart = cart ::
        where ('book_id','=',$book_id);
        $cart->delete();
        // return view('index');
        return $this->cartList();

    }

    public function search (Request $request)
    {
        $result = book ::
        where('name', 'LIKE','%'.$request->input('search').'%')
        ->orwhere('author', 'LIKE','%'.$request->input('search').'%')   
        ->get();
        return view ('shop-right-sidebar',['books'=>$result]);
    }

    public function newBooks (Request $request)
    {
        $result = DB::table('books')->orderBy('id', 'DESC')->first();
        return view ('shop-right-sidebar',['books'=>$result]);
    }
    
}



