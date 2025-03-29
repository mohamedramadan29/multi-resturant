<div class="text-left modal fade" id="delete_categories_{{ $category->id }}" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel10" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger white">
                <h5 class="modal-title" id="exampleModalLabel"> سيتم حذف القسم وكل المنتجات بداخلة ، هل انت متاكد ؟
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('dashboard.categories.destroy',$category['id']) }}" method="post">
                @csrf
                <div class="modal-body">
                    <label for=""> اسم القسم </label>
                    <input type="text" name="name" class="form-control" disabled readonly
                        value="{{ $category['name'] }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> رجوع</button>
                    <button type="submit" class="btn btn-outline-danger">حذف</button>
                </div>
            </form>
        </div>
    </div>
</div>
