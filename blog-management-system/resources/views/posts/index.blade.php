<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .table-container {
            margin-top: 20px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th {
            text-align: center;
            background-color: #007bff;
            color: white;
        }

        td {
            text-align: center;
            vertical-align: middle;
        }

        img {
            border-radius: 4px;
        }

        .btn {
            margin: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Blog Posts</h1>
        <button id="addPost" class="btn btn-primary">Add New Post</button>
        <input type="text" placeholder="Search" class="form-control" id="search">
        <div id="postsList">
        </div>
        <div id="postModal" style="display:none;">
            <form id="postForm">
                @csrf
                <input type="hidden" name="id" id="postId">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title">
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control" id="content" name="content"></textarea>
                </div>
                <div class="mb-3">
                    <label for="publication_date" class="form-label">Publication Date</label>
                    <input type="date" class="form-control" id="publication_date" name="publication_date">
                </div>
                <div class="mb-3" id="featured_image_div">
                    <label for="featured_image" class="form-label">Featured Image</label>
                    <input type="file" class="form-control" id="featured_image" name="featured_image" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary" id="submitPost">Create Post</button>
                <button type="button" class="btn btn-secondary" id="closeModal">Close</button>
            </form>
        </div>

        <div id="postShowModal" style="display:none;">
            <form id="postForm">

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="showtitle" name="title">
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control" id="showcontent" name="content"></textarea>
                </div>
                <div class="mb-3">
                    <label for="publication_date" class="form-label">Publication Date</label>
                    <input type="date" class="form-control" id="showpublication_date" name="publication_date">
                </div>
                <div class="mb-3" id="showfeatured_image_div">
                    <label for="featured_image" class="form-label">Featured Image</label>
                    <input type="file" class="form-control" id="showfeatured_image" name="featured_image" accept="image/*">
                </div>

            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            postList();
            // Show modal for adding a new post
            $('#addPost').click(function() {
                $("#postShowModal").hide();
                $('#postId').val('');
                $('#title').val('');
                $('#content').val('');
                $('#publication_date').val('');
                $('#featured_image').val('');
                $('#featured_image_div img').remove();
                $(".is-error-message").remove();
                $("form").find('.is-invalid').removeClass('is-invalid');
                $('#postModal').show();
                $('#submitPost').text('Create Post');
            });

            // Close modal
            $('#closeModal').click(function() {
                $('#postModal').hide();
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Submit post (create or update)
            $('#postForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var url = $('#postId').val() ? "{{ route('posts.update','') }}/" + $('#postId').val() : "{{ route('posts.store') }}";
                if ($('#postId').val()) {
                    formData.append("_method", "PATCH");
                }
                var ajaxType = $('#postId').val() ? 'POST' : 'POST';

                $.ajax({
                    url: url,
                    type: ajaxType,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(post) {
                        postList()
                        $('#postModal').hide();
                    },
                    error: function(response) {
                        var errors = response.responseJSON;
                        $(".is-error-message").remove();
                        $("form").find('.is-invalid').removeClass('is-invalid');
                        $.each(errors.errors, function(key, value) {
                            var ele = "#" + key;
                            $(ele).addClass('is-invalid');
                            $('<div class="is-error-message invalid-feedback text-danger">' +
                                    value +
                                    '</div>')
                                .insertAfter(ele);
                        });
                    }
                });
            });

            // Edit post
            $(document).on('click', '.editPost', function() {
                $("#postShowModal").hide();
                $(".is-error-message").remove();
                $("form").find('.is-invalid').removeClass('is-invalid');

                var postId = $(this).data('id');
                var url = "{{ route('posts.show','') }}/" + postId + "/edit";
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(post) {
                        $('#postId').val(post.id);
                        $('#title').val(post.title);
                        $('#content').val(post.content);
                        $('#publication_date').val(post.publication_date);
                        $('#featured_image_div img').remove();
                        $('#featured_image_div').append('<img src="{{ asset("storage/") }}/' + post.featured_image + '" width="100" alt="Featured Image">');
                        $('#postModal').show();
                        $('#submitPost').text('Update Post');
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            });
            // Show post
            $(document).on('click', '.showpost', function() {
                $(".is-error-message").remove();
                $("form").find('.is-invalid').removeClass('is-invalid');

                var postId = $(this).data('id');
                var url = "{{ route('posts.show','') }}/" + postId;
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(post) {
                        $("#postShowModal").show();
                        $('#showtitle').val(post.title);
                        $('#showcontent').val(post.content);
                        $('#showpublication_date').val(post.publication_date);
                        $('#showfeatured_image_div img').remove();
                        $('#showfeatured_image_div').append('<img src="{{ asset("storage/") }}/' + post.featured_image + '" width="100" alt="Featured Image">');
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            });



            // Delete post
            $(document).on('click', '.deletePost', function() {
                var postId = $(this).data('id');
                var url = "{{ route('posts.destroy','') }}/" + postId;
                if (confirm('Are you sure?')) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            postList()
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    });
                }
            });

            $("#search").keyup(function() {
                postList($(this).val());
            })
        });

        function postList(search = "") {
            var url = "{{ route('posts.list') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    search: search
                },
                success: function(resp) {
                    $("#postsList").html(resp);
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }
    </script>

</body>

</html>