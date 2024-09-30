<div class="modal fade" data-bs-focus="false" id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="addCustomerLabel" aria-hidden="true">
    <div class="modal-dialog" role="BookStatus" style="max-width:400px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px;" onsubmit="return addCustomer(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookStatusLabel"><?=$lang['add_customer_new'];?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="addNewCustomerForm">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="customerName"><?=$lang['customer_name'];?> <span class="form-error"><?=$lang['required_field'];?></span></label>
                                <input type="text" placeholder="<?=$lang['required'];?>" class="form-control" id="customerName">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="phoneNumber"><?=$lang['phone_number'];?> <span class="form-error"><?=$lang['required_field'];?></span></label>
                                <input type="text" placeholder="<?=$lang['required'];?>" class="form-control" id="phoneNumber">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="email"><?=$lang['email'];?> <span class="form-error"><?=$lang['optional_field'];?></span></label>
                                <input type="text" placeholder="<?=$lang['optional_field'];?>" class="form-control" id="email">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="mbtn primary cursor" style="width: 100px;"><?=$lang['save'];?></button>
            </div>
        </form>
    </div>
</div>



<div class="modal fade" data-bs-focus="false" id="editCustomer" tabindex="-1" role="dialog" aria-labelledby="editCustomerLabel" aria-hidden="true">
    <div class="modal-dialog" role="Customer" style="max-width:400px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px;" onsubmit="return editCustomer(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="addCustomerLabel"><?=$lang['edit_customer'];?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="editCustomerForm">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="CustomerName4Edit"><?=$lang['customer_name'];?> <span class="form-error"><?=$lang['required_field'];?></span></label>
                                <input type="hidden" id="customer_id4Edit">
                                <input type="text" class="form-control" id="CustomerName4Edit">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="CustomerPhone4Edit"><?=$lang['phone_number'];?> <span class="form-error"><?=$lang['required_field'];?></span></label>
                                <input type="text" class="form-control" id="CustomerPhone4Edit">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="CustomerEmail4Edit"><?=$lang['email'];?> <span class="form-error"><?=$lang['required_field'];?></span></label>
                                <input type="text" class="form-control" id="CustomerEmail4Edit">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="slcCustomerStatus"><?=$lang['status'];?> <span class="form-error"><?=$lang['required_field'];?></span></label>
                                <select class="form-control" id="slcCustomerStatus">
                                    <option value="active"><?=$lang['active'];?></option>
                                    <option value="inactive"><?=$lang['inactive'];?></option>
                                    <option value="deleted"><?=$lang['deleted'];?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="mbtn primary cursor" style="width: 100px;"><?=$lang['save'];?></button>
            </div>
        </form>
    </div>
</div>
