<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="commonModalLabel">Edit category</h4>
        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body dark-modal">
        <div class="card-body">

            <form id="" class="row g-3 needs-validation custom-input" action="{{ route('categories.update', $category->id) }}" method="post" autocomplete="off" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="col-md-12 position-relative">
                    <label class="form-label" for="name">Name:</label>
                    <input class="form-control" type="text" name="name" id="name" value="{{ $category->name }}" placeholder="name" >
                </div>

                <div class="modal-footer">
                    <button id="saveButton" class="btn btn-primary" type="submit">Save</button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>


