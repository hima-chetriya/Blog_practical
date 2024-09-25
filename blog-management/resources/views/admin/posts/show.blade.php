<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="commonModalLabel">Post detail</h4>
        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body dark-modal">
        <div class="card-body">

                <div class="col-md-6 position-relative">
                    <label class="form-label" for="title">Title:</label>
                    {{ $post->title }}
                </div>

                <div class="col-md-12 position-relative">
                    <label class="form-label" for="content">Content:</label>
                   {{ $post->content }}
                </div>
                <div class="col-md-6 position-relative">
                    <label class="form-label" for="publication_date">Publication Date:</label>
                   {{ $post->publication_date }}
                </div>
                <div class="col-md-6 position-relative">
                    <label class="form-label" for="featured_image">Featured Image:</label>
                </div>

                <div class="col-md-12 position-relative">
                    @if($post->featured_image)
                    <label>Current Image:</label>
                    <a href="{{ asset('all_image/posts/' . $post->featured_image) }}" target="_blank">
                        <img src="{{ asset('all_image/posts/' . $post->featured_image) }}" name="old_img" height="100" width="100" alt="Current Image">
                    </a>
                    @endif
                </div>

        </div>
    </div>
</div>


