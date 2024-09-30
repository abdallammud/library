(function() {
	$('.toggle-system-language').on('click', (e) => {
		let language = $(e.currentTarget).data('language');
		let lang = language == 'en' ? 'ar' : 'en';
		console.log(language)
		$.post("./incs/utils.php?action=language", {lang: lang}, function(data) {
			console.log(data)
			if(data == 'changed') {
				location.reload()
			} else {
				swal(lang.error_title, data, 'error');
            	return false;
			}
		});

		return false;
	})
})();
function clearErrors() {
    $('input, select, textarea').removeClass('error')
    $('.form-error').css('display', 'none')
}
function showError (msg, id) {
    let span = $('#'+id).parents('.form-group').find('.form-error');
    let span2 = $('#'+id).parents('.form-outline').find('.form-error');
    $(span).html(msg)
    $(span).show();

    $(span2).html(msg)
    $(span2).show();

    $('#'+id).addClass('error')
}
function isUserNameValid(username) {
    const res = /^[a-zA-Z0-9_\.]+$/.exec(username);
    const valid = !!res;
    return valid;
}
function isValidPhone(phone) {
    const res = /^[0-9-+]+$/.exec(phone);;
    const valid = !!res;
    return valid;
}
function isNumber(evt)  {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}
function extractEmails ( text ){
    return text.match(/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9_-]+)/gi);
}
function formatDateRange(startDate, endDate) {
    // Parse input dates
    const start = new Date(startDate);
    const end = new Date(endDate);
    
    // Define options for formatting
    const options = { month: 'short', day: 'numeric' };
    const yearOptions = { ...options, year: 'numeric' };
    
    // Format the dates
    const startFormatted = start.toLocaleDateString('en-US', options);
    const endFormatted = end.toLocaleDateString('en-US', yearOptions);

    // Check if the year is the same
    if (start.getFullYear() === end.getFullYear()) {
        // Same year
        return `${startFormatted} - ${endFormatted}`;
    } else {
        // Different years
        const startFormattedWithYear = `${startFormatted} ${start.getFullYear()}`;
        return `${startFormattedWithYear} - ${endFormatted}`;
    }
}


