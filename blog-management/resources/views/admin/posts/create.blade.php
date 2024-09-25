<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="commonModalLabel">Add post</h4>
        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body dark-modal">
        <div class="card-body">
            <form id="AddUser" class="row g-3 needs-validation custom-input" action="{{ route('posts.store') }}" method="post" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="col-md-6 position-relative">
                    <label class="form-label" for="title">Title:</label>
                    <input class="form-control" type="text" name="title" id="title" placeholder="Title">
                </div>
                <div class="col-md-6 position-relative">
                    <label class="form-label" for="publication_date">Publication Date:</label>
                    <input class="form-control" type="date" name="publication_date" id="publication_date">
                </div>

                <div class="col-md-6 position-relative">
                    <label for="category_id">Category:</label>
                    <select class="form-control" name="category_id" id="category_id" >
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 position-relative">
                    <label class="form-label" for="content">Content:</label>
                    <textarea class="form-control" name="content" id="content" placeholder="Content" rows="4"></textarea>
                </div>

                <div class="col-md- position-relative">
                    <label class="form-label" for="featured_image">Featured Image:</label>
                    <input class="form-control" id="featured_image" name="featured_image" type="file" accept="image/*">
                </div>


                <div class="modal-footer">
                    <button id="saveButton" class="btn btn-primary" type="submit">Save</button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>