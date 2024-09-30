
function dashboard() {
    // draw();
    loadTransactions4Dashboard();
    get_dashboard();
}

function draw(drawData) {
    const data = {
        labels: drawData.weekdays,
        datasets: [
            {
                label: 'Borrows',
                data: drawData.borrows,
                backgroundColor: '#2c2d7f',
                borderColor: '#2c2d7f',
                borderWidth: 1,
            },
            {
                label: 'Returns',
                data: drawData.returns,
                backgroundColor: '#a3b943',
                borderColor: '#a3b943',
                borderWidth: 1,
            },
        ],
    };


    new Chart(document.getElementById("barChart"), {
    type: 'bar',
    data: data,
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: 'Predicted world population (millions) in 2050'
      }
    }
});
}

function loadTransactions4Dashboard() {
    // console.log('Here we were')
    let datatable = new DataTable('#overdueBooksTable', {
        "processing": true,
        "serverSide": true,
        "bDestroy": true,
        // "paging": false,
        "serverMethod": 'post',
        "ajax": {
            "url": "./incs/dashboard.php?action=get&get=overdue-trans",
            "method": "POST",
        },
        "drawCallback": function(settings) {
            var api = this.api();
            var emptyRow = $(api.table().body()).find('.dataTables_empty');
            if (emptyRow.length > 0) {
                emptyRow.html(lang.no_books_found); // Use the language object
            }

            var label = $('#overdueBooksTable_filter label');
            label.contents().filter(function() {
                return this.nodeType === Node.TEXT_NODE;
            }).replaceWith(lang.search); // Use the language object

            var label = $('#overdueBooksTable_length label');
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

            $('#overdueBooksTable_previous a').text(lang.previous); // Use the language object
            $('#overdueBooksTable_next a').text(lang.next); // Use the language object
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

            {title: lang.due_date, data: null, render: function(data, type, row) {
                return `<div>${row.due_date}</div>`;
        }},
    ]
});
return false;
}

function get_dashboard() {
    $.post("./incs/dashboard.php?action=get&get=cards", {}, function(data) {
        console.log(data)
        let res = JSON.parse(data)

        console.log(res)

        let drawData = [];

        drawData['borrows'] = Object.values(res.books_borrowed_per_day)
        drawData['returns'] = Object.values(res.books_returned_per_day)
        drawData['weekdays'] = res.weekdays

        $('.borrowed-books h3').html(res.count_borrowed)
        $('.over-due-books h3').html(res.count_overdue)
        $('.all-books h3').html(res.count_all_books)
        $('.all-customers h3').html(res.count_all_customers)
        
        draw(drawData);
        
    });
}