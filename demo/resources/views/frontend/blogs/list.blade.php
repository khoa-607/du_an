@extends('frontend.layout.app1')

@section('content')
<div class="blog-post-area">
    <h2 class="title text-center">Latest From our Blog</h2>
    @foreach($blogPosts as $blogPost)
    <div class="single-blog-post" data-blog-id="{{ $blogPost->id }}">
        <h3>{{ $blogPost->title }}</h3>
        <div class="post-meta">
            <ul>
                <li><i class="fa fa-user"></i>Mac Doe</li>
                <li><i class="fa fa-clock-o"></i> {{ $blogPost->created_at->format('h:i a') }}</li>
                <li><i class="fa fa-calendar"></i> {{ $blogPost->created_at->format('M d, Y') }}</li>
            </ul>
            <span>
            <div class="rate" data-blog-id="{{ $blogPost->id }}">
                <div class="vote">
                    <div class="star_1 ratings_stars {{ $blogPost->average_rating >= 1 ? 'ratings_over' : '' }}"><input value="1" type="hidden"></div>
                    <div class="star_2 ratings_stars {{ $blogPost->average_rating >= 2 ? 'ratings_over' : '' }}"><input value="2" type="hidden"></div>
                    <div class="star_3 ratings_stars {{ $blogPost->average_rating >= 3 ? 'ratings_over' : '' }}"><input value="3" type="hidden"></div>
                    <div class="star_4 ratings_stars {{ $blogPost->average_rating >= 4 ? 'ratings_over' : '' }}"><input value="4" type="hidden"></div>
                    <div class="star_5 ratings_stars {{ $blogPost->average_rating >= 5 ? 'ratings_over' : '' }}"><input value="5" type="hidden"></div>
                    <span class="rate-np">{{ round($blogPost->average_rating ?? 0, 1) }}</span>
                </div> 
            </div>
            </span>
        </div>
        <img src="{{ url('/avatars/' . $blogPost->image) }}" alt="{{ $blogPost->title }}" width="100%">
        <p>{!! htmlspecialchars_decode($blogPost->description) !!}</p>
        <a href="{{ route('blogs.detail', ['id' => $blogPost->id]) }}">Read More</a>
    </div>
    @endforeach
</div>

<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.ratings_stars').hover(
        function() {
            $(this).prevAll().andSelf().addClass('ratings_hover');
        },
        function() {
            $(this).prevAll().andSelf().removeClass('ratings_hover');
        }
    );

    $('.ratings_stars').click(function() {
        var checkLogin = "{{ Auth::check() }}";

        if (checkLogin) {
            var rate = $(this).find("input").val();
            var blogId = $(this).closest('.single-blog-post').data('blog-id');

            $('.ratings_stars').removeClass('ratings_over');
            $(this).prevAll().andSelf().addClass('ratings_over');

            $.ajax({
                type: 'POST',
                url: '{{ url("/member/blogs/rate") }}',
                data: {
                    rate: rate,
                    blog_id: blogId
                },
                success: function(data) {
                    if (data.success) {
                        var averageRating = data.average_rating;
                        // Update the average rating for this specific blog post
                        $('.rate[data-blog-id="' + blogId + '"] .rate-np').text(averageRating);
                        alert('Đánh giá thành công');
                    } else {
                        alert(data.message);
                    }
                }
            });
        } else {
            alert("Vui lòng đăng nhập để đánh giá.");
            window.location.href = '{{ route("login.form") }}';
        }
    });
});
</script>
@endsection
