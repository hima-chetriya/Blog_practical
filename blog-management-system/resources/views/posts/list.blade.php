<div class="container table-container">
    <h2 class="text-center mb-4">Post List</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Content Snippet</th>
                <th>Publication Date</th>
                <th>Featured Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ Str::limit($post->content, 100) }}</td>
                    <td>{{ $post->publication_date }}</td>
                    <td>
                        @if($post->featured_image)
                            <img src="{{ asset('storage/' . $post->featured_image) }}" width="100" alt="Featured Image">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                    <button class="btn btn-warning showpost" data-id="{{ $post->id }}">Show</button>
                        <button class="btn btn-warning editPost" data-id="{{ $post->id }}">Edit</button>
                        <button class="btn btn-danger deletePost" data-id="{{ $post->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

