<div class="modal fade" data-bs-focus="false" id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="addCustomerLabel" aria-hidden="true">
    <div class="modal-dialog " role="BookStatus" style="max-width:400px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px; " onsubmit="return addCustomer(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookStatusLabel">إضافة عميل جديد  </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="addNewCustomerForm">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="customerName">اسم العميل   <span class="form-error">This is required</span></label>
                                <input  type="text" placeholder="Required" class="form-control"  id="customerName" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="phoneNumber">رقم التليفون   <span class="form-error">This is required</span></label>
                                <input  type="text" placeholder="Required" class="form-control"  id="phoneNumber" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="email">بريد إلكتروني   <span class="form-error">This is required</span></label>
                                <input  type="text" placeholder="Optional" class="form-control"  id="email" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="submit" class="mbtn primary cursor" style="width: 100px;">يحفظ  </button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" data-bs-focus="false" id="editCustomer" tabindex="-1" role="dialog" aria-labelledby="editCustomerLabel" aria-hidden="true">
    <div class="modal-dialog " role="Customer" style="max-width:400px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px; " onsubmit="return editCustomer(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="addCustomerLabel">تحرير العميل  </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="editCustomerForm">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="CustomerName4Edit">اسم العميل   <span class="form-error">This is required</span></label>
                                <input type="hidden" id="customer_id4Edit">
                                <input  type="text" class="form-control"  id="CustomerName4Edit" >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="CustomerPhone4Edit"> رقم التليفون  <span class="form-error">This is required</span></label>
                                <input  type="text"  class="form-control"  id="CustomerPhone4Edit" >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="CustomerEmail4Edit">عنوان البريد الإلكتروني   <span class="form-error">This is required</span></label>
                                <input  type="text"  class="form-control"  id="CustomerEmail4Edit" >
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="slcCustomerStatus">حالة   <span class="form-error">This is required</span></label>
                                <select class="form-control"  id="slcCustomerStatus" >
                                    <option value="active">نشيط  </option>
                                    <option value="inactive">غير نشط</option>
                                    <option value="deleted">يمسح  </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="submit" class="mbtn primary cursor" style="width: 100px;">يحرر  </button>
            </div>
        </form>
    </div>
</div>