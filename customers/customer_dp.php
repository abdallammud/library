<div class="modal fade" data-bs-focus="false" id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="addCustomerLabel" aria-hidden="true">
    <div class="modal-dialog " role="BookStatus" style="max-width:400px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px; " onsubmit="return addCustomer(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookStatusLabel">Add New Customer</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="addNewCustomerForm">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="customerName">Customer name <span class="form-error">This is required</span></label>
                                <input  type="text" placeholder="Required" class="form-control"  id="customerName" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="phoneNumber">Phone Number <span class="form-error">This is required</span></label>
                                <input  type="text" placeholder="Required" class="form-control"  id="phoneNumber" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="email">Email <span class="form-error">This is required</span></label>
                                <input  type="text" placeholder="Optional" class="form-control"  id="email" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="submit" class="mbtn primary cursor" style="width: 100px;">Save</button>
            </div>
        </form>
    </div>
</div>
