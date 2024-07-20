<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function account()
    {
        $account = Auth::user();
        return view('frontend.account.account', compact('account'));
    }

    public function showForm()
    {
        return view('frontend.account.account');
    }

    public function update(UpdateAccountRequest $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->id_country = $request->id_country;

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time().'.'.$avatar->getClientOriginalExtension();
            $path = public_path('avatar') . '/' . $avatarName;

            // Resize and save image
            Image::make($avatar->getRealPath())->resize(200, 200)->save($path);

            $user->avatar = $avatarName;
        }

        $user->save();

        return redirect()->route('account')->with('success', 'Profile updated successfully');
    }
    
    public function myProduct()
    {
        $products = Product::where('id_user', Auth::id())->get(); 

        return view('frontend.account.list-product', compact('products'));
    }            

    public function addProduct(Request $request)
    {
        $category = Category::where('name', $request->id_category)->firstOrFail();
        $brand = Brand::where('name', $request->id_brand)->firstOrFail();
        
        $product = new Product;
        $product->id_user = Auth::id();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->id_category = $request->id_category;
        $product->id_brand = $request->id_brand;
        $product->status = $request->status;
        $product->sale = $request->status == 1 ? $request->sale : 0;
        $product->company = $request->company;
        $product->detail = $request->detail;
    
        $images = $request->file('image');
    
        if (count($images) > 3) {
            return redirect()->back()->withErrors(['message' => 'Chỉ có tối đa 3 hình ảnh được cho phép']);
        }
    
        $data = [];
        if($request->hasfile('image')){
            foreach ($request->file('image') as $xx) {

                $image = Image::read($xx);

                $name = $xx->getClientOriginalName();
                $name_2 = "hinh50_".$xx->getClientOriginalName();
                $name_3 = "hinh200_".$xx->getClientOriginalName();
    
                $path = public_path('avatars/'. $name);
                $path2 = public_path('avatars/'. $name_2);
                $path3 = public_path('avatars/'. $name_3);
    
                $image->save($path);
                $image->resize(50, 70)->save($path2);
                $image->resize(200, 300)->save($path3);
    
                $data[] = $name;
            }
        }
    
        // Save image names to the product
        $product->image = json_encode($data);
        $product->save();
    
        return redirect()->route('account.my-product')->with('success', 'Thêm sản phẩm thành công!');
    }
        
    public function showAddProductForm()
    {
        $categories = Category::all();
        $brands = Brand::all();
    
        $getProducts = Product::find(1);

        $getArrImage = $getProducts ? json_decode($getProducts->name, true) : [];

        return view('frontend.account.add-product', compact('categories', 'brands', 'getArrImage'));
    }
    
    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        return view('frontend.account.edit-product', compact('product', 'categories', 'brands'));  
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->id_category = $request->id_category;
        $product->id_brand = $request->id_brand;
        $product->status = $request->status;
        $product->sale = $request->status == 1 ? $request->sale : 0;
        $product->company = $request->company;
        $product->detail = $request->detail;
    
        $existingImages = json_decode($product->image, true) ?? [];
    
        if ($request->has('delete_images')) {
            $deleteImages = $request->delete_images;
            foreach ($deleteImages as $key) {
                if (isset($existingImages[$key])) {
                    $imagePath = public_path('avatars/' . $existingImages[$key]);
                    if (file_exists($imagePath)) {
                        unlink($imagePath); 
                    }
                    unset($existingImages[$key]);
                }
            }
            $existingImages = array_values($existingImages);
        }
    
        $imageCount = count($existingImages);
    
        $images = $request->file('image');
        if ($images) {
            if (($imageCount + count($images)) > 3) {
                return redirect()->back()->withErrors(['message' => 'Tổng số hình ảnh phải <= 3']);
            }
    
            $data = [];
            if($request->hasfile('image')){
                foreach ($request->file('image') as $xx) {
    
                    $image = Image::read($xx);
    
                    $name = $xx->getClientOriginalName();
                    $name_2 = "hinh50_".$xx->getClientOriginalName();
                    $name_3 = "hinh200_".$xx->getClientOriginalName();
        
                    $path = public_path('avatars/'. $name);
                    $path2 = public_path('avatars/'. $name_2);
                    $path3 = public_path('avatars/'. $name_3);
        
                    $image->save($path);
                    $image->resize(50, 70)->save($path2);
                    $image->resize(200, 300)->save($path3);
        
                    $data[] = $name;            
                }
                $existingImages = array_merge($existingImages, $data);
            }
        }
        
        // Save the updated image list
        $product->image = json_encode($existingImages);
        $product->save();
    
        return redirect()->route('account.my-product')->with('success', 'Sản phẩm cập nhật thành công!');
    }
                        
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('account.my-product')->with('success', 'Sản phẩm đã được xóa thành công!');
    }           
}
?>