// Employees
function saveEmployee(form) {
	clearErrors();
	let fullName 	= $(form).find('#fullName').val();
	let phone 		= $(form).find('#phone').val();
	let email 		= $(form).find('#email').val();
	let username 	= $(form).find('#username').val();
	let slcRole 	= $(form).find('#slcRole').val();
	let password 	= $(form).find('#password').val();

	let userActions 	= $(form).find('#userActions').val();
	let userPrivileges 	= $(form).find('#userPrivileges').val();

	if(!fullName) {
		showError('Name is required.', 'fullName');
		return false;
	} 
	if(!phone) {
		showError('Phone number is required.', 'phone');
		return false;
	} 
	if(!isValidPhone(phone)) {
		showError('invalid Phone number.', 'phone');
		return false;
	}
	if(!username) {
		showError('Username is required.', 'username');
		return false;
	}
	if(!password) {
		showError('Password is required.', 'password');
		return false;
	} 

	/*if(userActions.length < 1) {
		swal(lang.error_title, 'User must read data.', 'error');
		return false;
	}*/

	if(userPrivileges.length < 1) {
		swal(lang.error_title, 'User must have at least one privilege.', 'error');
		return false;
	}

	let formData = {
		fullName,
		phone,
		email,
		username,
		slcRole,
		password,
		userActions,
		userPrivileges
	}

	$.post("./incs/main.php?action=save&save=employee", formData, function(data) {
		console.log(data)
		let res = JSON.parse(data);
		if(res.error) {
			swal('Sorry', res.msg, 'error');
			return false;
		} else {
			swal({
                title: lang.success_title,
                text: res.msg,
                icon: "success",
                buttons: false,
                timer: 2000,
            }).then(() => {
                location.reload();
            })
		}
 	});



	return false;
}
function loadEmployees() {
	let datatable = new DataTable('#allUsers', {
		"processing": true,
		"serverSide": true,
		"bDestroy": true,
		// "paging": false,
		"serverMethod": 'post',
		"ajax": {
			"url": "./incs/main.php?action=load&load=employees",
			"method":"POST",
			// dataFilter: function(data) {
			// 	console.log(data)
			// }
		}, 
		columns: [
			{title: "Full name", data: null, render: function(data, type, row) {
	            return `<div class="flex center-items">
	            		<span class="bi bi-pencil mr-r-10 cursor hover"
	            		data-user_id="${row.user_id}"
	            		data-full_name="${row.full_name}"
	            		data-email="${row.email}"
	            		data-phone="${row.phone}"
	            		data-role="${row.role}"
	            		data-status="${row.status}"
	            		data-actions="${row.user_actions}"
	            		data-privileges="${row.user_privileges}"
	            		data-twitter="${row.twitter}"
	            		data-facebook="${row.facebook}"
	            		data-web="${row.web}"
	            		data-bio="${row.bio}"
	            		data-linkedin="${row.linkedin}"
	            		onclick="return editEmployeePopup(this)"
	            		></span>
		            	<span>${row.full_name}</span>
		            </div>`;
	        }},

	        {title: "Phone number", data: null, render: function(data, type, row) {
	            return `<div>${row.phone}</div>`;
	        }},

	        {title: "Email", data: null, render: function(data, type, row) {
	            return `<div>${row.email}</div>`;
	        }},

	        {title: "Username", data: null, render: function(data, type, row) {
	            return `<div>${row.username}</div>`;
	        }},

	        {title: "Status", data: null, render: function(data, type, row) {
	            return `<div class="${row.status}">${row.status}</div>`;
	        }},

	        {title: "Role", data: null, render: function(data, type, row) {
	            return `<div>${row.role}</div>`;
	        }},
		]
	})





	return false;
}
function editEmployeePopup(btn) {
	let data = $(btn).data()
	let modal = $('.modal#editEmployee');

	console.log(data)

	$(modal).find('#user_id').val(data.user_id)
	$(modal).find('#fullNameEdit').val(data.full_name)
	$(modal).find('#phoneEdit').val(data.phone)
	$(modal).find('#emailEdit').val(data.email)
	$(modal).find(`#slcStatus4Edit option[value="${data.status}"]`).attr('selected', 'Selected')
	$(modal).find(`#slcRoleEdit option[value="${data.role}"]`).attr('selected', 'Selected')

	let actions 	= data.actions.split(',');
	let privileges 	= data.privileges.split(',');

	actions.map((action) => {
		$(modal).find(`#userActions4Edit option[value="${action}"]`).attr('selected', 'Selected')
		$('select#userActions4Edit')[0].sumo.reload();
	})

	privileges.map((privilege) => {
		$(modal).find(`#userPrivileges4Edit option[value="${privilege}"]`).attr('selected', 'Selected')
		$('select#userPrivileges4Edit')[0].sumo.reload();
	})

	$(modal).find('#twitter').val(data.twitter)
	$(modal).find('#facebook').val(data.facebook)
	$(modal).find('#web').val(data.web)
	$(modal).find('#bio').val(data.bio)
	$(modal).find('#linkedin').val(data.linkedin)

	$(modal).modal('show');
	console.log(data)
}
function editEmployee(form) {
	clearErrors();
	let user_id 	= $(form).find('#user_id').val();
	let fullName 	= $(form).find('#fullNameEdit').val();
	let phone 		= $(form).find('#phoneEdit').val();
	let email 		= $(form).find('#emailEdit').val();
	let slcRole 	= $(form).find('#slcRoleEdit').val();
	let slcStatus 	= $(form).find('#slcStatus4Edit').val();

	let userActions 	= $(form).find('#userActions4Edit').val();
	let userPrivileges 	= $(form).find('#userPrivileges4Edit').val();


	if(!fullName) {
		showError('Name is required.', 'fullNameEdit');
		return false;
	} 
	if(!phone) {
		showError('Phone number is required.', 'phoneEdit');
		return false;
	} 
	if(!isValidPhone(phone)) {
		showError('invalid Phone number.', 'phoneEdit');
		return false;
	}

	/*if(userActions.length < 1) {
		swal(lang.error_title, 'User must read data.', 'error');
		return false;
	}*/

	if(userPrivileges.length < 1) {
		swal(lang.error_title, 'User must have at least one privilege.', 'error');
		return false;
	}


	let formData = {
		fullName,
		phone,
		email,
		slcStatus,
		slcRole,
		user_id,
		userActions,
		userPrivileges,
	}

	$.post("./incs/main.php?action=update&update=employee", formData, function(data) {
		console.log(data)
		let res = JSON.parse(data);
		if(res.error) {
			swal('Sorry', res.msg, 'error');
			return false;
		} else {
			swal({
                title: lang.success_title,
                text: res.msg,
                icon: "success",
                buttons: false,
                timer: 2000,
            }).then(() => {
                location.reload();
            })
		}
 	});



	return false;
}
function loginUser(form) {
	let username = $(form).find('#username').val();
	let password = $(form).find('#password').val();

	if(!username) {
		showError('Username is required.', 'username');
		return false;
	}
	if(!password) {
		showError('Password is required.', 'password');
		return false;
	} 

	$.post("./incs/utils.php?action=login", {username, password}, function(data) {
		console.log(data)
		let res = JSON.parse(data)
		if(!res.error) {
			let privilegs = res.privilegs.split(',');
			console.log(privilegs)
			if(privilegs.includes('dashboard')) {
				location.href = './';
			} else if(privilegs.includes('books')) {
				location.href = './book';
			} else if(privilegs.includes('categories')) {
				location.href = './categories';
			} else if(privilegs.includes('users')) {
				location.href = './users';
			} else if(privilegs.includes('customers')) {
				location.href = './customer';
			} else if(privilegs.includes('transactions')) {
				location.href = './transactions';
			} else if(privilegs.includes('reports')) {
				location.href = './report';
			}
			
			return false
			swal({
                title: lang.success_title,
                text: res.msg,
                icon: "success",
                buttons: false,
                timer: 2000,
            }).then(() => {
                location.href = './';
            })
		} else {
			swal('Sorry', res.msg, 'error');
		}
	});

	return false
}


