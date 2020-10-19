getCompanyEmployeeAttendanceLogs();

function getCompanyEmployeeAttendanceLogs() {
    jQuery.ajax({
        url: CONSTANTS.GET_COMPANY_EMPLOYEE_ATTENDANCE_LOGS_URL,
        type: 'GET',
        beforeSend: function (xhr) {
            xhr.setRequestHeader ("Authorization", "Bearer ")
        },
        success: function(response) {
            if (response.success) {
            	var template = '';
            	var counter = 1;

            	if (response.data.length > 0) {
                    template += `
            		    <h5 class='text-center'><b>Employee Attendance Logs</b></h5><br>
            			<table class="table data-table table-hover table-sm">
						  	<thead>
							    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Employee Name</th>
                                    <th scope="col">Employee Department</th>
                                    <th scope="col">Time In</th>
                                    <th scope="col">Time Out</th>
                                    <th scope="col">Logged Out</th>
                                    <th scope="col">Time At Work</th>
							    </tr>
						  	</thead>
						  	<tbody>
            		`;

            		response.data.forEach(function(item) {
                        var itemObj = JSON.stringify(item);
                        var tableRowClass = "";
                        if (item.current_date) {
                            tableRowClass = "table-info";
                        }

            			template += `
                        <tr class='${tableRowClass}'>
                            <th scope="row">${counter}</th>
                            <td>${item.employee_name}</td>
                            <td>${item.employee_department}</td>
                            <td>${item.time_in}</td>
                            <td>${item.time_out}</td>
                            <td>${item.logged_out}</td>
                            <td>${item.time_at_work}</td>
                        </tr>
            			`;
            			counter ++;
            		});
            	} else {
                    template += `
                        <br><br>
                        <div class='container-fluid'>
                            <h1 class='text-center text-grey'><i class='fa fa-id-badge'></i></h1>
                            <h5 class="text-center text-grey">No employees have logged in yet</h5>
                        </div>
                    `;
            	}

                jQuery('.company-employee-logs-res').html(template);
                jQuery(".data-table").DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            text: '<i class="fa fa-file-excel-o"></i> Excel',
                            exportOptions: {
                                columns: 'th:not(:last-child)'
                            }
                        },
                        {
                            extend: 'csv',
                            text: '<i class="fa fa-file-text-o"></i> CSV',
                            exportOptions: {
                                columns: 'th:not(:last-child)'
                            }
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="fa fa-file-pdf-o"></i> PDF',
                            exportOptions: {
                                columns: 'th:not(:last-child)'
                            }
                        }
                    ]
                });
            } else {

            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           console.log(XMLHttpRequest, textStatus, errorThrown);
        }
    });
}