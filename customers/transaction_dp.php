<div class="modal fade"  data-bs-focus="false" id="addTransaction" tabindex="-1" role="dialog" aria-labelledby="addTransactionLabel" aria-hidden="true">
    <div class="modal-dialog " role="addTransaction" style="max-width:400px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px; " onsubmit="return addTransaction(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="addTransactionLabel">Add New Transaction</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<div id="addNewCustomerForm">
                    <div class="row">
                        <div class="col-sm-12 has-search" style="position: relative;">
                            <div class="form-group">
                                <label class="label" for="customerName">Customer <span class="form-error">This is required</span></label>
                                <input type="hidden" id="customer_id" name="">
                                <input  type="text" placeholder="Search customer" class="form-control"  id="customerName" >
                            </div>
                            <div class="search-result scrollable">
                            	<!-- <p class="empty-result">No items found</p> -->
                            	<!-- <div class="result-item">
                            		<p class="">
                            			<span class="title">Name:</span>
                            			<span class="val">Ahmed Ali</span>
                            		</p>
                            		<p class="">
                            			<span class="title">Phone:</span>
                            			<span class="val">05158245</span>
                            		</p>
                            	</div> -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 has-search" style="position: relative;">
                            <div class="form-group">
                                <label class="label" for="book">Book <span class="form-error">This is required</span></label>
                                <input type="hidden" id="isbn" name="">
                                <input  type="text" placeholder="Search Book" class="form-control"  id="book" >
                            </div>
                            <div class="search-result scrollable">
                            	<!-- <p class="empty-result">No items found</p> -->
                            	<!-- <div class="result-item">
                            		<p class="">
                            			<span class="title">Name:</span>
                            			<span class="val">Ahmed Ali</span>
                            		</p>
                            		<p class="">
                            			<span class="title">Phone:</span>
                            			<span class="val">05158245</span>
                            		</p>
                            	</div> -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="dueDate">Due date <span class="form-error">This is required</span></label>
                                <input  type="text" readonly value="<?php echo date("Y-m-d", strtotime("+30 days")); ?>" class="form-control cursor datepicker"  id="dueDate" >
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






<div class="modal fade" data-bs-focus="false" id="editTransactionStatus" tabindex="-1" role="dialog" aria-labelledby="editTransactionStatusLabel" aria-hidden="true">
    <div class="modal-dialog " role="TransactionStatus" style="max-width:400px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px; " onsubmit="return editTransactionStatus(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="addTransactionStatusLabel">Change Transaction Status</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="addTransactionStatusForm">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="slcTransactionStatus">Status <span class="form-error">This is required</span></label>
                                <input type="hidden" id="transaction_id">
                                <select class="form-control"  id="slcTransactionStatus" >
                                    <option value="on hold">On Hold</option>
                                    <option value="returned">Return</option>
                                    <option value="deleted">Delete</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 slcReturnDateDiv hidden">
                            <div class="form-group">
                                <label class="label" for="slcReturnDate">Return date <span class="form-error">This is required</span></label>
                                <input class="form-control cursor datepicker" readonly value="<?=date('Y-m-d');?>" id="slcReturnDate" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="submit" class="mbtn primary cursor" style="width: 100px;">Apply</button>
            </div>
        </form>
    </div>
</div>