// Categories
function saveCategory(form) {
    clearErrors();
    const regex = /^[0-9]+-[0-9]+/; 
    let desc = $(form).find('#desc').val();
    let categoryName = $(form).find('#categoryName').val();

    if (!categoryName) {
        showError(lang.required_category_name, 'categoryName');
        return false;
    }

    $.post("./incs/main.php?action=save&save=category", {desc: desc, categoryName: categoryName}, function(data) {
        console.log(data);
        let res = JSON.parse(data);
        if (res.error) {
            swal(lang.error_title, res.msg, 'error');
            return false;
        } else {
            swal({
                title: lang.success_title,
                text: res.msg,
                icon: "success",
                buttons: false,
                timer: 2000,
            }).then(() => {
                location.reload();
            });
        }
    });
    return false;
}
function loadCategories() {
	let datatable = new DataTable('#categoriesTable', {
		"processing": true,
		"serverSide": true,
		"bDestroy": true,
		// "paging": false,
		"serverMethod": 'post',
		"ajax": {
			"url": "./incs/main.php?action=load&load=categories",
			"method":"POST",
			// dataFilter: function(data) {
			// 	console.log(data)
			// }
		}, 
		"drawCallback": function(settings) {
            var label = $('#categoriesTable_filter label');
		    // Update the label's text node without affecting the input
		    label.contents().filter(function() {
		        return this.nodeType === Node.TEXT_NODE;
		    }).replaceWith(' بحث   ');

		    var label = $('#categoriesTable_filter label');
	        label.contents().filter(function() {
	            return this.nodeType === Node.TEXT_NODE;
	        }).replaceWith(lang.search); // Use the language object

	        var label = $('#categoriesTable_length label');
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
		    $('#categoriesTable_previous a').text('سابق  ')
		    $('#categoriesTable_next a').text('التالي  ')
        },
		columns: [
		    {title: lang.all_categories, data: null, render: function(data, type, row) {
		        return `<div class="flex center-items">
		                    <span onclick="return editCategoryPopup(this, '${row.category_id}')" class="bi bi-pencil mr-r-10 cursor hover"></span>
		                    <span>${row.name}</span>
		                </div>`;
		    }},

		    {title: lang.description, data: null, render: function(data, type, row) {
		        return `<div>${row.description}</div>`;
		    }},
		    
		    {title: lang.status, data: null, render: function(data, type, row) {
		        return `<div>${row.status}</div>`;
		    }},

		    {title: lang.created_at, data: null, render: function(data, type, row) {
		        return `<div>${row.created_at}</div>`;
		    }},
		]
	})
	

	return false;	
}
async function editCategoryPopup(btn, category_id) {
	let modal = $('#editCategory');
	$(modal).find('#category_id4Edit').val('')
	$(modal).find('#desc4Edit').val('')
	$(modal).find('#categoryName4Edit').val('')
	$(modal).find(`#slcCategoryStatus option[value="Darft"]`).attr('selected', 'selected');

	await $.post("./incs/main.php?action=get&get=category", {category_id:category_id}, function(data) {
		let res = JSON.parse(data)[0]
		
		$(modal).find('#category_id4Edit').val(res.id)
		$(modal).find('#categoryName4Edit').val(res.name)
		$(modal).find('#desc4Edit').val(res.description)

		$(modal).find(`#slcCategoryStatus option[value="${res.status}"]`).attr('selected', 'selected');
		
	});

	$(modal).modal('show');
}
function editCategory(form) {
    let desc = $(form).find('#desc4Edit').val();
    let categoryName = $(form).find('#categoryName4Edit').val();
    let category_id = $(form).find('#category_id4Edit').val();
    let slcCategoryStatus = $(form).find('#slcCategoryStatus').val();

    if (!categoryName) {
        showError(lang.required_category_name, 'categoryName4Edit');
        return false;
    }

    $.post("./incs/main.php?action=update&update=category", {desc: desc, categoryName: categoryName, category_id: category_id, slcCategoryStatus: slcCategoryStatus}, function(data) {
        console.log(data);
        let res = JSON.parse(data);
        if (res.error) {
            swal(lang.error_title, res.msg, 'error');
            return false;
        } else {
            swal({
                title: lang.success_title,
                text: res.msg,
                icon: "success",
                buttons: false,
                timer: 2000,
            }).then(() => {
                location.reload();
            });
        }
    });
    return false;
}


