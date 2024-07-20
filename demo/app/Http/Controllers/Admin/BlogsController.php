<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Http\Requests\BlogsFormRequest;
use App\Http\Controllers\Controller;

class BlogsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $blogs = Blog::paginate(10);// lấy tối đa 10 bản ghi trên mỗi trang
        return view('admin.blog.list', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blog.add');
    }

    public function store(BlogsFormRequest $request) 
{
    $validatedData = $request->validated();

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('avatars'), $imageName);
        $validatedData['image'] = $imageName;
    }

    Blog::create($validatedData);
    return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
}

public function update(Request $request, $id)
{
    $blog = Blog::findOrFail($id);

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('avatars'), $imageName);

        $blog->image = $imageName;
    }

    $blog->save();

    return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
}


    

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
    }
}
