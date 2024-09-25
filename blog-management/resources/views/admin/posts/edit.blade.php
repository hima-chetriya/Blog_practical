<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="commonModalLabel">Edit post</h4>
        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body dark-modal">
        <div class="card-body">

            <form id="AddUser" class="row g-3 needs-validation custom-input" action="{{ route('posts.update', $post->id) }}" method="post" autocomplete="off" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="col-md-6 position-relative">
                    <label class="form-label" for="title">Title:</label>
                    <input class="form-control" type="text" name="title" id="title" value="{{ $post->title }}" placeholder="Title">
                </div>

                <div class="col-md-6 position-relative">
                    <label for="category_id">Category:</label>
                    <select class="form-control" name="category_id" id="category_id" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $post->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 position-relative">
                    <label class="form-label" for="publication_date">Publication Date:</label>
                    <input class="form-control" type="date" name="publication_date" id="publication_date" value="{{ $post->publication_date }}">
                </div>

                <div class="col-md-6 position-relative">
                    <label class="form-label" for="content">Content:</label>
                    <textarea class="form-control" name="content" id="content" placeholder="Content" rows="4">{{ $post->content }}</textarea>
                </div>

                <div class="col-md-12 position-relative">
                    <label class="form-label" for="featured_image">Featured Image:</label>
                    <input class="form-control" id="featured_image" name="featured_image" type="file" accept="image/*">
                </div>

              

                <div class="col-md-12 position-relative">
                    @if($post->featured_image)
                    <label>Current Image:</label>
                    <a href="{{ asset('all_image/posts/' . $post->featured_image) }}" target="_blank">
                        <img src="{{ asset('all_image/posts/' . $post->featured_image) }}" name="old_img" height="100" width="100" alt="Current Image">
                    </a>
                    @endif
                </div>

                <div class="modal-footer">
                    <button id="saveButton" class="btn btn-primary" type="submit">Save</button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>