// Book
function submitBook(form) {
	clearErrors();
	$(form).find('button span.loader').removeClass('ld-ring ld-spin');
	$(form).find('button span.text').html(lang.submit);

	let bookTitle = $(form).find('#bookTitle').val();
	let isbn = $(form).find('#isbn').val();
	let authorName = $(form).find('#authorName').val();
	let publisher = $(form).find('#publisher').val();
	let published_year = $(form).find('#published_year').val();
	let slcBookCategory = $(form).find('#slcBookCategory').val();

	let number_of_copies = $(form).find('#number_of_copies').val();
	let parts = $(form).find('#parts').val();
	let part_num = $(form).find('#part_num').val();

	let coverImage = $(form).find('#coverImage').val();
	let ext = coverImage.split('.').pop();
	let file = $(form).find('#coverImage')[0].files[0];

	if (!number_of_copies) number_of_copies = 1;
	if (!parts) parts = 1;
	if (!part_num) part_num = 1;

	if (!bookTitle) {
	    showError(lang.required_book_title, 'bookTitle');
	    return false;
	}

	if (!isbn) {
	    showError(lang.required_isbn, 'isbn');
	    return false;
	}

	if (!authorName) {
	    showError(lang.required_author_name, 'authorName');
	    return false;
	}

	if (!slcBookCategory) {
	    showError(lang.required_category, 'slcBookCategory');
	    return false;
	}

	console.log(bookTitle, slcBookCategory, coverImage, isbn, authorName, publisher);

	$(form).find('button span.loader').addClass('ld-ring ld-spin');
	$(form).find('button span.text').html(lang.please_wait);
	$(form).find('button').attr('disabled', true);

	var formdata = new FormData();
	formdata.append("file", file);
	formdata.append("bookTitle", bookTitle);
	formdata.append("slcBookCategory", slcBookCategory);
	formdata.append("isbn", isbn);
	formdata.append("authorName", authorName);
	formdata.append("publisher", publisher);
	formdata.append("published_year", published_year);
	formdata.append("number_of_copies", number_of_copies);
	formdata.append("parts", parts);
	formdata.append("part_num", part_num);

	var ajax = new XMLHttpRequest();
	ajax.addEventListener("load", function(event) {
	    console.log(event.target.response);
	    $(form).find('button span.loader').removeClass('ld-ring ld-spin');
	    $(form).find('button span.text').html(lang.submit);
	    $(form).find('button').attr('disabled', false);
	    let res = JSON.parse(event.target.response);
	    if (res.error) {
	        swal(lang.error_title, res.msg, 'error');
	        return false;
	    } else {
	        swal({
	            title: lang.success,
	            text: res.msg,
	            icon: "success",
	            buttons: false,
	            timer: 2000,
	        }).then(() => {
	            let id = res.id;
	            location.reload();
	        });
	    }
	});

	ajax.open("POST", "./incs/main.php?action=save&save=book");
	ajax.send(formdata);

	return false;
}
function loadBooks(categoryFilter, statusFilter) {
	console.log(categoryFilter, statusFilter);
	let datatable = new DataTable('#allBooksDT', {
	    "processing": true,
	    "serverSide": true,
	    "bDestroy": true,
	    "columnDefs": [
	        { "orderable": false, "targets": [] }  // Disable search on first and last columns
	    ],
	    "serverMethod": 'post',
	    "ajax": {
	        "url": "./incs/main.php?action=load&load=books",
	        "method": "POST",
	        "data": {
	            "categoryFilter": categoryFilter,
	            "statusFilter": statusFilter,
	        },
	    },
	    "language": {
	        "emptyTable": lang.no_books_found // Use the language object
	    },
	    "drawCallback": function(settings) {
	        var api = this.api();
	        var emptyRow = $(api.table().body()).find('.dataTables_empty');
	        if (emptyRow.length > 0) {
	            emptyRow.html(lang.no_books_found); // Use the language object
	        }

	        var label = $('#allBooksDT_filter label');
	        label.contents().filter(function() {
	            return this.nodeType === Node.TEXT_NODE;
	        }).replaceWith(lang.search); // Use the language object

	        var label = $('#allBooksDT_length label');
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

	        $('#allBooksDT_previous a').text(lang.previous); // Use the language object
	        $('#allBooksDT_next a').text(lang.next); // Use the language object
	    },
	    columns: [
	        { title: lang.title, data: null, render: function(data, type, row) {
	            return `<div>
	                        <span class="bi bi-pencil cursor hover mr-r-5" onclick="return editBookPopup(${row.book_id}, 'book')"></span>
	                        <a href="./book/show/${data.book_id}" class="bi bi-eye cursor hover mr-r-5" onclick="return editBookPopup(${row.book_id}, 'book')"></a>
	                        <span>${row.title}</span>
	                    </div>`;
	        }},
	        { title: lang.isbn, data: null, render: function(data, type, row) {
	            return `<div>
	                        <span>${row.isbn}</span>
	                    </div>`;
	        }},
	        { title: lang.author, data: null, render: function(data, type, row) {
	            return `<div>
	                        <span>${row.author}</span>
	                    </div>`;
	        }},
	        { title: lang.published_year, data: null, render: function(data, type, row) {
	            return `<div>
	                        <span>${row.published_year}</span>
	                    </div>`;
	        }},
	        { title: lang.category, data: null, render: function(data, type, row) {
	            return `<div>
	                        <span>${row.category}</span>
	                    </div>`;
	        }},
	        { title: lang.status, data: null, render: function(data, type, row) {
	            return `<div class="${row.status}">
	                        <span class="bi bi-pencil cursor hover mr-r-5" onclick="return editBookPopup(${row.book_id}, 'status')"></span>
	                        <span>${row.statusTxt}</span>
	                    </div>`;
	        }},
	        { title: lang.date, data: null, render: function(data, type, row) {
	            return `<div class="flex center-items">
	                        <span>${row.created_at}</span>
	                    </div>`;
	        }},
	    ]
	});

	return false;
}
async function editBookPopup(book_id, edit) {
	let modal = $('#editBook');
	if(edit == 'status') {
		modal = $('#editBookStatus');
		$(modal).find(`#slcBookStatus`).val(lang.available);

		let res = await $.post("./incs/main.php?action=get&get=book", {book_id}, function(data) {
		});

		res = JSON.parse(res)[0];
		$(modal).find('#book_id4StatusChange').val(res.book_id)
		$(modal).find(`#slcBookStatus`).val(res.status.toLowerCase())
		$(modal).modal('show');
		return false;
	}
	


	$(modal).find('#book_id').val('')
	$(modal).find('#bookTitle4Edit').val('')
	$(modal).find('#isbn4Edit').val('')
	$(modal).find('#authorName4Edit').val('')
	$(modal).find('#publisher4Edit').val('')
	$(modal).find('#published_year4Edit').val('2024')
	$(modal).find('#slcBookCategory4Edit').val('')
	$(modal).find('#slcBookStatus4Edit').val(lang.available)
	
	let res = await $.post("./incs/main.php?action=get&get=book", {book_id}, function(data) {
	});

	res = JSON.parse(res)[0];

	$(modal).find('#book_id').val(res.book_id)
	$(modal).find('#bookTitle4Edit').val(res.title)
	$(modal).find('#isbn4Edit').val(res.isbn)
	$(modal).find('#authorName4Edit').val(res.author)
	$(modal).find('#publisher4Edit').val(res.publisher)
	$(modal).find('#published_year4Edit').val(res.published_year)
	$(modal).find(`#slcBookCategory4Edit`).val(res.category_id)
	$(modal).find('#number_of_copies4Edit').val(res.number_of_copies)
	$(modal).find('#parts4Edit').val(res.parts)
	$(modal).find('#part_num4Edit').val(res.part_num)
	$(modal).find(`#slcBookStatus4Edit`).val(res.status.toLowerCase())
	console.log(res)
	$(modal).modal('show');
}
function editBook(form) {
	clearErrors();
	$(form).find('button span.loader').removeClass('ld-ring ld-spin');
	$(form).find('button span.text').html(lang.submit);
	let book_id = $(form).find('#book_id').val();
	let bookTitle = $(form).find('#bookTitle4Edit').val();
	let isbn = $(form).find('#isbn4Edit').val();
	let authorName = $(form).find('#authorName4Edit').val();
	let publisher = $(form).find('#publisher4Edit').val();
	let published_year = $(form).find('#published_year4Edit').val();
	let slcBookCategory = $(form).find('#slcBookCategory4Edit').val();
	let number_of_copies = $(form).find('#number_of_copies4Edit').val();
	let parts = $(form).find('#parts4Edit').val();
	let part_num = $(form).find('#part_num4Edit').val();
	let slcBookStatus = $(form).find('#slcBookStatus4Edit').val();

	if (!bookTitle) {
	    showError(lang.required_book_title, 'bookTitle4Edit');
	    return false;
	}

	if (!isbn) {
	    showError(lang.required_isbn, 'isbn4Edit');
	    return false;
	}

	if (!authorName) {
	    showError(lang.required_author_name, 'authorName4Edit');
	    return false;
	}

	if (!slcBookCategory) {
	    showError(lang.required_category, 'slcBookCategory4Edit');
	    return false;
	}

	console.log(bookTitle, slcBookCategory, isbn, authorName, publisher);

	$(form).find('button span.loader').addClass('ld-ring ld-spin');
	$(form).find('button span.text').html(lang.please_wait);
	$(form).find('button').attr('disabled', true);

	var formdata = new FormData();
	formdata.append("book_id", book_id);
	formdata.append("bookTitle", bookTitle);
	formdata.append("slcBookCategory", slcBookCategory);
	formdata.append("isbn", isbn);
	formdata.append("authorName", authorName);
	formdata.append("publisher", publisher);
	formdata.append("published_year", published_year);
	formdata.append("number_of_copies", number_of_copies);
	formdata.append("parts", parts);
	formdata.append("part_num", part_num);
	formdata.append("slcBookStatus", slcBookStatus);

	var ajax = new XMLHttpRequest();
	ajax.addEventListener("load", function(event) {
	    console.log(event.target.response);
	    $(form).find('button span.loader').removeClass('ld-ring ld-spin');
	    $(form).find('button span.text').html(lang.submit);
	    $(form).find('button').attr('disabled', false);
	    let res = JSON.parse(event.target.response);
	    if (res.error) {
	        swal(lang.error_title, res.msg, 'error');
	        return false;
	    } else {
	        swal({
	            title: lang.success,
	            text: res.msg,
	            icon: "success",
	            buttons: false,
	            timer: 2000,
	        }).then(() => {
	            let id = res.id;
	            location.reload();
	        });
	    }
	});

	ajax.open("POST", "./incs/main.php?action=update&update=book");
	ajax.send(formdata);
	return false;
}
function editBookStatus(form) {
	let status = $(form).find('#slcBookStatus').val();
	let book_id = $(form).find('#book_id4StatusChange').val();
	let statusTxt = lang.book_not_available;
	if (status == 'active') statusTxt = lang.book_available;
	if (status == 'Deleted') statusTxt = lang.book_deleted;

	swal({
	    title: lang.confirm_title,
	    text: statusTxt,
	    icon: "info",
	    buttons: [lang.cancel, lang.yes_sure],
	}).then((confirm) => {
	    if (confirm) {
	        $.post("./incs/main.php?action=update&update=bookStatus", { book_id, status }, function(data) {
	        	console.log(data)
	            let res = JSON.parse(data);
	            if (res.error) {
	                swal(lang.sorry, res.msg, 'error');
	                return false;
	            } else {
	                swal({
	                    title: lang.success,
	                    text: res.msg,
	                    icon: "success",
	                    buttons: false,
	                    timer: 2000,
	                }).then(() => {
	                    location.reload();
	                });
	            }
	        });
	    }
	});

	return false;
}
function editBookCover(form) {
	let book_id =  $(form).find('#book_id4CoverChange').val();
	let coverImage 		= $(form).find('#coverImage').val();
    let ext 			= coverImage.split('.').pop();
    let file 			= $(form).find('#coverImage')[0].files[0]

    var formdata = new FormData();
	formdata.append("file", file);
    formdata.append("book_id", book_id);

    var ajax = new XMLHttpRequest();
	ajax.addEventListener("load", function(event) {
		console.log(event.target.response)
		let res = JSON.parse(event.target.response)
		if(res.error) {
			swal(lang.error_title, res.msg, 'error');
			return false;
		} else {
			swal({
                title: lang.success_title,
                text: res.msg,
                icon: "success",
                buttons: false,
                timer: 2000,
            }).then(() => {
            	let id = res.id
                location.reload();
            })
		}
	});
	
	ajax.open("POST", `${baseURI}/incs/main.php?action=update&update=bookCover`);
	ajax.send(formdata);

	return false;
}
function deleteCoverFromBook(book_id) {
    var formdata = new FormData();
	formdata.append("book_id", book_id);
	var ajax = new XMLHttpRequest();
	ajax.addEventListener("load", function(event) {
	    console.log(event.target.response);
	    let res = JSON.parse(event.target.response);
	    if(res.error) {
	        swal(lang.error_title, res.msg, 'error');
	        return false;
	    } else {
	        swal({
	            title: lang.success_title,
	            text: lang.book_removed,
	            icon: "success",
	            buttons: false,
	            timer: 2000,
	        }).then(() => {
	            let id = res.id;
	            location.reload();
	        });
	    }
	});
	
	ajax.open("POST", `${baseURI}/incs/main.php?action=update&update=bookCover`);
	ajax.send(formdata);

	return false;
}

