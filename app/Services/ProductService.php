<?php

namespace App\Services;
use App\Model\Product;
use App\Helpers\ModelIncremental;
use Exception;

class ProductService 
{
	public function paginate()
	{
		return Product::latest()->paginate(5);
	}

	public function create($productData)
	{
        $imageName = $this->saveImage($productData['image']);

        return Product::create([
            'product_id' => ModelIncremental::generateIncrementId('product'),
            'name' => $productData['name'],
            'price' => $productData['price'], 
            'discount_percentage' => $productData['discount_percentage'],
            'description' => $productData['description'],
            'image' => $imageName
        ]);
	}

	public function saveImage($image)
	{
		$imageName = time().'.'.$image->extension();
        $image->move(public_path('images'), $imageName);
        return $imageName;
	}

	public function getById($productId)
	{
		return Product::findOrFail($productId);
	}

	public function update($product, $productData)
	{
		$productData['image'] = (!is_null($productData['image']) && array_key_exists('image', $productData)) ? $this->saveImage($productData['image']) : $product->image;
		return $product->update($productData);
	}

	public function delete($product)
	{
		return $product->delete();
	}
}

