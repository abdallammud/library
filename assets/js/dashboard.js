
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
            "method":"POST",
            /*dataFilter: function(data) {
             console.log(data)
            }*/
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


            {title: "Due Date", data: null, render: function(data, type, row) {
                return `<div>${row.due_date}</div>`;
            }},

        ]
    })
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