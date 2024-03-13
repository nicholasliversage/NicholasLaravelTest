<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Services\JsonDataService;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $jsonData;

    public function __construct(JsonDataService $jsonData)
    {
        $this->jsonData = $jsonData;
    }
 
    public function index(Request $request, JsonDataService $jsonData)
    {
      
        
        if ($request->ajax()) {
           
           
            $products = $jsonData->getData();
            $data = [];
            $total = 0;
            foreach ($products as $key => $product) {
                $data[] = [
                    'id' => $key, 
                    'name' => $product['name'], 
                    'quantity' => $product['quantity'],
                    'price' => $product['price'], 
                    'date_submitted' => $product['date_submitted'],
                    'total_value' => $product['price'] * $product['quantity'],
                    'sum_total' =>'' ,
                    'action' => '<a href="#" class="btn btn-xs btn-secondary btn-edit">Edit</a> ' .
                                '<button data-rowid="' . ($key) . '" class="btn btn-xs btn-danger btn-delete">Del</button>'
                            
                ];

                $total += $product['price'] * $product['quantity'];
            }
           
            $data[] = [
                'id' => '', 
                'name' => '', 
                'quantity' => '',
                'price' => '', 
                'date_submitted' => '',
                'total_value' => '',
                'sum_total' => $total,
                'action' => ''
            ];
            return response()->json(['data' => $data]);
        }
    
        return view('products');
    }

    public function store(Request $request, JsonDataService $jsonData)
    {
        $products = $jsonData->getData();
        $indexes = count($products);
       
        $data = [
            'id' => $indexes + 1, 
            'name' => $request->name, 
            'quantity' => $request->quantity,
            'price' => $request->price, 
            'date_submitted' => $request->dob,
        ];
        $products[] = $data;
        $storage_route = '\public\data.json';//storage_path() . "\app\public\data.json";s
        Storage::put($storage_route, json_encode($products));
        return ['success' => true, 'message' => 'Inserted Successfully'];
      
    }

    public function show($id)
    {
        return;
    }

    public function update(Request $request,$id, JsonDataService $jsonData)
    {
       
        $products = $jsonData->getData();
        $products[$id] = [
            'id' => $id, 
            'name' => $request->name, 
            'quantity' => $request->quantity,
            'price' => $request->price, 
            'date_submitted' => $request->dob,
        ];
       
       
        $storage_route = '\public\data.json';//storage_path() . "\app\public\data.json";s
        Storage::put($storage_route, json_encode($products));
        return ['success' => true, 'message' => 'Updated Successfully'];
    }

    public function destroy($id,JsonDataService $jsonData)
    {
        
        $products = $jsonData->getData();
        unset($products[$id]);
        $storage_route = '\public\data.json';//storage_path() . "\app\public\data.json";s
        Storage::put($storage_route, json_encode($products));
        return ['success' => true, 'message' => 'Deleted Successfully'];
    }

}
