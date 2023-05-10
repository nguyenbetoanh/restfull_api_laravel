<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Http\Resources\Product as ProductResource;

class ProductController extends Controller
{
    public function index()
    {
      $products=Product::all();
      if(!empty($products)){
        $arr=[
            'success'=>true,
            'message'=>'hiện tất cả dữ liệu thành công !',
            'data'=> $products
        ];
         return response()->json($arr,200);
      }else{
        $arr=[
            'success'=>false,
            'message'=>'không có dữ liệu !',
            'data'=> ""
        ];
         return response()->json($arr,400);
      }
     
    }

    public function store(Request $request)
    {
        $input=$request->all();
        $validator=Validator::make($input,[
            // không đc để trống , là duy nhất, dộ dài tối đa 100
            'name'=>'required',
            'price'=>'required'
        ]);
        if($validator->fails()){
            $arr=[
                'success'=>false,
                'message'=>'Lỗi kiểm tra dữ liệu !',
                'data'=>$validator->errors()
            ];
            return response()->json($arr,400);
        }else{
            $product=Product::create($input);
            $arr=[
                'success'=>true,
                'message'=>'Thêm dữ liệu thành công !',
                'data'=>new ProductResource($product)
            ];
            return response()->json($arr,201);
        }

    }
    public function show(string $id)
    {
        //seach theo id hoặc theo tên
        $product =  Product::where('id', $id)->orWhere('name', 'like', '%' .$id. '%')->get();
        if(empty($product)){
            $arr=[
                'success'=>false,
                'message'=>'không có dữ liệu !',
                'data'=> ""
            ];
             return response()->json($arr,404);
          }else{
             $arr=[
                'success'=>true,
                'message'=>'hiện dữ liệu sản phẩm có tên là: '.$id,
                'data'=> $product
            ];
             return response()->json($arr,200);
          }
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->price =$request->price;
        $product->created_at=$request->created_at;
        $product->updated_at=$request->updated_at;
        $product->save();

    }
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product-> delete();
        if(!empty($product)){
            $arr=[
                'success'=>true,
                'message'=>'Xóa thành công !',
                'data'=>  ""
            ];
             return response()->json($arr,200);
          }else{
            $arr=[
                'success'=>false,
                'message'=>'Có lỗi sảy ra !',
                'data'=> ""
            ];
             return response()->json($arr,500);
          }
    }
}
