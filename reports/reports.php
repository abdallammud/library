<div class=" mcon">
	<form method="POST" onsubmit="return displayReport(this)" class="  ">
        <div class="flex center-items space-bw">
            <div style="border-radius:5px;" class="welcome mcon theme-bg full-flex pd-a-10 mr-b-20 flex wrap">
                <!-- Reports and filters -->
                <div class="row full-flex ">
                    <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                            <label class="label" name="slcReport" for="slcReport">Reports</label>
                            <select class="form-control"  id="slcReport" >
                                <option value="">-- Select report</option>
                                <option value="allBooks">All Books</option>
                                <option value="allCustomers">All Customers</option>
                                <option value="bookTransactions">Book Transactions</option>
                                <option value="customerTransactions">Customer Transactions</option>
                                <option value="booksCheckedout">Books Checked Out</option>
                                <option value="overdueBooks">Overdue Books</option>
                                <option value="returnedBooks">Returned Books</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 filter customerFilter hidden">
                        <div class="form-group" style="display: flex; flex-wrap: wrap;">
                            <label style="flex-basis: 100%;" class="label" for="slcReport">Customer</label>
                            <select class="my-select searchCustomer" name="searchCustomer" id="searchCustomer" data-live-search="true" title="Search and select a customer...">
								<?php 
									$get_customer = "SELECT * FROM `customers` WHERE `membership_status` <> 'deleted' LIMIT 10";
								    $customerSet = $GLOBALS['conn']->query($get_customer);
								    if($customerSet->num_rows > 0) {
									    while($row = $customerSet->fetch_assoc()) {
									    	$id 			= $row['id'];
									    	$phone_number 	= $row['phone_number'];
									    	$name 			= $row['name'];
									    	$email 			= $row['email'];

									    	echo '<option value="'.$id.'">'.$name.', '.$phone_number.'</option>';
									    }
									}


								?>
							</select>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 filter bookFilter hidden">
                        <div class="form-group" style="display: flex; flex-wrap: wrap;">
                            <label style="flex-basis: 100%;" class="label" for="slcReport">Book</label>
                            <select name="" class="my-select searchBook" id="searchBook" data-live-search="true" title="Search and select a book...">
								<?php 
									$get_books = "SELECT * FROM `books` WHERE `status` <> 'deleted' LIMIT 10";
								    $booksSet = $GLOBALS['conn']->query($get_books);
								    if($booksSet->num_rows > 0) {
									    while($row = $booksSet->fetch_assoc()) {
									    	$book_id = $row['book_id'];
									    	$isbn 	= $row['isbn'];
									    	$title 	= $row['title'];

									    	echo '<option value="'.$isbn.'">'.$title.', '.$isbn.'</option>';
									    }
									}


								?>
							</select>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 filter dateFilter hidden">
                    	<div class="row">
                    		<div class="col-sm-6">
                    			<div class="form-group">
		                            <label class="label" for="slcStartDate">Date</label>
		                            <input name="" class="form-control cursor datepicker" readonly value="<?=date('Y-m-d');?>" id="slcStartDate" />
		                        </div>
                    		</div>
                    		<div class="col-sm-6">
                    			<div class="form-group">
		                            <label class="label" for="slcEndDate">&nbsp;</label>
		                            <input name="" class="form-control cursor datepicker" readonly value="<?=date('Y-m-d');?>" id="slcEndDate" />
		                        </div>
                    		</div>
                    	</div>
                        
                    </div>

                    <div class="col-md-6 col-lg-1">
                        <div class="form-group">
                            <label class="label" for="slcReport">&nbsp;</label>
                            <button type="submit" class="mbtn cursor primary">Show</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-content">
        	<div class="reportHeader">
				
			</div>
			<div class="tableHolder">
				
			</div>
		</div>
    </form>
</div>


<style type="text/css">
	select.form-control:not([size]):not([multiple]) {
	    height: calc(2.1rem);
	}
	.bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
		width: 100% !important;
	}

	.bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) * {
		font-size: 14px !important;
	}
	.mbtn {
		padding: 7px 20px !important;
	}
</style>

