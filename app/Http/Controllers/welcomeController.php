<?php

namespace App\Http\Controllers;
use App\Models\category;
use App\Models\faq;
use App\Models\product;
use App\Models\aboutUs;
use Illuminate\Http\Request;

class welcomeController extends Controller
{
    public function welcome()
    {
        return view('welcome',[
            'categories' => category::all()
        ]);
    }

    public function show_single_product($id)
    {
        return view('show_single_product',[
            'product' => product::where('id',$id)->first()
        ]);
    }

    public function show_searched_items($item)
    {
        $products = product::where('id',$item)->orWhere('name','LIKE','%'.$item.'%')->orWhere('weight',$item)->orWhere('description','LIKE','%'.$item.'%')->orWhere('price',$item)->with('category')->get();
        return view('searchItem',[
            'products' => $products,
            'searchedItem' => $item
        ]);
    }

    public function show_searched_item_by_category($id)
    {
        $category = category::find($id)->first();
        return view('search',[
            'category' => $category,
        ]);
    }

    /*
    * show FAQ's
    */
    public function faq()
    {
        return view('faq',[
            'faqs' => faq::latest()->get()
        ]);
    }


    /*
    *Search product by name
    */
    public function show_searched_item_by_name($name)
    {
        $products = product::where('name',$name)->orWhere('description','LIKE','%',$name.'%')->latest()->paginate(9);
        return view('searchItem',[
            'products' => $products,
            'searchedItem' => $name
        ]);
    }

    public function about_us()
    {
        return view('about',[
            'data' => aboutUs::latest()->first()
        ]);
    }

}
