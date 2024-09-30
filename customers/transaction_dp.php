<div class="modal fade" data-bs-focus="false" id="addTransaction" tabindex="-1" role="dialog" aria-labelledby="addTransactionLabel" aria-hidden="true">
    <div class="modal-dialog" role="addTransaction" style="max-width:400px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px;" onsubmit="return addTransaction(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="addTransactionLabel"><?php echo $lang['add_new_transaction']; ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="addNewCustomerForm">
                    <div class="row">
                        <div class="col-sm-12 has-search" style="position: relative;">
                            <div class="form-group">
                                <label class="label" for="customerName"><?php echo $lang['customer']; ?> <span class="form-error"><?php echo $lang['required_field']; ?></span></label>
                                <input type="hidden" id="customer_id" name="">
                                <input type="text" placeholder="<?php echo $lang['search_customer']; ?>" class="form-control" id="customerName">
                            </div>
                            <div class="search-result scrollable"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 has-search" style="position: relative;">
                            <div class="form-group">
                                <label class="label" for="book"><?php echo $lang['book']; ?> <span class="form-error"><?php echo $lang['required_field']; ?></span></label>
                                <input type="hidden" id="isbn" name="">
                                <input type="text" placeholder="<?php echo $lang['search_book']; ?>" class="form-control" id="book">
                            </div>
                            <div class="search-result scrollable"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="dueDate"><?php echo $lang['due_date']; ?> <span class="form-error"><?php echo $lang['required_field']; ?></span></label>
                                <input type="text" readonly value="<?php echo date('Y-m-d', strtotime('+30 days')); ?>" class="form-control cursor datepicker" id="dueDate">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="mbtn primary cursor" style="width: 100px;"><?php echo $lang['save']; ?></button>
            </div>
        </form>
    </div>
</div>







<div class="modal fade" data-bs-focus="false" id="editTransactionStatus" tabindex="-1" role="dialog" aria-labelledby="editTransactionStatusLabel" aria-hidden="true">
    <div class="modal-dialog" role="TransactionStatus" style="max-width:400px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px;" onsubmit="return editTransactionStatus(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="addTransactionStatusLabel"><?php echo $lang['change_transaction_status']; ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="addTransactionStatusForm">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="slcTransactionStatus"><?php echo $lang['status']; ?> <span class="form-error"><?php echo $lang['required']; ?></span></label>
                                <input type="hidden" id="transaction_id">
                                <select class="form-control" id="slcTransactionStatus">
                                    <option value="on hold"><?php echo $lang['on_hold']; ?></option>
                                    <option value="returned"><?php echo $lang['returned']; ?></option>
                                    <option value="deleted"><?php echo $lang['deleted']; ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 slcReturnDateDiv hidden">
                            <div class="form-group">
                                <label class="label" for="slcReturnDate"><?php echo $lang['return_date']; ?> <span class="form-error"><?php echo $lang['required']; ?></span></label>
                                <input class="form-control cursor datepicker" readonly value="<?= date('Y-m-d'); ?>" id="slcReturnDate" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="mbtn primary cursor" style="width: 100px;"><?php echo $lang['apply']; ?></button>
            </div>
        </form>
    </div>
</div>