<script type="text/javascript">
	

    addEventListener("DOMContentLoaded", (event) => {
	    $(document).ready(function() {
	      	$('.my-select').selectpicker();
	    });

	    $(document).on('keyup', '.bootstrap-select.searchCustomer input.form-control', (e) => {
	    	let search = $(e.target).val();
	    	let forReport = 'Yes';
            $.post("./incs/main.php?action=search&search=customer", {search:search, forReport:forReport}, function(data) {
				let res = JSON.parse(data)
				if(!res.error) {
					$('#searchCustomer').html(res.options)
					 $('.my-select').selectpicker('refresh');
				} 
				// console.log(data)
			});
	    })

	    $(document).on('keyup', '.bootstrap-select.searchBook input.form-control', (e) => {
	    	let search = $(e.target).val();
	    	let forReport = 'Yes';
            $.post("./incs/main.php?action=search&search=book", {search:search, forReport:forReport}, function(data) {
				let res = JSON.parse(data)
				if(!res.error) {
					$('#searchBook').html(res.options)
					 $('.my-select').selectpicker('refresh');
				} 
				// console.log(data)
			});
	    })

	    $("#searchCustomer").on("changed.bs.select", 
		    function(e, clickedIndex, newValue, oldValue) {
		    	console.log(this.value, clickedIndex, newValue, oldValue)
			}
		);

		$('#slcReport').on('change', (e) => {
			let report = $(e.target).val();
			$('.filter').addClass('hidden')
			if(report == 'bookTransactions') {
				$('.filter.bookFilter').removeClass('hidden');
				$('.filter.dateFilter').removeClass('hidden');
			} 

			if(report == 'customerTransactions') {
				$('.filter.customerFilter').removeClass('hidden');
				$('.filter.dateFilter').removeClass('hidden');
			} 

			if(report == 'booksCheckedout' || report == 'returnedBooks') {
				$('.filter.dateFilter').removeClass('hidden');
			} 
		})

		
	});

	function updateReportHeader(report) {
	    // Get the div with class 'reportHeader'
	    const reportHeaderDiv = document.querySelector('.reportHeader');
	    
	    // Initialize an empty string to hold the HTML content
	    let htmlContent = '';

	    // Check if each key exists and append the corresponding HTML
	    if (report.title) {
	        htmlContent += `
	            <p class="center-items flex justify-center wrap mr-b-20 mr-t-10 mfs-8 wrap">
	                <span class="bold full-flex text-center">${report.title}</span>
	                ${report.dates ? `<span class="full-flex text-center">Between ${report.dates}</span>` : ''}

	                ${report.details ? `<span class="full-flex text-center"> ${report.details}</span>` : ''}
	            </p>
	        `;
	    }

	    if (report.href) {
	        htmlContent += `
	        <p report.href class="flex justify-end">
				<a target="_blank" href="${report.href}" class="bi  mfs-1-5 mr-r-20 bi-printer"></a>
			</p>`;
	    }
	    
	    // Set the HTML content of the reportHeaderDiv
	    reportHeaderDiv.innerHTML = htmlContent || '<p class="error">No report data available.</p>';
	}

	function displayReport(form) {
		let report = $('#slcReport').val();
		if(!report) {
			swal('Nothing to show', 'Please select a report', 'error')
			return false;
		}

		let searchCustomer 	= $('#searchCustomer').val();
		let searchBook 		= $('#searchBook').val();
		let searchBookTxt 	= $('#searchBook option:selected').text();
		let searchCustomerTxt 	= $('#searchCustomer option:selected').text();
		let startDate 		= $('#slcStartDate').val();
		let endDate 		= $('#slcEndDate').val();

		let dates = formatDateRange(startDate, endDate);

		let reportTitle = reportHref = details = '';

		/*let dataTable = new DataTable('#reportDataTable');
		dataTable.destroy();*/
		$('#reportDataTable').html('')
		$('#reportDataTable thead').remove()

		if(report == 'allBooks') {
			reportTitle = 'All Books Report';
			dates = '';
			reportHref = `./print.php?report=books`

			let table = `<table style="width: 100%;" class="table mfs-8  mcon mfs-9 table-striped " id="reportDataTable"></table>`

			$('.tableHolder').html(table)

			let datatable = new DataTable('#reportDataTable', {
				"processing": true,
				"serverSide": true,
				"bDestroy": true,
				"columnDefs": [
					{ "orderable": false, "targets": [] }  // Disable search on first and last columns
				],
				// "paging": false,
				"serverMethod": 'post',
				"ajax": {
					"url": "./incs/main.php?action=report&report=books",
					"method":"POST",
					"data": {
			            
		            },
					// dataFilter: function(data) {
					// 	console.log(data)
					// },
				}, 

				"language": {
		            "emptyTable": "No books found matching your filters." // Custom message for empty data
		        },
		        "drawCallback": function(settings) {
		            var api = this.api();
		            var emptyRow = $(api.table().body()).find('.dataTables_empty');
		            if (emptyRow.length > 0) {
		                emptyRow.html("No books found matching your filters."); // Customize the message
		            }
		        },
				columns: [
			        {title: "Title", data: null, render: function(data, type, row) {
			            return `<div>
			            		<span>${row.title}</span>
				            </div>`;
			        }},

			        {title: "ISBN ", data: null, render: function(data, type, row) {
			            return `<div>
			            		<span>${row.isbn}</span>
			            	</div>`;
			        }},

			        {title: "Author", data: null, render: function(data, type, row) {
			            return `<div>
			            		<span>${row.author}</span>
			            	</div>`;
			        }},

			        {title: "Published", data: null, render: function(data, type, row) {
			            return `<div>
			            		<span>${row.published_year}</span>
			            	</div>`;
			        }},

			        {title: "Category", data: null, render: function(data, type, row) {
			            return `<div>
			            		<span>${row.category}</span>
			            	</div>`;
			        }},

			        {title: "Status", data: null, render: function(data, type, row) {
			             return `<div class="${row.status}">
			            		<span>${row.statusTxt}</span>
			            	</div>`;
			        }},

		        	{title: "Date", data: null, render: function(data, type, row) {
			            return `<div class="flex center-items">
				            	<span>${row.created_at}</span>
				            </div>`;
			        }},
				]
			})
		} 
		else if(report == 'allCustomers') {
			reportTitle = 'All Customers Report';
			dates = '';
			reportHref = `./print.php?report=customers`

			let table = `<table style="width: 100%;" class="table mfs-8  mcon mfs-9 table-striped " id="reportDataTable"></table>`

			$('.tableHolder').html(table)

			let datatable = new DataTable('#reportDataTable', {
				"processing": true,
				"serverSide": true,
				"bDestroy": true,
				// "paging": false,
				"serverMethod": 'post',
				"ajax": {
					"url": "./incs/main.php?action=report&report=customers",
					"method":"POST",
					// dataFilter: function(data) {
					// 	console.log(data)
					// }
				}, 
				columns: [
					{title: "Name", data: null, render: function(data, type, row) {
			            return `<div class="flex center-items">
				            	<span>${row.name}</span>
				            </div>`;
			        }},

			        {title: "Phone", data: null, render: function(data, type, row) {
			            return `<div>${row.phone_number}</div>`;
			        }},

			        {title: "Email", data: null, render: function(data, type, row) {
			            return `<div>${row.email}</div>`;
			        }},

			       	{title: "Status", data: null, render: function(data, type, row) {
			            return `<div>${row.membership_status}</div>`;
			        }},

			        {title: "Date Joined", data: null, render: function(data, type, row) {
			            return `<div>${row.created_at}</div>`;
			        }},

				]
			})
		} 
		else if(report == 'bookTransactions') {
			reportTitle = 'Book Transactions report';
			details = searchBookTxt;
			reportHref = `./print.php?report=book_transactions&startDate=${startDate}&endDate=${endDate}&isbn=${searchBook}&book=${searchBookTxt}`
			showTransactionsReport(startDate, endDate, report, searchBook, false)
		} else if(report == 'customerTransactions') {
			reportTitle = 'Customer Transactions report';
			details = searchCustomerTxt;
			reportHref = `./print.php?report=customer_transactions&startDate=${startDate}&endDate=${endDate}&customer_id=${searchCustomer}&customer=${searchCustomerTxt}`
			showTransactionsReport(startDate, endDate, report, false, searchCustomer)
		} else if(report == 'booksCheckedout') {
			reportTitle = 'Books Checked out report';
			reportHref = `./print.php?report=booksCheckedout&startDate=${startDate}&endDate=${endDate}`
			showTransactionsReport(startDate, endDate, report, false, false)
		} else if(report == 'overdueBooks') {
			reportTitle = 'Overdue Books report';
			dates = '';
			reportHref = `./print.php?report=overdueBooks`
			showTransactionsReport(startDate, endDate, report, false, false)
		} else if(report == 'returnedBooks') {
			reportTitle = 'Returned Books report';
			reportHref = `./print.php?report=returnedBooks&startDate=${startDate}&endDate=${endDate}`
			showTransactionsReport(startDate, endDate, report, false, false)
		}

		function showTransactionsReport(startDate, endDate, report, searchBook = false, searchCustomer = false) {
			let table = `<table style="width: 100%;" class="table mfs-8  mcon mfs-9 table-striped " id="reportDataTable"></table>`

			$('.tableHolder').html(table)
			let datatable = new DataTable('#reportDataTable', {
				"processing": true,
				"serverSide": true,
				"bDestroy": true,
				// "paging": false,
				"serverMethod": 'post',
				"ajax": {
					"url": "./incs/main.php?action=report&report=transactions",
					"method":"POST",
					"data": {
			            "isbn": searchBook,
			            "customer_id": searchCustomer,
			            "startDate": startDate,
			            "endDate": endDate, 
			            "report": report
		            },
					// dataFilter: function(data) {
					// 	console.log(data)
					// }
				}, 
				columns: [
					{title: "Customer", data: null, render: function(data, type, row) {
			            return `<div class="flex center-items">
				            	<span>${row.customer}, ${row.phone_number}</span>
				            </div>`;
			        }},

			        {title: "Book", data: null, render: function(data, type, row) {
			            return `<div>${row.title}, ${row.isbn}</div>`;
			        }},

			        {title: "Borrow Date", data: null, render: function(data, type, row) {
			            return `<div>${row.borrow_date}</div>`;
			        }},

			       	{title: "Status", data: null, render: function(data, type, row) {
			            return `<div>
			            		${row.statusTxt}
			            	</div>`;
			        }},

			        {title: "Due Date", data: null, render: function(data, type, row) {
			            return `<div>${row.due_date}</div>`;
			        }},

			        {title: "Return Date", data: null, render: function(data, type, row) {
			            return `<div>${row.return_date}</div>`;
			        }},

				]
			})
		}

		const reportData = {
		    title: reportTitle,
		    dates: dates,
		    details: details,
		    href: reportHref
		};

		// Call the function to update the reportHeader
		updateReportHeader(reportData);

		return false;
	}
</script>