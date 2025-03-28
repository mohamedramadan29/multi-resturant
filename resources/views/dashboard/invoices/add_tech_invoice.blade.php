<!-- Modal -->
<div class="text-left modal fade" id="add_tech_invoice_{{ $invoice->id }}" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel10" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info white">
                <h4 class="modal-title white" id="myModalLabel10">
                    تعين فني الي الفاتورة </h4>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.invoices.add_tech', $invoice->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label> حدد الفني </label>
                        <select name="admin_repair_id" id="" class="form-control">
                            <option value="" select disabled> -- حدد الفني -- </option>
                            @foreach ($techs as $tech)
                                <option value="{{ $tech->id }}"> {{ $tech->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary btn-sm" data-dismiss="modal">رجوع
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm"> تعين الفني </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
