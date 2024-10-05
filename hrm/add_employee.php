<!-- Modal -->
<div class="modal fade" id="addEmployee" tabindex="-1" role="dialog" aria-labelledby="addEmployeeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 800px;">
        <form class="modal-content" onsubmit="return saveEmployee(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeLabel"><?php echo $lang['add_employee']; ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="addEmployeeForm">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="form-group">
                                <label class="label" for="fullName"><?php echo $lang['full_name']; ?> <span class="form-error"><?php echo $lang['required']; ?></span></label>
                                <input type="text" placeholder="<?php echo $lang['required']; ?>" class="form-control" id="fullName">
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="label" for="phone"><?php echo $lang['phone']; ?> <span class="form-error"><?php echo $lang['required']; ?></span></label>
                                <input type="text" placeholder="<?php echo $lang['required']; ?>" class="form-control" id="phone">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="label" for="email"><?php echo $lang['email']; ?> <span class="form-error"><?php echo $lang['required']; ?></span></label>
                                <input type="email" placeholder="<?php echo $lang['optional']; ?>" class="form-control" id="email" aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="label" for="slcRole"><?php echo $lang['role']; ?> <span class="form-error"><?php echo $lang['required']; ?></span></label>
                                <select style="height: 2rem;" class="form-control" id="slcRole">
                                    <option value="<?=$lang['is_admin'];?>"><?=$lang['is_admin'];?></option>
                                    <option value="<?=$lang['is_user'];?>"><?=$lang['is_user'];?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group flex wrap">
                                <label class="label full-flex" for="userActions"><?php echo $lang['actions']; ?> <span class="form-error"><?php echo $lang['required']; ?></span></label>
                                <select class="form-control full sumoselect" multiple="" id="userActions">
                                    <option value="create"><?php echo $lang['create']; ?></option>
                                    <option value="update"><?php echo $lang['update']; ?></option>
                                    <option value="delete"><?php echo $lang['delete']; ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="label" for="username"><?php echo $lang['username']; ?> <span class="form-error"><?php echo $lang['required']; ?></span></label>
                                <input type="text" placeholder="<?php echo $lang['required']; ?>" class="form-control" id="username">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="label" for="password"><?php echo $lang['password']; ?> <span class="form-error"><?php echo $lang['required']; ?></span></label>
                                <input type="password" class="form-control" id="password">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group flex wrap">
                                <label class="label full-flex" for="userPrivileges"><?php echo $lang['privileges']; ?> <span class="form-error"><?php echo $lang['required']; ?></span></label>
                                <select class="form-control full sumoselect" multiple="" id="userPrivileges">
                                    <option value="Dashboard"><?php echo $lang['dashboard']; ?></option>
                                    <option value="Books"><?php echo $lang['books']; ?></option>
                                    <option value="Categories"><?php echo $lang['categories']; ?></option>
                                    <option value="Customers"><?php echo $lang['customers']; ?></option>
                                    <option value="Transactions"><?php echo $lang['transactions']; ?></option>
                                    <option value="Reports"><?php echo $lang['reports']; ?></option>
                                    <option value="Users"><?php echo $lang['users']; ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="mbtn cursor primary" style="width: 100px;"><?php echo $lang['save']; ?></button>
            </div>
        </form>
    </div>
</div>


<!-- EditModal -->
<div class="modal fade" id="editEmployee" tabindex="-1" role="dialog" aria-labelledby="editEmployeeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 800px;">
        <form class="modal-content" onsubmit="return editEmployee(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmployeeLabel"><?php echo $lang['edit_employee']; ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="editEmployeeForm">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label class="label" for="fullNameEdit"><?php echo $lang['full_name']; ?> <span class="form-error"><?php echo $lang['required']; ?></span></label>
                                <input type="hidden" id="user_id">
                                <input type="text" class="form-control" id="fullNameEdit">
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label class="label" for="phoneEdit"><?php echo $lang['phone']; ?> <span class="form-error"><?php echo $lang['required']; ?></span></label>
                                <input type="text" class="form-control" id="phoneEdit">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label class="label" for="emailEdit"><?php echo $lang['email']; ?> <span class="form-error"><?php echo $lang['required']; ?></span></label>
                                <input type="email" class="form-control" id="emailEdit" aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label class="label" for="slcRoleEdit"><?php echo $lang['role']; ?> <span class="form-error"><?php echo $lang['required']; ?></span></label>
                                <select style="height:2rem" class="form-control" id="slcRoleEdit">
                                    <option value="Admin"><?php echo $lang['is_admin']; ?></option>
                                    <option value="User"><?php echo $lang['is_user']; ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group flex wrap">
                                <label class="label full-flex" for="userActions4Edit"><?php echo $lang['actions']; ?> <span class="form-error"><?php echo $lang['required']; ?></span></label>
                                <select class="form-control full sumoselect" multiple="" id="userActions4Edit">
                                    <option value="create"><?php echo $lang['create']; ?></option>
                                    <option value="update"><?php echo $lang['update']; ?></option>
                                    <option value="delete"><?php echo $lang['delete']; ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group flex wrap">
                                <label class="label full-flex" for="userPrivileges4Edit"><?php echo $lang['privileges']; ?> <span class="form-error"><?php echo $lang['required']; ?></span></label>
                                <select class="form-control full sumoselect" multiple="" id="userPrivileges4Edit">
                                    <option value="Dashboard"><?php echo $lang['dashboard']; ?></option>
                                    <option value="Books"><?php echo $lang['books']; ?></option>
                                    <option value="Categories"><?php echo $lang['categories']; ?></option>
                                    <option value="Customers"><?php echo $lang['customers']; ?></option>
                                    <option value="Transactions"><?php echo $lang['transactions']; ?></option>
                                    <option value="Reports"><?php echo $lang['reports']; ?></option>
                                    <option value="Users"><?php echo $lang['users']; ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="label" for="slcStatus4Edit"><?php echo $lang['status']; ?> <span class="form-error"><?php echo $lang['required']; ?></span></label>
                                <select style="height:2rem" class="form-control" id="slcStatus4Edit">
                                    <option value="Active"><?php echo $lang['active']; ?></option>
                                    <option value="Deleted"><?php echo $lang['deleted']; ?></option>
                                    <option value="Suspended"><?php echo $lang['suspended']; ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" style="width: 100px;" class="mbtn cursor primary"><?php echo $lang['edit']; ?></button>
            </div>
        </form>
    </div>
</div>


