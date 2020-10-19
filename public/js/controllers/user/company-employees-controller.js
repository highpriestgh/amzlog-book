getCompanyEmployees();
getDepartmentsForForm();


// view image when selected
jQuery(".add-employee-thumbnail").on("change", function(){
    var imageSizeLimit = 3 * 1024 * 1024;
    var file = document.getElementById('add-employee-thumbnail').files;
    var fileLength = file.length;

    if (fileLength > 0) {
		if (file[0].size > imageSizeLimit) {
			showWarningMessage("Image cannot be greater than 3MB", "Admin Action");
		}  else {
            jQuery(".add-employee-thumbnail-label small").html("Profile Pic Selected");

            var reader = new FileReader();
            reader.onload = function (e) {
                jQuery(".add-employee-thumbnail-res").attr('src', e.target.result);
            }

            reader.readAsDataURL(file[0]);
		}
	}
});

jQuery(".edit-employee-thumbnail").on("change", function(){
    var imageSizeLimit = 3 * 1024 * 1024;
    var file = document.getElementById('edit-employee-thumbnail').files;
    var fileLength = file.length;

    if (fileLength > 0) {
		if (file[0].size > imageSizeLimit) {
			showWarningMessage("Image cannot be greater than 3MB", "Admin Action");
		}  else {
            jQuery(".edit-employee-thumbnail-label small").html("Profile Pic Selected");

            var reader = new FileReader();
            reader.onload = function (e) {
                jQuery(".edit-employee-thumbnail-res").attr('src', e.target.result);
            }

            reader.readAsDataURL(file[0]);
		}
	}
});

