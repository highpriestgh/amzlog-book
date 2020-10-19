getAllCompanyAccounts();

jQuery(".add-company-account-form").on("submit", function(event) {
    event.preventDefault();

    var companyEmail = jQuery(".company-email").val().trim(),
        companyName = jQuery(".company-name").val().trim();

    if (companyEmail == "") {
        showMessage("Admin Action", "Please enter company email", "warning");
    } else if (companyName == "") {
        showMessage("Admin Action", "Please enter company name", "warning");
    } else {
        jQuery(".add-btn").html("Adding...").prop("disabled", true);
        var data = {
			'_token': jQuery('meta[name=csrf-token]').attr('content'),
            companyEmail: companyEmail,
            companyName: companyName
		}

		jQuery.ajax({
            url: ADMIN_CONSTANTS.REGISTER_COMPANY_ACCOUNT_URL,
            type: 'POST',
            data: data,
            beforeSend: function (xhr) {
                xhr.setRequestHeader ("Authorization", "Bearer ")
            },
            success: function(response) {
                jQuery(".add-btn").html("Add").prop("disabled", false);
                if (response.success) {
                    showMessage("Admin Action", response.message, "success")
                    getAllCompanyAccounts();
                	setTimeout(function() {
                        jQuery('#add-company-account-modal').modal('hide');
                        jQuery(".add-company-account-form").trigger('reset');
                    }, 2000);
                } else {
                	showErrorMessage(response.message, 'Admin action');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                jQuery(".add-btn").html("Add").prop("disabled", false);
               console.log(XMLHttpRequest, textStatus, errorThrown);
            }
        });
    }
})

// get all company accounts
function getAllCompanyAccounts() {
    jQuery.ajax({
        url: ADMIN_CONSTANTS.GET_ALL_COMPANY_ACCOUNTS_URL,
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
            		    <h5 class='text-center'><b>Company Accounts</b></h5><br>
            			<table class="table data-table table-hover">
						  	<thead>
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">Company Name</th>
							      <th scope="col">Email</th>
							      <th scope="col">Phone</th>
							      <th scope="col">Activation Token</th>
							      <th scope="col">Active</th>
							      <th scope="col">Created On</th>
							      <th scope="col">Actions</th>
							    </tr>
						  	</thead>
						  	<tbody>
            		`;

            		response.data.forEach(function(item) {
                        var itemObj = JSON.stringify(item);
                        var activationStatusString = (item.active == 'yes') ? 'deactivate' : 'activate';

            			template += `
                        <tr>
                          <th scope="row">${counter}</th>
                          <td>${truncateString(item.name, 20, 17)}</td>
                          <td>${truncateString(item.email, 20, 15)}</td>
                          <td>${truncateString(item.phone, 10, 7)}</td>
                          <td>${truncateString(item.token, 20, 15)}</td>
                          <td>${truncateString(item.active, 10, 7)}</td>
                          <td>${item.created_at.substr(0,10)}</td>
                          <td>
                            <a class='text-success action-btn' onclick='viewCompanyDetails(${itemObj})'><i class='fa fa-eye'></i> view</a>&nbsp;&nbsp;&nbsp;
                            <a class='text-info action-btn' onclick='changeCompanyActivationStatus(${itemObj})'><i class='fa fa-eye'></i> ${activationStatusString}</a>&nbsp;&nbsp;&nbsp;
                          </td>
                        </tr>
            			`;
            			counter ++;
            		});
            	} else {
                    template += `
                        <br><br>
                        <div class='container-fluid'>
                            <h1 class='text-center text-grey'><i class='fa fa-building-o'></i></h1>
                            <h5 class="text-center text-grey">No company accounts have been registered yet</h5>
                        </div>
                    `;
            	}

                jQuery('.company-accounts-res').html(template);
                jQuery(".data-table").DataTable();
            } else {

            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           console.log(XMLHttpRequest, textStatus, errorThrown);
        }
    });
}


function viewCompanyDetails(itemObj) {
    jQuery(".company-details-thumbnail").prop("src", itemObj.thumbnail);
    jQuery(".company-details-name").html(itemObj.name);
    jQuery(".company-details-email").html(itemObj.email);
    jQuery(".company-details-phone").html(itemObj.phone);
    jQuery(".company-details-location").html(itemObj.location);
    jQuery(".company-details-active").html(itemObj.active);
    jQuery("#view-company-account-modal").modal("show");
}


function changeCompanyActivationStatus(itemObj) {
    var activationStatusString = (itemObj.active == 'yes') ? 'deactivate' : 'activate';
    var confirmStatusUpdate = confirm(`Are you sure you want to ${activationStatusString} this account?`);
    if (confirmStatusUpdate) {
        var data = {
			'_token': jQuery('meta[name=csrf-token]').attr('content'),
            id: itemObj.id
        }
        
        jQuery.ajax({
            url: ADMIN_CONSTANTS.TOGGLE_COMPANY_ACCOUNT_STATUS_URL,
            type: 'POST',
            data: data,
            beforeSend: function (xhr) {
                xhr.setRequestHeader ("Authorization", "Bearer ")
            },
            success: function(response) {
                jQuery(".add-btn").html("Add").prop("disabled", false);
                if (response.success) {
                    showMessage("Admin Action", response.message, "success")
                    getAllCompanyAccounts();
                } else {
                    showErrorMessage(response.message, 'Admin action');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                jQuery(".add-btn").html("Add").prop("disabled", false);
               console.log(XMLHttpRequest, textStatus, errorThrown);
            }
        });
    }
}

