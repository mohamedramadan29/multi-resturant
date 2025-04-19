<div class="text-left modal fade" id="delete_shipping_{{ $area->id }}" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel10" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger white">
                <h5 class="modal-title" id="exampleModalLabel"> هل انت متاكد من حذف المنطقة
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('dashboard.shipping.destroy',$area['id']) }}" method="post">
                @csrf
                <div class="modal-body">
                    <label for=""> اسم المنطقة </label>
                    <input type="text" name="name" class="form-control" disabled readonly
                        value="{{ $area['area'] }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> رجوع</button>
                    <button type="submit" class="btn btn-outline-danger">حذف</button>
                </div>
            </form>
        </div>
    </div>
</div>
