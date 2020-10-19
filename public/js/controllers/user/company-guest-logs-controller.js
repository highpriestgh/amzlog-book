getCompanyGuestLogs();

function getCompanyGuestLogs() {
    jQuery.ajax({
        url: CONSTANTS.GET_COMPANY_GUEST_LOGS_URL,
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
            		    <h5 class='text-center'><b>Guest Logs</b></h5><br>
            			<table class="table data-table table-hover table-sm">
						  	<thead>
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">Guest Name</th>
							      <th scope="col">From</th>
							      <th scope="col">Host</th>
							      <th scope="col">Department</th>
							      <th scope="col">Out</th>
							      <th scope="col">Time In</th>
							      <th scope="col">Time Out</th>
							      <th scope="col">Time Spent</th>
							      <th scope="col">Actions</th>
							    </tr>
						  	</thead>
						  	<tbody>
            		`;

            		response.data.forEach(function(item) {
                        var itemObj = JSON.stringify(item);
                        var timeOut = (item.time_out == '1000-01-01 00:00:00') ? 'n/a' : item.time_out;
                        var tableRowClass = "";
                        if (item.current_date) {
                            tableRowClass = "table-info";
                        }

            			template += `
                        <tr class=${tableRowClass}>
                          <th scope="row">${counter}</th>
                          <td>${item.name}</td>
                          <td>${item.origin}</td>
                          <td>${item.host_name}</td>
                          <td>${item.host_department}</td>
                          <td>${StringUCFirst(item.logged_out)}</td>
                          <td>${item.time_in}</td>
                          <td>${timeOut}</td>
                          <td>${item.time_spent}</td>
                          <td>
                            <div class="dropdown">
                                <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action <i class="fa fa-caret"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#" onclick='viewGuestDetails(${itemObj})'><small>View</small></a>
                                    <a class="dropdown-item" href="#"  onclick='notifyHost(${itemObj})'><small>Notify Host</small></a>
                                </div>
                            </div>
                          </td>
                        </tr>
            			`;
            			counter ++;
            		});
            	} else {
                    template += `
                        <br><br>
                        <div class='container-fluid'>
                            <h1 class='text-center text-grey'><i class='fa fa-child'></i></h1>
                            <h5 class="text-center text-grey">No guest records available</h5>
                        </div>
                    `;
            	}

                jQuery('.company-guest-logs-res').html(template);
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


// view guest details
function viewGuestDetails(itemObj) {
    jQuery(".guest-thumbnail").prop('src', itemObj.thumbnail);
    jQuery(".guest-name").html(itemObj.name);
    jQuery(".guest-origin").html(itemObj.origin);
    jQuery(".guest-code").html(itemObj.code);
    jQuery(".guest-host-name").html(itemObj.host_name);
    jQuery(".guest-host-dept").html(itemObj.host_department);
    jQuery(".guest-visit-reason").html(itemObj.visit_reason);
    jQuery(".guest-time-in").html(itemObj.time_in);
    jQuery(".guest-time-out").html(itemObj.time_out);
    jQuery(".guest-logged-out").html(StringUCFirst(itemObj.logged_out));
    jQuery("#view-guest-modal").modal("show");
}

// notify host of guest overstay
function notifyHost(itemObj) {
    if (itemObj.logged_out == 'yes') {
        showMessage("Action", "Guest has already logged out", "info");
    } else {
        var confirmNotification = confirm(`Are you sure you want to notify ${itemObj.host_name} of overstay of guest?`);
        if (confirmNotification) {
            showMessage("Action", `Notifying ${itemObj.host_name}...`, "info");
            var data = {
                '_token': jQuery('meta[name=csrf-token]').attr('content'),
                id: itemObj.id
            }

            jQuery.ajax({
                url: CONSTANTS.NOTIFY_COMPANY_HOST_URL,
                type: 'POST',
                data: data,
                beforeSend: function (xhr) {
                    xhr.setRequestHeader ("Authorization", "Bearer ")
                },
                success: function(response) {
                    if (response.success) {
                        showMessage("Action", response.message, "success")
                    } else {
                        showErrorMessage(response.message, 'Admin action');
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    jQuery(".edit-btn").html("Update").prop("disabled", false);
                console.log(XMLHttpRequest, textStatus, errorThrown);
                }
            });
        }
    }
}