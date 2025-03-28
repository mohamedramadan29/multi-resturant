<!-- Modal -->
<div class="text-left modal fade" id="checkout_invoice_{{ $invoice->id }}" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel10" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info white">
                <h4 class="modal-title white" id="myModalLabel10">
                    استلام الجهاز </h4>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5> هل انت متاكد من استلام الفاتورة </h5>

                <form action="{{ route('dashboard.tech_invoices.checkout', $invoice->id) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label> تاريخ التسليم </label>
                        <input type="text" disabled class="form-control" name="name"
                            value="{{ $invoice->date_delivery }}">
                    </div>
                    <div class="form-group">
                        <label> وقت التسليم </label>
                        <input type="text" disabled class="form-control" name="name"
                            value="{{ $invoice->time_delivery }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">رجوع
                        </button>
                        <button type="submit" class="btn btn-info"> بدء العمل </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