// get departments for form
function getDepartmentsForForm() {
    jQuery.ajax({
        url: CONSTANTS.GET_ALL_COMPANY_DEPARTMENTS_URL,
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
                        <option selected disabled>Select Department</option>
                    `;

                    response.data.forEach(function(item) {
                        template += `
                            <option value='${item.id}'>${item.name}</option>
                        `;
                    });
            	} else {
                    template += `
                        <option selected disabled>No Departments Available</option>
                    `;
            	}

                jQuery('.employee-departments-res').html(template);
            } else {

            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           console.log(XMLHttpRequest, textStatus, errorThrown);
        }
    });
}

// add employee
jQuery(".add-employee-form").on('submit', function(event) {
    event.preventDefault();

    var firstName = jQuery(".employee-first-name").val().trim(),
        lastName = jQuery(".employee-last-name").val().trim(),
        number = jQuery(".employee-number").val().trim(),
        dateOfBirth = jQuery(".employee-dob").val().trim(),
        phone = jQuery(".employee-phone").val().trim(),
        email = jQuery(".employee-email").val().trim(),
        department = jQuery(".employee-dept").val().trim(),
        type = jQuery(".employee-type").val().trim(),
        position = jQuery(".employee-position").val().trim(),
        thumbnail = document.getElementById('add-employee-thumbnail').files;

    if (firstName == "") {
        showMessage("Admin", "Please enter first name","warning");
    } else if (lastName == "") {
        showMessage("Admin", "Please enter last name","warning");
    } else if (number == "") {
        showMessage("Admin", "Please employee number","warning");
    } else if (dateOfBirth == "") {
        showMessage("Admin", "Please select employee date of birth","warning");
    } else if (email == "") {
        showMessage("Admin", "Please enter employee email address","warning");
    } else if (phone == "") {
        showMessage("Admin", "Please enter employee phone number","warning");
    } else if (department == null || department == undefined || department == -1) {
        showMessage("Admin", "Please select department","warning");
    } else if (type == null || type == undefined || type == -1) {
        showMessage("Admin", "Please select employee type","warning");
    } else if (position == "") {
        showMessage("Admin", "Please enter employee position","warning");
    } else {
        jQuery(".add-btn").html("Adding...").prop("disabled", true);
        var formData = new FormData();
        formData.append('_token', jQuery('meta[name=csrf-token]').attr('content'));
        formData.append('firstName', firstName);
        formData.append('lastName', lastName);
        formData.append('number', number);
        formData.append('email', email);
        formData.append('dateOfBirth', dateOfBirth);
        formData.append('phone', phone);
        formData.append('department', department);
        formData.append('type', type);
        formData.append('position', position);

        if (thumbnail.length > 0) {
            formData.append('thumbnail', thumbnail[0]);
            console.log('data added')
        }

        jQuery.ajax({
            url: CONSTANTS.ADD_COMPANY_EMPLOYEE_URL,
            type: 'POST',
            processData: false,
            contentType: false,
            data: formData,
            beforeSend: function (xhr) {
                xhr.setRequestHeader ("Authorization", "Bearer ")
            },
            success: function(response) {
                console.log(response);
                
                jQuery(".add-btn").html("Add").prop("disabled", false);
                if (response.success) {
                    showMessage("Action", response.message, "success")
                    getCompanyEmployees();
                	setTimeout(function() {
                        jQuery('#add-employee-modal').modal('hide');
                        jQuery(".add-employee-form").trigger('reset');
                    }, 1300);
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

});


// edit employee
jQuery(".edit-employee-form").on('submit', function(event) {
    event.preventDefault();

    var firstName = jQuery(".edit-employee-first-name").val().trim(),
        lastName = jQuery(".edit-employee-last-name").val().trim(),
        number = jQuery(".edit-employee-number").val().trim(),
        dateOfBirth = jQuery(".edit-employee-dob").val().trim(),
        phone = jQuery(".edit-employee-phone").val().trim(),
        email = jQuery(".edit-employee-email").val().trim(),
        department = jQuery(".edit-employee-dept").val().trim(),
        type = jQuery(".edit-employee-type").val().trim(),
        position = jQuery(".edit-employee-position").val().trim(),
        id = jQuery(".edit-employee-id").val(),
        thumbnail = document.getElementById('edit-employee-thumbnail').files;

    if (firstName == "") {
        showMessage("Admin", "Please enter first name","warning");
    } else if (lastName == "") {
        showMessage("Admin", "Please enter last name","warning");
    } else if (number == "") {
        showMessage("Admin", "Please employee number","warning");
    } else if (dateOfBirth == "") {
        showMessage("Admin", "Please select employee date of birth","warning");
    } else if (email == "") {
        showMessage("Admin", "Please enter employee email address","warning");
    } else if (phone == "") {
        showMessage("Admin", "Please enter employee phone number","warning");
    } else if (department == null || department == undefined || department == -1) {
        showMessage("Admin", "Please select department","warning");
    } else if (type == null || type == undefined || type == -1) {
        showMessage("Admin", "Please select employee type","warning");
    } else if (position == "") {
        showMessage("Admin", "Please enter employee position","warning");
    } else {
        jQuery(".edit-btn").html("Updating...").prop("disabled", true);
        var formData = new FormData();
        formData.append('_token', jQuery('meta[name=csrf-token]').attr('content'));
        formData.append('firstName', firstName);
        formData.append('lastName', lastName);
        formData.append('number', number);
        formData.append('email', email);
        formData.append('dateOfBirth', dateOfBirth);
        formData.append('phone', phone);
        formData.append('department', department);
        formData.append('type', type);
        formData.append('position', position);
        formData.append('id', id);

        if (thumbnail.length > 0) {
            formData.append('thumbnail', thumbnail[0]);
            console.log('data added')
        }

        jQuery.ajax({
            url: CONSTANTS.EDIT_COMPANY_EMPLOYEE_URL,
            type: 'POST',
            processData: false,
            contentType: false,
            data: formData,
            beforeSend: function (xhr) {
                xhr.setRequestHeader ("Authorization", "Bearer ")
            },
            success: function(response) {
                console.log(response);
                
                jQuery(".edit-btn").html("Update").prop("disabled", false);
                if (response.success) {
                    showMessage("Action", response.message, "success")
                    getCompanyEmployees();
                	setTimeout(function() {
                        jQuery('#edit-employee-modal').modal('hide');
                        jQuery(".edit-employee-form").trigger('reset');
                    }, 1300);
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

});


// get all employees of the company
function getCompanyEmployees() {
    jQuery.ajax({
        url: CONSTANTS.GET_ALL_COMPANY_EMPLOYEES_URL,
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
            		    <h5 class='text-center'><b>Employees</b></h5><br>
            			<table class="table table-striped data-table table-hover table-sm">
						  	<thead>
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">Photo</th>
							      <th scope="col">F Name</th>
							      <th scope="col">L Name</th>
							      <th scope="col">Active</th>
							      <th scope="col">Department</th>
							      <th scope="col">Position</th>
							      <th scope="col">Actions</th>
							    </tr>
						  	</thead>
						  	<tbody>
            		`;

                    response.data.forEach(function(item) {
                        var itemObj = JSON.stringify(item);
                        var activeStatusString = (item.active == 'yes') ? 'Disable' : 'Enable';
                        var activeStatusIndicator = (item.active == 'yes') ? "<small><i class='fa text-info fa-check'></i></small>" : "<small><i class='text-danger fa fa-times'></i></span></small>"
                        template += `
            				<tr>
						      <th scope="row">${counter}</th>
						      <td><img class='img-fluid rounded-circle employee-res-img' src='${item.thumbnail}'></td>
						      <td>${item.first_name}</td>
						      <td>${item.last_name}</td>
						      <td>${activeStatusIndicator}</td>
						      <td>${item.department_name}</td>
						      <td>${item.position}</td>
                              <td>
                                <a class='action-btn text-success' onclick='showViewEmployeeModal(${itemObj})'><i class='fa fa-eye'></i> view</a>&nbsp;&nbsp;&nbsp;
                                <a class='action-btn text-info' onclick='showEditEmployeeModal(${itemObj})'><i class='fa fa-info'></i> edit</a>&nbsp;&nbsp;&nbsp;
                                <a class='action-btn text-danger' onclick='deleteEmployee(${itemObj})'><i class='fa fa-trash-o'></i> delete</a>&nbsp;&nbsp;&nbsp;
                                <a class='action-btn text-warning' onclick='toggleEmployeeActiveStatus(${itemObj})'><i class='fa fa-ban'></i> ${activeStatusString}</a>
						      </td>
						    </tr>
            			`;

            			counter ++;
                    });

                    template += `
            			</tbody>
            			</table>
                    `;
                    
            	} else {
                    template += `
                        <div class='container-fluid'>
                            <h1 class='text-center text-grey'><i class='fa fa-users'></i></h1>
                            <h5 class="text-center text-grey">No employees have been added yet</h5>
                        </div>
                    `;
            	}

                jQuery('.company-employees-res').html(template);
            } else {

            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           console.log(XMLHttpRequest, textStatus, errorThrown);
        }
    });
}


