@extends('frontend.layout.app1')

@section('content')
<div class="col-sm-9">
    <div class="blog-post-area" data-blog-id="{{ $blogPost->id }}">
        <h2 class="title text-center">Latest From our Blog</h2>
        <div class="post-meta">
            <ul>
                <h3>{{ $blogPost->title }}</h3>
                <li><i class="fa fa-user"></i>Mac Doe</li>
                <li><i class="fa fa-clock-o"></i> {{ $blogPost->created_at->format('h:i a') }}</li>
                <li><i class="fa fa-calendar"></i> {{ $blogPost->created_at->format('M d, Y') }}</li>
            </ul>
        </div>
        <img src="{{ url('avatars/' . $blogPost->image) }}" alt="{{ $blogPost->title }}" width="150%">
        <p>{!! htmlspecialchars_decode($blogPost->description) !!}</p>
        <div class="pager-area">
            <ul class="pager pull-right">
                @if($previousPost)
                <li><a href="{{ route('blogs.detail', ['id' => $previousPost->id]) }}">Prev</a></li>
                @endif
                @if($nextPost)
                <li><a href="{{ route('blogs.detail', ['id' => $nextPost->id]) }}">Next</a></li>
                @endif
            </ul>
        </div>
        <div class="rate">
            <div class="vote">
                @for ($i = 1; $i <= 5; $i++)
                <div class="star_{{ $i }} ratings_stars {{ $blogPost->average_rating >= $i ? 'ratings_over' : '' }}">
                    <input value="{{ $i }}" type="hidden">
                </div>
                @endfor
                <span class="rate-np">{{ round($blogPost->average_rating ?? 0, 1) }}</span>
            </div> 
        </div>
    </div>

    <div class="response-area">
        <h2><span id="commentCount">{{ $blogPost->comments->count() }}</span> RESPONSES</h2>
        <ul id="comments-list" class="media-list">
            @foreach($blogPost->comments as $comment)
                @if($comment->level == 0)
                    <li class="media" id="comment-{{ $comment->id }}">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="{{ asset('avatars/' . $comment->avatar_user) }}" alt="{{ $comment->name_user }}" width="100px">
                        </a>
                        <div class="media-body">
                            <ul class="single-post-meta">
                                <li><i class="fa fa-user"></i>{{ $comment->name_user }}</li>
                                <li><i class="fa fa-clock-o"></i>{{ $comment->time->format('M d, Y h:i A')}}</li>
                                <li><i class="fa fa-calendar"></i>{{ $comment->time->format('M d, Y h:i A')}}</li>
                            </ul>
                            <p>{{ $comment->cmt }}</p>
                            <a class="btn btn-primary reply-btn" href="#" data-comment-id="{{ $comment->id }}"><i class="fa fa-reply"></i>Reply</a>
                            
                            @if($comment->replies->isNotEmpty())
                            <ul class="media-list" id="reply-{{ $comment->id }}">
                                @foreach($comment->replies as $reply)
                                    <li class="media second-media" id="comment-{{ $reply->id }}">
                                        <a class="pull-left" href="#">
                                            <img class="media-object" src="{{ asset('avatars/' . $reply->avatar_user) }}" alt="{{ $reply->name_user }}" width="100px">
                                        </a>
                                        <div class="media-body">
                                            <ul class="single-post-meta">
                                                <li><i class="fa fa-user"></i>{{ $reply->name_user }}</li>
                                                <li><i class="fa fa-clock-o"></i>{{ $reply->time->format('M d, Y h:i A')}}</li>
                                                <li><i class="fa fa-calendar"></i>{{ $reply->time->format('M d, Y h:i A')}}</li>
                                            </ul>
                                            <p>{{ $reply->cmt }}</p>
                                            <a class="btn btn-primary reply-btn" href="#" data-comment-id="{{ $reply->id }}"><i class="fa fa-reply"></i>Reply</a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

    <div class="comments-box">
        <h2>Leave a Comment</h2>
        <form id="commentForm" action="{{ route('blogs.comment') }}" method="POST">
            @csrf
            <div class="form-group">
                <textarea class="form-control" name="cmt" placeholder="Your Comment" rows="5"></textarea>
            </div>
            <input type="hidden" name="id_blogs" value="{{ $blogPost->id }}">
            <input type="hidden" name="level" id="commentLevel" value="0">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Star rating hover and click events
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
                var rate = $(this).find('input').val();
                var blogId = $(this).closest('.blog-post-area').data('blog-id');

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
                            alert('Đánh giá thành công');
                            $('.rate-np').text(averageRating);
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

        // Handle the submission of comments and replies
        $('#commentForm').submit(function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                success: function(response) {
                    if (response.success) {
                        var comment = response.comment;
                        var timeFormatted = new Date(comment.time).toLocaleString();
                        var commentHtml = 
                            '<li class="media" id="comment-' + comment.id + '">' +
                                '<a class="pull-left" href="#">' +
                                '<img class="media-object" src="{{ asset('avatars') }}/' + comment.avatar_user + '" alt="' + comment.name_user + '" width="100px">' +
                                '</a>' +
                                '<div class="media-body">' +
                                '<ul class="single-post-meta">' +
                                '<li><i class="fa fa-user"></i>' + comment.name_user + '</li>' +
                                '<li><i class="fa fa-clock-o"></i>' + timeFormatted + '</li>' +
                                '<li><i class="fa fa-calendar"></i>' + timeFormatted + '</li>' +
                                '</ul>' +
                                '<p>' + comment.cmt + '</p>' +
                                '<a class="btn btn-primary reply-btn" href="#" data-comment-id="' + comment.id + '"><i class="fa fa-reply"></i>Reply</a>' +
                                '<ul class="media-list" id="reply-' + comment.id + '"></ul>' +
                                '</div>' +
                            '</li>';
                            if (comment.level == 0) {
                                $('#comments-list').prepend(commentHtml);
                            } else {
                                $('#reply-' + comment.level).append(commentHtml);
                            }

                            $('#commentForm').find('textarea[name="cmt"]').val('');
                            $('#commentForm').find('input[name="level"]').val('0');
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });

            // Handle the reply button click
            $(document).on('click', '.reply-btn', function(e) {
                e.preventDefault();
                var commentId = $(this).data('comment-id');
                var replyFormHtml = '<form class="replyForm" action="{{ route('blogs.comment') }}" method="POST">' +
                    '@csrf' +
                    '<div class="form-group">' +
                    '<textarea class="form-control" name="cmt" placeholder="Your Reply" rows="3"></textarea>' +
                    '</div>' +
                    '<input type="hidden" name="id_blogs" value="{{ $blogPost->id }}">' +
                    '<input type="hidden" name="level" value="' + commentId + '">' +
                    '<button type="submit" class="btn btn-primary">Submit</button>' +
                    '</form>';

                $('#comment-' + commentId).append(replyFormHtml);
                $(this).hide();
            });

            // Handle the submission of reply forms
            $(document).on('submit', '.replyForm', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();
                var form = $(this);

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            var reply = response.comment;
                            var timeFormatted = new Date(reply.time).toLocaleString();
                            var replyHtml = '<li class="media second-media" id="comment-' + reply.id + '">' +
                                '<a class="pull-left" href="#">' +
                                '<img class="media-object" src="{{ asset('avatars') }}/' + reply.avatar_user + '" alt="' + reply.name_user + '" width="100px">' +
                                '</a>' +
                                '<div class="media-body">' +
                                '<ul class="single-post-meta">' +
                                '<li><i class="fa fa-user"></i>' + reply.name_user + '</li>' +
                                '<li><i class="fa fa-clock-o"></i>' + timeFormatted + '</li>' +
                                '<li><i class="fa fa-calendar"></i>' + timeFormatted + '</li>' +
                                '</ul>' +
                                '<p>' + reply.cmt + '</p>' +
                                '<a class="btn btn-primary reply-btn" href="#" data-comment-id="' + reply.id + '"><i class="fa fa-reply"></i>Reply</a>' +
                                '</div>' +
                                '</li>';

                            $('#reply-' + reply.level).append(replyHtml);
                            form.remove();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });
        });
    </script>
@endsection
