/**
 * Show logo thumbnail when  selected
 */
jQuery(".update-company-thumbnail").on("change", function(){
    var imageSizeLimit = 3 * 1024 * 1024;
    var file = document.getElementById('update-company-thumbnail').files;
    var fileLength = file.length;

    if (fileLength > 0) {
		if (file[0].size > imageSizeLimit) {
			showWarningMessage("Image cannot be greater than 3MB", "Admin Action");
		}  else {
            jQuery(".update-company-thumbnail-label small").html("Logo Selected");

            var reader = new FileReader();
            reader.onload = function (e) {
                jQuery(".update-company-thumbnail-res").attr('src', e.target.result);
            }

            reader.readAsDataURL(file[0]);
		}
	}
});

// company logo setting form
jQuery(".company-logo-update-form").on("submit", function(event) {
    event.preventDefault();

    var thumbnail = document.getElementById('update-company-thumbnail').files;
    if (thumbnail.length < 1) {
        showMessage("Admin Action", "Please select thumbnail", "warning");
    } else {
        jQuery(".logo-reset-btn").html("Updating...").prop("disabled", true);
        var formData = new FormData();
        formData.append('_token', jQuery('meta[name=csrf-token]').attr('content'))
        formData.append('thumbnail', thumbnail[0]);

        jQuery.ajax({
            url: CONSTANTS.RESET_COMPANY_LOGO_URL,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader ("Authorization", "Bearer ")
            },
            success: function(response) {
                jQuery(".logo-reset-btn").html("Update").prop("disabled", false);
                if (response.success) {
                	showMessage("Admin Action", response.message, "success");
                } else {
                	showMessage('Admin action',response.message, 'error');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                jQuery(".logo-reset-btn").html("Update").prop("disabled", false);
               console.log(XMLHttpRequest, textStatus, errorThrown);
            }
        });
    }
});

// doctor personnal info setting form
jQuery(".doctor-personal-details-form").on("submit", function(event) {
    event.preventDefault();

    var name = jQuery(".name").val().trim(),
        email = jQuery(".email").val().trim(),
        phone = jQuery(".phone").val().trim(),
        location = jQuery(".location").val().trim();

    if (name == "") {
        showMessage("Account Settings", "Please enter company name","warning");
    } else if (email == "") {
        showMessage("Account Settings", "Please enter email","warning");
    } else{
        jQuery(".details-reset-btn").html("Updating...").prop("disabled", true);
        if (phone == "") {
            phone = "n/a";
        }

        if (location == "") {
            location = "n/a";
        }

        var data = {
            _token: jQuery('meta[name=csrf-token]').attr('content'),
            name: name,
            email: email,
            phone: phone,
            location: location
        }

        jQuery.ajax({
            url: CONSTANTS.RESET_COMPANY_DETAILS_URL,
            type: 'POST',
            data: data,
            beforeSend: function (xhr) {
                xhr.setRequestHeader ("Authorization", "Bearer ")
            },
            success: function(response) {                
                jQuery(".details-reset-btn").html("Update").prop("disabled", false);
                if (response.success) {
                    showMessage("Account Settings", response.message, "success")
                } else {
                    showMessage('Account Settings',response.message, 'error');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                jQuery(".details-reset-btn").html("Update").prop("disabled", false);
                console.log(XMLHttpRequest, textStatus, errorThrown);
            }
        });
    }
})

// user password settings form
jQuery(".doctor-password-reset-form").on("submit",function(event) {
    event.preventDefault();

    var currentPassword = jQuery(".current-password").val().trim(),
        newPassword = jQuery(".new-password").val().trim(),
        confirmNewPassword = jQuery(".new-password-conf").val().trim();

    if (currentPassword == "") {
        showMessage("Account Settings", "Please enter current password", "warning")
    } else if (newPassword == "") {
        showMessage("Account Settings", "Please enter new password", "warning")
    } else if (confirmNewPassword == "") {
        showMessage("Account Settings", "Please confirm new password", "warning")
    } else if (newPassword.length < 8) {
        showMessage("Account Settings", "New password must contain at least eight characters", "warning")
    } else if (newPassword != confirmNewPassword) {
        showMessage("Account Settings", "New password does not match confirmation password", "warning")
    } else {
        jQuery(".password-reset-btn").html("Updating...").prop("disabled", true);
        var data = {
            _token: jQuery('meta[name=csrf-token]').attr('content'),
            currentPassword: currentPassword,
            newPassword: newPassword,
            confirmNewPassword: confirmNewPassword
        }

        jQuery.ajax({
            url: CONSTANTS.RESET_COMPANY_PASSWORD_URL,
            type: 'POST',
            data: data,
            beforeSend: function (xhr) {
                xhr.setRequestHeader ("Authorization", "Bearer ")
            },
            success: function(response) {
                jQuery(".password-reset-btn").html("Update").prop("disabled", false);
                if (response.success) {
                	showMessage("Account Settings", response.message, "success")
                	setTimeout(function() {
                        jQuery(".user-password-reset-form").trigger('reset');
                    }, 2000);
                } else {
                	showMessage('Account Settings',response.message, 'error');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                jQuery(".password-reset-btn").html("Update").prop("disabled", false);
                console.log(XMLHttpRequest, textStatus, errorThrown);
            }
        });
    }
})