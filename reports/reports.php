<div class=" mcon">
	<form method="POST" onsubmit="return displayReport(this)" class="  ">
        <div class="flex center-items space-bw">
            <div style="border-radius:5px;" class="welcome mcon theme-bg full-flex pd-a-10 mr-b-20 flex wrap">
                <!-- Reports and filters -->
                <div class="row full-flex ">
                    <div class="col-md-6 col-lg-3">
					    <div class="form-group">
					        <label class="label" name="slcReport" for="slcReport"><?= $lang['report_select_report']; ?></label>
					        <select class="form-control" id="slcReport">
					            <option value=""><?= $lang['report_select_report_option']; ?></option>
					            <option value="allBooks"><?= $lang['report_all_books']; ?></option>
					            <option value="allCustomers"><?= $lang['report_all_customers']; ?></option>
					            <option value="bookTransactions"><?= $lang['report_book_transactions']; ?></option>
					            <option value="customerTransactions"><?= $lang['report_customer_transactions']; ?></option>
					            <option value="booksCheckedout"><?= $lang['report_books_checked_out']; ?></option>
					            <option value="overdueBooks"><?= $lang['report_overdue_books']; ?></option>
					            <option value="returnedBooks"><?= $lang['report_returned_books']; ?></option>
					        </select>
					    </div>
					</div>

					<div class="col-md-6 col-lg-4 filter customerFilter hidden">
					    <div class="form-group" style="display: flex; flex-wrap: wrap;">
					        <label style="flex-basis: 100%;" class="label" for="slcReport"><?= $lang['report_customer']; ?></label>
					        <select class="my-select searchCustomer" name="searchCustomer" id="searchCustomer" data-live-search="true" title="<?= $lang['report_search_customer']; ?>">
					            <?php 
					                $get_customer = "SELECT * FROM `customers` WHERE `membership_status` <> 'deleted' LIMIT 10";
					                $customerSet = $GLOBALS['conn']->query($get_customer);
					                if($customerSet->num_rows > 0) {
					                    while($row = $customerSet->fetch_assoc()) {
					                        $id = $row['id'];
					                        $phone_number = $row['phone_number'];
					                        $name = $row['name'];

					                        echo '<option value="'.$id.'">'.$name.', '.$phone_number.'</option>';
					                    }
					                }
					            ?>
					        </select>
					    </div>
					</div>

					<div class="col-md-6 col-lg-4 filter bookFilter hidden">
					    <div class="form-group" style="display: flex; flex-wrap: wrap;">
					        <label style="flex-basis: 100%;" class="label" for="slcReport"><?= $lang['report_book']; ?></label>
					        <select name="" class="my-select searchBook" id="searchBook" data-live-search="true" title="<?= $lang['report_search_book']; ?>">
					            <?php 
					                $get_books = "SELECT * FROM `books` WHERE `status` <> 'deleted' LIMIT 10";
					                $booksSet = $GLOBALS['conn']->query($get_books);
					                if($booksSet->num_rows > 0) {
					                    while($row = $booksSet->fetch_assoc()) {
					                        $isbn = $row['isbn'];
					                        $title = $row['title'];

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
					                <label class="label" for="slcStartDate"><?= $lang['report_start_date']; ?></label>
					                <input name="" class="form-control cursor datepicker" readonly value="<?= date('Y-m-d'); ?>" id="slcStartDate" />
					            </div>
					        </div>
					        <div class="col-sm-6">
					            <div class="form-group">
					                <label class="label" for="slcEndDate"><?= $lang['report_end_date']; ?></label>
					                <input name="" class="form-control cursor datepicker" readonly value="<?= date('Y-m-d'); ?>" id="slcEndDate" />
					            </div>
					        </div>
					    </div>
					</div>

					<div class="col-md-6 col-lg-1">
					    <div class="form-group">
					        <label class="label" for="slcReport">&nbsp;</label>
					        <button type="submit" class="mbtn cursor primary"><?= $lang['report_show']; ?></button>
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
	      	$('.my-select').selectpicker({
			    noneResultsText: lang.report_no_result_found
			});
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
	                ${report.dates ? `<span class="full-flex text-center">${lang.report_between} ${report.dates}</span>` : ''}

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
	    reportHeaderDiv.innerHTML = htmlContent || `<p class="error">${lang.report_no_data_available}</p>`;
	}

	function displayReport(form) {
		let report = $('#slcReport').val();
		if(!report) {
			swal(lang.report_nothing_to_show, lang.report_select_a_report, 'error')
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
			reportTitle = lang.pdf_all_books_report;
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

				
		        "drawCallback": function(settings) {
		            var label = $('#reportDataTable_filter label');
			        label.contents().filter(function() {
			            return this.nodeType === Node.TEXT_NODE;
			        }).replaceWith(lang.search); // Use the language object

			        var label = $('#reportDataTable_length label');
			        var children = label.contents();
			        children.each(function() {
			            if (this.nodeType === Node.TEXT_NODE) {
			                if ($(this).text().trim() === 'Show') {
			                    $(this).replaceWith(lang.show); // Use the language object
			                } else if ($(this).text().trim() === 'entries') {
			                    $(this).replaceWith(lang.entries); // Use the language object
			                }
			            }
			        });

			        $('#reportDataTable_previous a').text(lang.previous); // Use the language object
			        $('#reportDataTable_next a').text(lang.next); // Use the language object
		        },
				columns: [
			        {title: lang.title, data: null, render: function(data, type, row) {
			            return `<div>
			            		<span>${row.title}</span>
				            </div>`;
			        }},

			        {title: lang.isbn, data: null, render: function(data, type, row) {
			            return `<div>
			            		<span>${row.isbn}</span>
			            	</div>`;
			        }},

			        {title: lang.author, data: null, render: function(data, type, row) {
			            return `<div>
			            		<span>${row.author}</span>
			            	</div>`;
			        }},

			        {title: lang.published, data: null, render: function(data, type, row) {
			            return `<div>
			            		<span>${row.published_year}</span>
			            	</div>`;
			        }},

			        {title: lang.category, data: null, render: function(data, type, row) {
			            return `<div>
			            		<span>${row.category}</span>
			            	</div>`;
			        }},

			        {title: lang.status, data: null, render: function(data, type, row) {
			             return `<div class="${row.status}">
			            		<span>${row.statusTxt}</span>
			            	</div>`;
			        }},

		        	{title: lang.date, data: null, render: function(data, type, row) {
			            return `<div class="flex center-items">
				            	<span>${row.created_at}</span>
				            </div>`;
			        }},
				]
			})
		} 
		else if(report == 'allCustomers') {
			reportTitle = lang.pdf_all_customers_report;
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
				"drawCallback": function(settings) {
		            var label = $('#reportDataTable_filter label');
			        label.contents().filter(function() {
			            return this.nodeType === Node.TEXT_NODE;
			        }).replaceWith(lang.search); // Use the language object

			        var label = $('#reportDataTable_length label');
			        var children = label.contents();
			        children.each(function() {
			            if (this.nodeType === Node.TEXT_NODE) {
			                if ($(this).text().trim() === 'Show') {
			                    $(this).replaceWith(lang.show); // Use the language object
			                } else if ($(this).text().trim() === 'entries') {
			                    $(this).replaceWith(lang.entries); // Use the language object
			                }
			            }
			        });

			        $('#reportDataTable_previous a').text(lang.previous); // Use the language object
			        $('#reportDataTable_next a').text(lang.next); // Use the language object
		        },
				columns: [
					{title: lang.name, data: null, render: function(data, type, row) {
			            return `<div class="flex center-items">
				            	<span>${row.name}</span>
				            </div>`;
			        }},

			        {title: lang.phone, data: null, render: function(data, type, row) {
			            return `<div>${row.phone_number}</div>`;
			        }},

			        {title: lang.email, data: null, render: function(data, type, row) {
			            return `<div>${row.email}</div>`;
			        }},

			       	{title: lang.status, data: null, render: function(data, type, row) {
			            return `<div>${row.membership_status}</div>`;
			        }},

			        {title: lang.date, data: null, render: function(data, type, row) {
			            return `<div>${row.created_at}</div>`;
			        }},

				]
			})
		} 
		else if(report == 'bookTransactions') {
			reportTitle = lang.pdf_book_transactions_report;
			details = searchBookTxt;
			reportHref = `./print.php?report=book_transactions&startDate=${startDate}&endDate=${endDate}&isbn=${searchBook}&book=${searchBookTxt}`
			showTransactionsReport(startDate, endDate, report, searchBook, false)
		} 
		else if(report == 'customerTransactions') {
			reportTitle = lang.pdf_customer_transactions_report;
			details = searchCustomerTxt;
			reportHref = `./print.php?report=customer_transactions&startDate=${startDate}&endDate=${endDate}&customer_id=${searchCustomer}&customer=${searchCustomerTxt}`
			showTransactionsReport(startDate, endDate, report, false, searchCustomer)
		} 
		else if(report == 'booksCheckedout') {
			reportTitle = lang.pdf_books_checked_out_report;
			reportHref = `./print.php?report=booksCheckedout&startDate=${startDate}&endDate=${endDate}`
			showTransactionsReport(startDate, endDate, report, false, false)
		} 
		else if(report == 'overdueBooks') {
			reportTitle = lang.pdf_overdue_books_report;
			dates = '';
			reportHref = `./print.php?report=overdueBooks`
			showTransactionsReport(startDate, endDate, report, false, false)
		} 
		else if(report == 'returnedBooks') {
			reportTitle = lang.pdf_returned_books_report;
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
				"drawCallback": function(settings) {
		            var label = $('#reportDataTable_filter label');
			        label.contents().filter(function() {
			            return this.nodeType === Node.TEXT_NODE;
			        }).replaceWith(lang.search); // Use the language object

			        var label = $('#reportDataTable_length label');
			        var children = label.contents();
			        children.each(function() {
			            if (this.nodeType === Node.TEXT_NODE) {
			                if ($(this).text().trim() === 'Show') {
			                    $(this).replaceWith(lang.show); // Use the language object
			                } else if ($(this).text().trim() === 'entries') {
			                    $(this).replaceWith(lang.entries); // Use the language object
			                }
			            }
			        });

			        $('#reportDataTable_previous a').text(lang.previous); // Use the language object
			        $('#reportDataTable_next a').text(lang.next); // Use the language object
		        },
				columns: [
					{title: lang.customer, data: null, render: function(data, type, row) {
			            return `<div class="flex center-items">
				            	<span>${row.customer}, ${row.phone_number}</span>
				            </div>`;
			        }},

			        {title: lang.book, data: null, render: function(data, type, row) {
			            return `<div>${row.title}, ${row.isbn}</div>`;
			        }},

			        {title: lang.borrow_date, data: null, render: function(data, type, row) {
			            return `<div>${row.borrow_date}</div>`;
			        }},

			       	{title: lang.status, data: null, render: function(data, type, row) {
			            return `<div>
			            		${row.statusTxt}
			            	</div>`;
			        }},

			        {title: lang.due_date, data: null, render: function(data, type, row) {
			            return `<div>${row.due_date}</div>`;
			        }},

			        {title: lang.return_date, data: null, render: function(data, type, row) {
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