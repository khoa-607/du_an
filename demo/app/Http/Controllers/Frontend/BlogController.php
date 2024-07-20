<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\Rate;
use App\Models\Comments;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RateRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CommentsRequest;
use Illuminate\Support\Carbon;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('rate');
        
    }

//Page list
    public function list()
    {
        $blogPosts = BlogPost::with('rates')->get();

        foreach ($blogPosts as $blogPost) {
            $blogPost->average_rating = $blogPost->rates->avg('rate');
        }
    
        return view('frontend.blogs.list', compact('blogPosts'));    }

//Page detail
    public function detail($id)
    {
        $blogPost = BlogPost::with(['rates', 'comments.replies'])->findOrFail($id);

        $previousPost = BlogPost::where('id', '<', $id)->orderBy('id', 'desc')->first();
        $nextPost = BlogPost::where('id', '>', $id)->orderBy('id', 'asc')->first();

        $blogPost->average_rating = $blogPost->rates->avg('rate');
        
        // Calculate the total number of comments
        $totalComments = $blogPost->comments->count() + $blogPost->comments->sum(function ($comment) {
            return $comment->replies->count();
        });

        return view('frontend.blogs.detail', compact('blogPost', 'previousPost', 'nextPost', 'totalComments'));
    }


//Rate
    public function rate(RateRequest $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập để đánh giá.']);
        }
        
        $userId = Auth::id();
        $blogId = $request->blog_id;
        $rate = $request->rate;

        // Lưu đánh giá vào bảng `rates`
        $existingRate = Rate::where('id_user', $userId)->where('id_blogs', $blogId)->first();

        if ($existingRate) {
            // Nếu người dùng đã đánh giá trước đó, cập nhật lại đánh giá của họ
            $existingRate->update(['rate' => $rate, 'time' => now()]);
        } else {
            // Nếu chưa, tạo mới một bản ghi đánh giá mới
            Rate::create([
                'id_user' => $userId,
                'id_blogs' => $blogId,
                'rate' => $rate,
                'time' => now(),
            ]);
        }

        // Tính trung bình cộng điểm đánh giá
        $averageRating = Rate::where('id_blogs', $blogId)->avg('rate');
        
        return response()->json([
            'success' => true,
            'average_rating' => round($averageRating, 1)
        ]);
    }

//Comment
public function comment(CommentsRequest $request)
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập để bình luận.']);
        }

        // Tạo bình luận mới
        $comment = Comments::create([
            'cmt' => $request->cmt,
            'id_user' => Auth::id(),
            'id_blogs' => $request->id_blogs,
            'avatar_user' => Auth::user()->avatar,
            'name_user' => Auth::user()->name,
            'level' => $request->level ?? 0,
            'time' => now(),
        ]);

        if ($comment) {
            // Trả về response thành công nếu tạo bình luận thành công
            return response()->json([
                'success' => true,
                'message' => 'Comment thành công!',
                'comment' => $comment,
            ]);
        } else {
            // Trả về response lỗi nếu không tạo được bình luận
            return response()->json(['success' => false, 'message' => 'Đã có lỗi xảy ra khi bình luận.']);
        }
    }
}

