<!-- Modal -->
<div class="text-left modal fade" id="delete_admin_{{ $admin->id }}" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel10" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger white">
                <h4 class="modal-title white" id="myModalLabel10">
                    حذف الموظف </h4>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5> هل انت متاكد من حذف الموظف </h5>

                <form action="{{ route('dashboard.admins.destroy', $admin->id) }}" method="POST">
                    @csrf
                    <div>
                        <label> الاسم </label>
                        <input type="text" disabled class="form-control" name="name" value="{{ $admin->name }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">رجوع
                        </button>
                        <button type="submit" class="btn btn-outline-danger"> حذف </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
