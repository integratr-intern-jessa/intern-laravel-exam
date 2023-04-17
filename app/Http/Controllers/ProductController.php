<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\view\View;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products= Product::all();

        return response()->json($products, 200);
        return Product::orderBy('created at', 'asc')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $payload = $this->payload($request);

        $product = Product::create($payload);

        $this-> validate($request, [
            'product_name'=> 'required',
            'quantity' => 'required',
        ]);

        // $product = Product::findorFail($id);
        $product = new Product;
        $product->product_name= $request->input('product_name');
        $product->quantity= $request->input('quantity');
        $product-> save();

        return $product;

        // $product = $request->validate([
        //     'product' => 'required|unique:posts|max:255',
        //     'quantity' => 'required',
        // ]);

        // The blog post is valid...

        return redirect('/posts');
        return response()->json($product, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where ('id', $id)->first();

        return response()->json($product, 200);
        return Product::findorFail($id);
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
        $payload = $this->payload($request);

        $product = Product::where ('id', $id)->first();
        $product->update($payload);

        return response()->json($product, 200);

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::where ('id', $id)->first();
        $product->delete();

        return response('', 204);
    }

    public function payload($request){
        return $this->validate($request, [
            'product_name' => ['required'],
            'quantity'=>['required']
        ]);
    }
}