// Customers
function addCustomer(form) {
	clearErrors();
	const regex = /^[0-9]+-[0-9]+$/; 
	let customerName = $(form).find('#customerName').val();
	let phoneNumber = $(form).find('#phoneNumber').val();
	let email = $(form).find('#email').val();

	if (!customerName) {
	    showError(lang.required_customer_name, 'customerName');
	    return false;
	}

	if (!phoneNumber) {
	    showError(lang.required_phone_number, 'phoneNumber');
	    return false;
	}

	$.post("./incs/main.php?action=save&save=customer", {name: customerName, phone: phoneNumber, email: email}, function(data) {
	    console.log(data);
	    let res = JSON.parse(data);
	    if (res.error) {
	        swal(lang.error_title, res.msg, 'error');
	        return false;
	    } else {
	        swal({
	            title: lang.success_title,
	            text: res.msg,
	            icon: "success",
	            buttons: false,
	            timer: 2000,
	        }).then(() => {
	            location.reload();
	        });
	    }
	});
	return false;
}
function loadCustomers() {
	let datatable = new DataTable('#customersTable', {
		"processing": true,
		"serverSide": true,
		"bDestroy": true,
		// "paging": false,
		"serverMethod": 'post',
		"ajax": {
			"url": "./incs/main.php?action=load&load=customers",
			"method":"POST",
			// dataFilter: function(data) {
			// 	console.log(data)
			// }
		}, 
		"drawCallback": function(settings) {
            var label = $('#customersTable_filter label');
	        label.contents().filter(function() {
	            return this.nodeType === Node.TEXT_NODE;
	        }).replaceWith(lang.search); // Use the language object

	        var label = $('#customersTable_length label');
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

	        $('#customersTable_previous a').text(lang.previous); // Use the language object
	        $('#customersTable_next a').text(lang.next); // Use the language object
        },
		columns: [
		    {title: lang.customer_name, data: null, render: function(data, type, row) {
		        return `<div class="flex center-items">
		                    <span onclick="return editCustomerPopup(this, '${row.id}')" class="bi bi-pencil mr-r-10 cursor hover"></span>
		                    <span>${row.name}</span>
		                </div>`;
		    }},

		    {title: lang.phone_number, data: null, render: function(data, type, row) {
		        return `<div>${row.phone_number}</div>`;
		    }},

		    {title: lang.email, data: null, render: function(data, type, row) {
		        return `<div>${row.email}</div>`;
		    }},

		    {title: lang.membership_status, data: null, render: function(data, type, row) {
		        return `<div>${row.membership_status}</div>`;
		    }},

		    {title: lang.join_date, data: null, render: function(data, type, row) {
		        return `<div>${row.created_at}</div>`;
		    }},
		]

	})
	return false;	
}
async function editCustomerPopup(btn, id) {
	let modal = $('#editCustomer');
	$(modal).find('#customer_id4Edit').val('')
	$(modal).find('#CustomerName4Edit').val('')
	$(modal).find('#CustomerPhone4Edit').val('')
	$(modal).find('#CustomerEmail4Edit').val('')
	$(modal).find(`#slcCustomerStatus`).val(lang.active);

	await $.post("./incs/main.php?action=get&get=customer", {id:id}, function(data) {
		let res = JSON.parse(data)[0]
		
		$(modal).find('#customer_id4Edit').val(res.id)
		$(modal).find('#CustomerName4Edit').val(res.name)
		$(modal).find('#CustomerPhone4Edit').val(res.phone_number)
		$(modal).find('#CustomerEmail4Edit').val(res.email)

		$(modal).find(`#slcCustomerStatus`).val(res.membership_status.toLowerCase());
		
	});

	$(modal).modal('show');
}
function editCustomer(form) {
	let id 		= $(form).find('#customer_id4Edit').val();
	let name 	= $(form).find('#CustomerName4Edit').val();
	let phone	= $(form).find('#CustomerPhone4Edit').val();
	let email	= $(form).find('#CustomerEmail4Edit').val();
	let status	= $(form).find('#slcCustomerStatus').val();

	if(!name) {
	    showError(lang.required_customer_name, 'CustomerName4Edit');
	    return false;
	}

	if(!phone) {
	    showError(lang.required_phone_number, 'CustomerPhone4Edit');
	    return false;
	}

	$.post("./incs/main.php?action=update&update=customer", {id:id, name:name, phone:phone, email:email, status:status}, function(data) {
		console.log(data)
		let res = JSON.parse(data)
		if(res.error) {
			swal('Sorry', res.msg, 'error');
			return false;
		} else {
			swal({
                title: lang.success_title,
                text: res.msg,
                icon: "success",
                buttons: false,
                timer: 2000,
            }).then(() => {
                location.reload();
            })
		}
	})
	return false;
}

