<?php

namespace App\Http\Controllers;

use App\Classes\Api\WebserviceResponse;
use App\Classes\QueryBuilders\ProductQueryBuilder;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @description : receive products list base on query string filter
     * @example : api/products?page=1&q=p1
     */
    public function products(Request $request): \Illuminate\Http\JsonResponse
    {
        //make products query from $request params and fetch result to products
        $products_query_builder = new ProductQueryBuilder();
        $products_query_builder->make_object_from_request($request);
        $products = $products_query_builder->get_result();


        //make webservice response
        $response = new WebserviceResponse(WebserviceResponse::_RESULT_OK);
        $response->content['products'] = $products;
        return response()->json($response);
    }


    /**
     * @desciprtion : find product and return it to client
     * @example : api/product-detail?id=xxxx
     * //i prefer to use global code instead of id (it better and safe)
     * @example : api/product-detail?code=xxxx
     */
    public function product_detail(Request $request): \Illuminate\Http\JsonResponse
    {
        $product_id = $request->get('id');
//        $product_code = $request->get('code');

        //find product
        $product = Product::find($product_id);
//        $product = Product::findByCode($product_code);

        //check product exists or not
        if($product == null){
            $response = new WebserviceResponse(WebserviceResponse::_NOT_FOUND , 'product not found');
            return response()->json($response);
        }

        $response = new WebserviceResponse(WebserviceResponse::_RESULT_OK);
        $response->content['product'] = $product;
        return response()->json($response);
    }
}
