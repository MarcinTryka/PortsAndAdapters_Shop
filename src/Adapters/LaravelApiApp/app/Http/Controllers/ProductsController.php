<?php

namespace App\Http\Controllers;

use App\Models\CreateProductRequest;
use App\Models\CreateProductResponse;
use App\Models\ProductsRepository;
use Illuminate\Http\Request;
use Shop\Domain\Model\Money\InvalidMoneyFormatException;
use Shop\Domain\Model\Product\CreateException;
use Shop\Domain\Ports\AddProductService;
use Validator;

class ProductsController extends Controller
{
    public function store(Request $request){
        $rules = [
            'name' => 'required|min:1|max:10',
            'price' => 'required|numeric'
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        };

        /**
         * Use domain service to create product
         */
        try{
            $createProductRequest = new CreateProductRequest($request);
        } catch (InvalidMoneyFormatException $exception) {
            return response()->json(['price' => ['Invalid price']], 400);
        }
        $createProductResponse = new CreateProductResponse();

        try{
            $createProductService =  new AddProductService(new ProductsRepository());
            $createProductService->addProduct($createProductRequest, $createProductResponse);
        } catch (CreateException $exception) {
            /**
             * @todo Log exception.
             */
            return response()->json("Creating product error");
        }

        return response()->json($createProductResponse->toArray(), 201);
    }
}