// Transactions
function transactions() {
	$('input#customerName').on('keyup', (e) => {
		let searchResult = $(e.target).parents('.has-search').find('.search-result');
		let search = $(e.target).val();

		if(search) {
			$.post("./incs/main.php?action=search&search=customer", {search:search}, function(data) {
				console.log(data)
				$(searchResult).show()
				$(searchResult).html(data)
			});
		}
	})

	$('input#book').on('keyup', (e) => {
		let searchResult = $(e.target).parents('.has-search').find('.search-result');
		let search = $(e.target).val();

		if(search) {
			$.post("./incs/main.php?action=search&search=book", {search:search}, function(data) {
				console.log(data)
				$(searchResult).show()
				$(searchResult).html(data)
			});
		}
	})

	$('#slcTransactionStatus').on('change', (e) => {
		if($(e.target).val() == 'returned') {
			$('.slcReturnDateDiv').removeClass('hidden')
		} else {$('.slcReturnDateDiv').addClass('hidden')}
	})
}

function catchCustomer(id, name, phone) {
	console.log(id, name)
	let info = `${name}, ${phone}`
	$('.search-result').hide();
	$('input#customerName').val(info)
	$('input#customer_id').val(id)
	return false;
}

function catchBook(id, isbn, title, author) {
	let book = `${isbn}, ${title} by ${author}`	
	$('.search-result').hide();
	$('input#book').val(book)
	$('input#isbn').val(isbn)
	return false;
}

