<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    use ControllerTrait;

    protected $model;
    protected $relationships = [
        'productCategory', 'unitsMeasure',
    ];

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $product::with($this->relationships())->find($product->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        return Product::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());

        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return $product;
    }
}
