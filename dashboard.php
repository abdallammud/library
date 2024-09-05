<div class=" mcon">
	<div class="dashboard  ">
        <div class="flex center-items space-bw">
            <div style="border-radius:10px;" class="welcome mcon theme-bg full-flex pd-a-10 mr-b-20 flex wrap">
                <h4 class="bold full-flex"><span class=""><?=$_SESSION['fullName'];?> </span>, Welcome back</h4>
                <span class="small text-muted">Monitoring dashboard</span>
            </div>
            
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 py-2">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="dash-card borrowed-books rounded py-3">
                                <div class="flex center-items">
                                    <div class="left">
                                        <div class="visit-change card-icon flex center-items">
                                            <span class="bi  bi-book"></span>
                                        </div>
                                    </div>
                                    <div class="right flex wrap">
                                        <p class="full-flex spacing-0 ">Borrowed Books</p>
                                        <h3 class="spacing-0 value bold">6224</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mr-t-10">
                        <div class="col-sm-12">
                            <div class="dash-card over-due-books rounded py-3">
                                <div class="flex center-items">
                                    <div class="left">
                                        <div class="visit-change card-icon flex center-items">
                                            <span class="bi  bi-clock"></span>
                                        </div>
                                    </div>
                                    <div class="right flex wrap">
                                        <p class="full-flex spacing-0 ">Overdue Books</p>
                                        <h3 class="spacing-0 bold">6224</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mr-t-10">
                        <div class="col-sm-12">
                            <div class="dash-card over-due-books all-books rounded py-3">
                                <div class="flex center-items">
                                    <div class="left">
                                        <div class="visit-change card-icon flex center-items">
                                            <span class="bi  bi-bookshelf"></span>
                                        </div>
                                    </div>
                                    <div class="right flex wrap">
                                        <p class="full-flex spacing-0 ">All Books</p>
                                        <h3 class="spacing-0 bold">6224</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mr-t-10">
                        <div class="col-sm-12">
                            <div class="dash-card over-due-books all-customers rounded py-3">
                                <div class="flex center-items">
                                    <div class="left">
                                        <div class="visit-change card-icon flex center-items">
                                            <span class="bi  bi-people"></span>
                                        </div>
                                    </div>
                                    <div class="right flex wrap">
                                        <p class="full-flex spacing-0 ">All Customers</p>
                                        <h3 class="spacing-0 bold">6224</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 py-2" >
                    <div class="">
                        <div class="barChart theme-bg chart large">
                            <p class="bold title">Borrowing Statistics</p>
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mr-t-10">
                <div class="col-lg-12 py-2">
                    <div class="theme-bg rounded py-2 px-2">
                        <p class="bold title">Overdue Books</p>
                        <table style="width: 100%;" class="table mfs-8  mcon mfs-9 table-striped " id="overdueBooksTable"></table>
                    </div>
                </div>
            </div>
        </div>

        
    </div>
</div>
<script>
    addEventListener("DOMContentLoaded", (event) => {
        dashboard();
    });
</script>