function addTransaction(form) {
	clearErrors();
	const regex 	= /^[0-9]+-[0-9]+$/; 
	let customer_id = $(form).find('#customer_id').val();
	let isbn 		= $(form).find('#isbn').val();
	let dueDate 	= $(form).find('#dueDate').val();

	if(!customer_id) {
		showError(lang.get_customer, 'customerName');
		return false;
	}

	if(!isbn) {
		showError(lang.get_book, 'book');
		return false;
	}

	$.post("./incs/main.php?action=save&save=borrow", {customer_id:customer_id, isbn:isbn, dueDate:dueDate}, function(data) {
		console.log(data)
		let res = JSON.parse(data)
		if(res.error) {
			swal(lang.sorry, res.msg, 'error');
			return false;
		} else {
			swal({
                title: lang.success_title,
                text: res.msg,
                icon: "success",
                buttons: false,
                timer: 2000,
            }).then(() => {
                location.reload();
            })
		}
	})
	return false;
}

function loadTransactions() {
	let datatable = new DataTable('#transactionsTable', {
		"processing": true,
		"serverSide": true,
		"bDestroy": true,
		// "paging": false,
		"serverMethod": 'post',
		"ajax": {
			"url": "./incs/main.php?action=load&load=transactions",
			"method":"POST",
			// dataFilter: function(data) {
			// 	console.log(data)
			// }
		}, 
		"drawCallback": function(settings) {
            var label = $('#transactionsTable_filter label');
	        label.contents().filter(function() {
	            return this.nodeType === Node.TEXT_NODE;
	        }).replaceWith(lang.search); // Use the language object

	        var label = $('#transactionsTable_length label');
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

	        $('#transactionsTable_previous a').text(lang.previous); // Use the language object
	        $('#transactionsTable_next a').text(lang.next); // Use the language object
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
		                    <span onclick="return editTransactionPopup(this, '${row.id}')" class="bi bi-pencil mr-r-10 cursor hover"></span>
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
	return false;	
}

async function editTransactionPopup(btn, id) {
	let modal = $('#editTransactionStatus');
	$(modal).find('#transaction_id').val(id)
	$(modal).find('#slcTransactionStatus').val(lang.active)
	// $(modal).find('#slcReturnDate').val('')

	await $.post("./incs/main.php?action=get&get=borrowing", {id:id}, function(data) {
		let res = JSON.parse(data)[0]
		
		// $(modal).find('#slcReturnDate').val(res.return_date)
		$(modal).find(`#slcTransactionStatus`).val(res.status.toLowerCase());
		
	});

	$(modal).modal('show');
}

function editTransactionStatus(form) {
	let id 		= $(form).find('#transaction_id').val();
	let date 	= $(form).find('#slcReturnDate').val();
	let status	= $(form).find('#slcTransactionStatus').val();

	$.post("./incs/main.php?action=update&update=borrowing", {id:id, date:date, status:status}, function(data) {
		console.log(data)
		let res = JSON.parse(data)
		if(res.error) {
			swal(lang.sorry, res.msg, 'error');
			return false;
		} else {
			swal({
                title: lang.success_title,
                text: res.msg,
                icon: "success",
                buttons: false,
                timer: 2000,
            }).then(() => {
                location.reload();
            })
		}
	})
	return false;
}