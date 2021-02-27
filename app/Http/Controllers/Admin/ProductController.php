<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use DB;

class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productService->paginate();

        return view('product.index', ['products' => $products])->with('i', (request()->input('page', 1) - 1) * 5);;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $validateData = $request->validated();
        DB::beginTransaction();

        try {
            $product = $this->productService->create($validateData);
            DB::commit();

            return redirect()->route('products.index')
                        ->with('success', 'Product successfully stored.'); 
        } catch (\Exception $ex) {
            DB::rollback();
            return $ex;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($product_id)
    {
        $product = $this->productService->getById($product_id);
        return view('product.show',['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($product_id)
    {
        $product = $this->productService->getById($product_id);
        return view('product.edit',['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $product_id)
    {
        $validateData = $request->validated();
        DB::beginTransaction();

        try {
            $product = $this->productService->getById($product_id);
            $product = $this->productService->update($product, $validateData);
            DB::commit();

            return redirect()->route('products.index')
                        ->with('success', 'Product updated stored.'); 
        } catch (\Exception $ex) {
            DB::rollback();
            return $ex;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id)
    {
        DB::beginTransaction();

        try {
            $product = $this->productService->getById($product_id);
            $this->productService->delete($product);
            DB::commit();

            return redirect()->route('products.index')
                        ->with('success', 'Product deleted.'); 
        } catch (\Exception $ex) {
            DB::rollback();
            return $ex;
        }
    }
}