function showViewEmployeeModal(itemObj) {
    jQuery(".employee-detail-img").prop("src", itemObj.thumbnail);
    jQuery(".employee-name").html(itemObj.first_name + ' ' + itemObj.last_name);
    jQuery(".employee-email").html(itemObj.email);
    jQuery(".employee-phone").html(itemObj.phone);
    jQuery(".employee-number").html(itemObj.number);
    jQuery(".employee-department").html(itemObj.department_name);
    jQuery(".employee-position").html(itemObj.position);
    jQuery(".employee-dob").html(itemObj.date_of_birth);
    jQuery(".employee-active").html(itemObj.active);
    jQuery(".employee-type").html(itemObj.type);
    jQuery("#view-employee-modal").modal("show");
}

function showEditEmployeeModal(itemObj) {
    jQuery(".edit-employee-first-name").val(itemObj.first_name);
    jQuery(".edit-employee-last-name").val(itemObj.last_name);
    jQuery(".edit-employee-number").val(itemObj.number);
    jQuery(".edit-employee-dob").val(itemObj.date_of_birth);
    jQuery(".edit-employee-phone").val(itemObj.phone);
    jQuery(".edit-employee-email").val(itemObj.email);
    jQuery(".edit-employee-dept").val(itemObj.department);
    jQuery(".edit-employee-type").val(itemObj.type);
    jQuery(".edit-employee-position").val(itemObj.position);
    jQuery(".edit-employee-thumbnail-res").prop('src', itemObj.thumbnail);
    jQuery(".edit-employee-id").val(itemObj.id);
    jQuery("#edit-employee-modal").modal("show");
}

function deleteEmployee(itemObj) {
    var confirmDelete = confirm(`Are you sure you want to delete this account?`);
    if (confirmDelete) {
        showMessage("Action", "Deleting...", "info");
        var data = {
            '_token': jQuery('meta[name=csrf-token]').attr('content'),
            id: itemObj.id
        }

        jQuery.ajax({
            url: CONSTANTS.DELETE_COMPANY_EMPLOYEE_URL,
            type: 'POST',
            data: data,
            beforeSend: function (xhr) {
                xhr.setRequestHeader ("Authorization", "Bearer ")
            },
            success: function(response) {
                console.log(response);
                
                if (response.success) {
                    showMessage("Action", response.message, "success")
                    getCompanyEmployees();
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

function toggleEmployeeActiveStatus(itemObj) {
    var activeStatusString = (itemObj.active == 'yes') ? 'disable' : 'enable';
    var confirmToggle = confirm(`Are you sure you want to ${activeStatusString} this account?`);
    if (confirmToggle) {
        showMessage("Action", "Updating status...", "info");
        var data = {
            '_token': jQuery('meta[name=csrf-token]').attr('content'),
            id: itemObj.id
        }

        jQuery.ajax({
            url: CONSTANTS.TOGGLE_COMPANY_EMPLOYEE_ACTIVE_STATUS_URL,
            type: 'POST',
            data: data,
            beforeSend: function (xhr) {
                xhr.setRequestHeader ("Authorization", "Bearer ")
            },
            success: function(response) {
                console.log(response);
                
                if (response.success) {
                    showMessage("Action", response.message, "success")
                    getCompanyEmployees();
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