// get all company departments
getCompanyDepartments();

// add company department
jQuery(".add-department-form").on("submit", function(event) {
    event.preventDefault();

    var departmentName = jQuery(".department-name").val().trim();

    if (departmentName == "") {
        showMessage("Admin Action", "Please enter departmenaName", "warning");
    }  else {
        jQuery(".add-btn").html("Adding...").prop("disabled", true);
        var data = {
			'_token': jQuery('meta[name=csrf-token]').attr('content'),
            departmentName: departmentName
		}

		jQuery.ajax({
            url: CONSTANTS.ADD_COMPANY_DEPARTMENT_URL,
            type: 'POST',
            data: data,
            beforeSend: function (xhr) {
                xhr.setRequestHeader ("Authorization", "Bearer ")
            },
            success: function(response) {
                jQuery(".add-btn").html("Add").prop("disabled", false);
                if (response.success) {
                    showMessage("Action", response.message, "success")
                    getCompanyDepartments();
                	setTimeout(function() {
                        jQuery('#add-department-modal').modal('hide');
                        jQuery(".add-department-form").trigger('reset');
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

// edit company department
jQuery(".edit-department-form").on("submit", function(event) {
    event.preventDefault();

    var departmentName = jQuery(".edit-department-name").val().trim(),
        departmentId = jQuery(".edit-department-id").val();

    if (departmentName == "") {
        showMessage("Admin Action", "Please enter departmenaName", "warning");
    }  else {
        jQuery(".edit-btn").html("Updating...").prop("disabled", true);
        var data = {
			'_token': jQuery('meta[name=csrf-token]').attr('content'),
            departmentName: departmentName,
            departmentId: departmentId
        }        

		jQuery.ajax({
            url: CONSTANTS.EDIT_COMPANY_DEPARTMENT_URL,
            type: 'POST',
            data: data,
            beforeSend: function (xhr) {
                xhr.setRequestHeader ("Authorization", "Bearer ")
            },
            success: function(response) {
                jQuery(".edit-btn").html("Update").prop("disabled", false);
                if (response.success) {
                    showMessage("Action", response.message, "success")
                    getCompanyDepartments();
                	setTimeout(function() {
                        jQuery('#edit-department-modal').modal('hide');
                        jQuery(".edit-department-form").trigger('reset');
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
})

// get all departments of the company
function getCompanyDepartments() {
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
            		    <h5 class='text-center'><b>Departments</b></h5><br>
            			<table class="table table-striped data-table table-hover table-sm">
						  	<thead>
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">Department Name</th>
							      <th scope="col">Actions</th>
							    </tr>
						  	</thead>
						  	<tbody>
            		`;

                    response.data.forEach(function(item) {
                        var itemObj = JSON.stringify(item);

                        var itemObj = JSON.stringify(item);

            			template += `
            				<tr>
						      <th scope="row">${counter}</th>
						      <td>${item.name}</td>
						      <td>
                                <a class='text-info action-btn' data-toggle='tooltip' title='edit department' onclick='showEditDepartmentModal(${itemObj})'><i class='fa fa-pencil'></i> edit</a>&nbsp;&nbsp;
                                <a class='text-danger action-btn' data-toggle='tooltip' title='delete department' onclick='deleteDepartment(${itemObj})'><i class='fa fa-trash-o'> delete</i></a>
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
                        <h1 class='text-center text-grey'><i class='fa fa-list-alt'></i></h1>
                        <h5 class="text-center text-grey">No departments have been added yet</h5>
                    </div>
                    `;
            	}

                jQuery('.company-departments-res').html(template);
            } else {

            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           console.log(XMLHttpRequest, textStatus, errorThrown);
        }
    });
}


// show edit department modal
function showEditDepartmentModal(itemObj) {
    jQuery(".edit-department-id").val(itemObj.id);
    jQuery(".edit-department-name").val(itemObj.name);
    jQuery("#edit-department-modal").modal("show");
}


// delete department
function deleteDepartment(itemObj) {
    var confirmDelete = confirm(`Are you sure you want to delete '${itemObj.name}' from the list of departments?`);
    if (confirmDelete) {
        showMessage("Action", "Deleting...", "info");
        var data = {
            '_token': jQuery('meta[name=csrf-token]').attr('content'),
            departmentId: itemObj.id
        }

        jQuery.ajax({
            url: CONSTANTS.DELETE_COMPANY_DEPARTMENT_URL,
            type: 'POST',
            data: data,
            beforeSend: function (xhr) {
                xhr.setRequestHeader ("Authorization", "Bearer ")
            },
            success: function(response) {
                console.log(response);
                
                if (response.success) {
                    showMessage("Action", response.message, "success")
                    getCompanyDepartments();
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

// filter items
jQuery("input.item-filter").keyup(function(event) {
    var searchTerm = event.target.value.trim();
    console.log(searchTerm)
    if (searchTerm != "") {
        var departmentNames = jQuery('.department-res-item-name');
        Array.from(departmentNames).forEach(function(departmentName) {
            const name = jQuery(departmentName).text();
            
            if (name.toUpperCase().indexOf(searchTerm.toUpperCase()) != -1) {
                jQuery(departmentName).addClass('match');
                jQuery(departmentNames).parent().hide();
                jQuery(departmentNames).filter('.match').parent().show();
            } else {
              console.log('not found')  
            }
        })
    } else {
        jQuery('.department-res-item-name').parent().show();
    }
})