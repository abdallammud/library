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
		swal('Ooops', 'User must read data.', 'error');
		return false;
	}*/

	if(userPrivileges.length < 1) {
		swal('Ooops', 'User must have at least one privilege.', 'error');
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
                title: "Success",
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
		swal('Ooops', 'User must read data.', 'error');
		return false;
	}*/

	if(userPrivileges.length < 1) {
		swal('Ooops', 'User must have at least one privilege.', 'error');
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
                title: "Success",
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
			} else if(privilegs.includes('documents')) {
				location.href = './document';
			} else if(privilegs.includes('archive')) {
				location.href = './archive';
			} else if(privilegs.includes('users')) {
				location.href = './users';
			} else if(privilegs.includes('settings')) {
				location.href = './setting';
			}
			
			return false
			swal({
                title: "Success",
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
	const regex 	= /^[0-9]+-[0-9]+$/; 
	let desc 		= $(form).find('#desc').val();
	let categoryName = $(form).find('#categoryName').val();

	if(!categoryName) {
		showError('Category name is required.', 'categoryName');
		return false;
	}

	$.post("./incs/main.php?action=save&save=category", {desc:desc, categoryName:categoryName}, function(data) {
		console.log(data)
		let res = JSON.parse(data)
		if(res.error) {
			swal('Sorry', res.msg, 'error');
			return false;
		} else {
			swal({
                title: "Success",
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
		columns: [
			{title: "Category", data: null, render: function(data, type, row) {
	            return `<div class="flex center-items">
	            		<span onclick="return editCategoryPopup(this, '${row.category_id}')" class="bi bi-pencil mr-r-10 cursor hover"
	            		></span>
		            	<span>${row.name}</span>
		            </div>`;
	        }},

	        {title: "Description", data: null, render: function(data, type, row) {
	            return `<div>${row.description}</div>`;
	        }},
	         {title: "Status", data: null, render: function(data, type, row) {
	            return `<div>${row.status}</div>`;
	        }},


	        {title: "Date", data: null, render: function(data, type, row) {
	            return `<div>${row.created_at}</div>`;
	        }},

		]
	})
	/*$.post("./incs/main.php?action=load&load=categories", function(data) {
		// console.log(data)
		let res = JSON.parse(data)
		console.log(res)
		let dataset = [];
		if(res.error) {
			dataset = [];
			console.log(res)
		} else {
			dataset = res.dataset;
		}

		let columns = [
			{title: "Category", data: null, render: function(data, type, row) {
	            return `<div class="flex center-items">
	            		<span onclick="return editCategoryPopup(this, '${row.category_id}')" class="bi bi-pencil mr-r-10 cursor hover"
	            		></span>
		            	<span>${row.name}</span>
		            </div>`;
	        }},

	        {title: "Description", data: null, render: function(data, type, row) {
	            return `<div>${row.description}</div>`;
	        }},
	         {title: "Status", data: null, render: function(data, type, row) {
	            return `<div>${row.status}</div>`;
	        }},


	        {title: "Date", data: null, render: function(data, type, row) {
	            return `<div>${row.created_at}</div>`;
	        }},

		]

		let datatable = new DataTable('#categoriesTable', {
			data: dataset,
			"paging": false,
			"columns": columns
		})
	});*/

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
	let desc 				= $(form).find('#desc4Edit').val();
	let categoryName 		= $(form).find('#categoryName4Edit').val();
	let category_id			= $(form).find('#category_id4Edit').val();
	let slcCategoryStatus	= $(form).find('#slcCategoryStatus').val();

	if(!categoryName) {
		showError('Category name is required.', 'categoryName4Edit');
		return false;
	}

	$.post("./incs/main.php?action=update&update=category", {desc:desc, categoryName:categoryName, category_id:category_id, slcCategoryStatus:slcCategoryStatus}, function(data) {
		console.log(data)
		let res = JSON.parse(data)
		if(res.error) {
			swal('Sorry', res.msg, 'error');
			return false;
		} else {
			swal({
                title: "Success",
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

// Articles
function submitBook(form) {
	clearErrors();
	$(form).find('button span.loader').removeClass('ld-ring ld-spin')
	$(form).find('button span.text').html('Submit');
	let bookTitle 		= $(form).find('#bookTitle').val();
	let isbn 			= $(form).find('#isbn').val();
	let authorName 		= $(form).find('#authorName').val();
	let publisher 		= $(form).find('#publisher').val();
	let published_year 	= $(form).find('#published_year').val();
	let slcBookCategory = $(form).find('#slcBookCategory').val();

	let coverImage 		= $(form).find('#coverImage').val();
    let ext 			= coverImage.split('.').pop();
    let file 			= $(form).find('#coverImage')[0].files[0]

	if(!bookTitle) {
		showError('Book title is required.', 'bookTitle');
		return false;
	}

	if(!isbn) {
		showError('ISBN Number is required.', 'isbn');
		return false;
	}

	if(!authorName) {
		showError('Author name Number is required.', 'authorName');
		return false;
	}

	if(!slcBookCategory) {
		showError('Please select book category.', 'slcBookCategory');
		return false;
	}

	console.log(bookTitle, slcBookCategory, coverImage, isbn, authorName, publisher)

   	$(form).find('button span.loader').addClass('ld-ring ld-spin')
	$(form).find('button span.text').html('Please wait....');
	$(form).find('button').attr('disabled', true)

	var formdata = new FormData();
	formdata.append("file", file);
    formdata.append("bookTitle", bookTitle);
    formdata.append("slcBookCategory", slcBookCategory);
    formdata.append("isbn", isbn);
    formdata.append("authorName", authorName);
    formdata.append("publisher", publisher);
    formdata.append("published_year", published_year);
	var ajax = new XMLHttpRequest();
	ajax.addEventListener("load", function(event) {
		console.log(event.target.response)
			$(form).find('button span.loader').removeClass('ld-ring ld-spin')
			$(form).find('button span.text').html('Submit');
			$(form).find('button').attr('disabled', false)
		let res = JSON.parse(event.target.response)
		if(res.error) {
			swal('Ooops', res.msg, 'error');
			return false;
		} else {
			swal({
                title: "Success",
                text: res.msg,
                icon: "success",
                buttons: false,
                timer: 2000,
            }).then(() => {
            	// Reload to post show page which kind looks like the site version
            	let id = res.id
                location.reload();
            })
		}
	});
	
	ajax.open("POST", "./incs/main.php?action=save&save=book");
	ajax.send(formdata);

	return false;
}
function articles() {
	
}
function loadBooks(categoryFilter, statusFilter) {
	console.log(categoryFilter, statusFilter)  
	let datatable = new DataTable('#allBooksDT', {
		"processing": true,
		"serverSide": true,
		"bDestroy": true,
		"columnDefs": [
			{ "orderable": false, "targets": [] }  // Disable search on first and last columns
		],
		// "paging": false,
		"serverMethod": 'post',
		"ajax": {
			"url": "./incs/main.php?action=load&load=books",
			"method":"POST",
			"data": {
	            "categoryFilter": categoryFilter,
	            "statusFilter": statusFilter,
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
	            		<span class="bi bi-pencil cursor hover mr-r-5" onclick="return editBookPopup(${row.book_id}, 'book')"></span>
	            		<a href="./book/show/${data.book_id}" class="bi bi-eye cursor hover mr-r-5" onclick="return editBookPopup(${row.book_id}, 'book')"></a>
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
	            		<span class="bi bi-pencil cursor hover mr-r-5" onclick="return editBookPopup(${row.book_id}, 'status')"></span>
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

	return false;
}
async function editBookPopup(book_id, edit) {
	let modal = $('#editBook');
	if(edit == 'status') {
		modal = $('#editBookStatus');
		$(modal).find(`#slcBookStatus`).val('active');

		let res = await $.post("./incs/main.php?action=get&get=book", {book_id}, function(data) {
		});

		res = JSON.parse(res)[0];
		$(modal).find('#book_id4StatusChange').val(res.book_id)
		$(modal).find(`#slcBookStatus `).val(res.status.toLowerCase())
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
	$(modal).find('#slcBookStatus4Edit').val('active')
	
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
	$(modal).find(`#slcBookStatus4Edit`).val(res.status.toLowerCase())
	console.log(res)
	$(modal).modal('show');
}
function editBook(form) {
	clearErrors();
	$(form).find('button span.loader').removeClass('ld-ring ld-spin')
	$(form).find('button span.text').html('Submit');
	let book_id 		= $(form).find('#book_id').val();
	let bookTitle 		= $(form).find('#bookTitle4Edit').val();
	let isbn 			= $(form).find('#isbn4Edit').val();
	let authorName 		= $(form).find('#authorName4Edit').val();
	let publisher 		= $(form).find('#publisher4Edit').val();
	let published_year 	= $(form).find('#published_year4Edit').val();
	let slcBookCategory = $(form).find('#slcBookCategory4Edit').val();
	let slcBookStatus	= $(form).find('#slcBookStatus4Edit').val();

	if(!bookTitle) {
		showError('Book title is required.', 'bookTitle4Edit');
		return false;
	}

	if(!isbn) {
		showError('ISBN Number is required.', 'isbn');
		return false;
	}

	if(!authorName) {
		showError('Author name Number is required.', 'authorName4Edit');
		return false;
	}

	if(!slcBookCategory) {
		showError('Please select book category.', 'slcBookCategory4Edit');
		return false;
	}

	console.log(bookTitle, slcBookCategory, coverImage, isbn, authorName, publisher)

   	$(form).find('button span.loader').addClass('ld-ring ld-spin')
	$(form).find('button span.text').html('Please wait....');
	$(form).find('button').attr('disabled', true)

	var formdata = new FormData();
	formdata.append("book_id", book_id);
    formdata.append("bookTitle", bookTitle);
    formdata.append("slcBookCategory", slcBookCategory);
    formdata.append("isbn", isbn);
    formdata.append("authorName", authorName);
    formdata.append("publisher", publisher);
    formdata.append("published_year", published_year);
    formdata.append("slcBookStatus", slcBookStatus);
	var ajax = new XMLHttpRequest();
	ajax.addEventListener("load", function(event) {
		console.log(event.target.response)
			$(form).find('button span.loader').removeClass('ld-ring ld-spin')
			$(form).find('button span.text').html('Submit');
			$(form).find('button').attr('disabled', false)
		let res = JSON.parse(event.target.response)
		if(res.error) {
			swal('Ooops', res.msg, 'error');
			return false;
		} else {
			swal({
                title: "Success",
                text: res.msg,
                icon: "success",
                buttons: false,
                timer: 2000,
            }).then(() => {
            	// Reload to post show page which kind looks like the site version
            	let id = res.id
                location.reload();
            })
		}
	});
	
	ajax.open("POST", "./incs/main.php?action=update&update=book");
	ajax.send(formdata);
	return false;
}

function editBookStatus(form) {
	let status = $(form).find('#slcBookStatus').val();
	let book_id =  $(form).find('#book_id4StatusChange').val()
	let statusTxt = 'You are going to make this book not available.';
	if(status == 'active') statusTxt = 'You are going to make this book available.';
	if(status == 'Deleted') statusTxt = 'You are going to delete this article.';

	swal({
		title: "Are you sure?!",
		text: statusTxt,
		icon: "info",
		buttons: ['Cancel', 'Yes, Sure'],
	}).then((confirm) => {
		if(confirm) {
			$.post("./incs/main.php?action=update&update=bookStatus", {book_id, status}, function(data) {
				let res = JSON.parse(data)
				if(res.error) {
					swal('Sorry', res.msg, 'error');
					return false;
				} else {
					swal({
		                title: "Success",
		                text: res.msg,
		                icon: "success",
		                buttons: false,
		                timer: 2000,
		            }).then(() => {
		                location.reload();
		            })
				}
			});
		}
	})

	return false
}