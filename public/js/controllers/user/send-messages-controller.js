getSentCompanyMessages();

// add company department
jQuery(".send-message-form").on("submit", function(event) {
    event.preventDefault();

    var messageType = jQuery(".send-message-type").val(),
        messageContent= jQuery(".send-message-content").val().trim();

    if (messageType == -1 || messageType == null) {
        showMessage("Admin Action", "Please select message type", "warning");
    } else if (messageContent == "") {
        showMessage("Admin Action", "Please type message content", "warning");
    } else {
        jQuery(".add-btn").html("Sending...").prop("disabled", true);
        var data = {
			'_token': jQuery('meta[name=csrf-token]').attr('content'),
            messageType: messageType,
            messageContent: messageContent
		}

		jQuery.ajax({
            url: CONSTANTS.SEND_COMPANY_MESSAGE_URL,
            type: 'POST',
            data: data,
            beforeSend: function (xhr) {
                xhr.setRequestHeader ("Authorization", "Bearer ")
            },
            success: function(response) {
                console.log('hello mesg ', response);
                
                jQuery(".add-btn").html("Send Message").prop("disabled", false);
                if (response.success) {
                    showMessage("Action", response.message, "success")
                    getSentCompanyMessages();
                	setTimeout(function() {
                        jQuery('#send-message-modal').modal('hide');
                        jQuery(".send-message-form").trigger('reset');
                    }, 1300);
                } else {
                	showErrorMessage(response.message, 'Admin action');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                jQuery(".add-btn").html("Send Message").prop("disabled", false);
               console.log(XMLHttpRequest, textStatus, errorThrown);
            }
        });
    }
});

// get all sent companies of the company
function getSentCompanyMessages() {
    jQuery.ajax({
        url: CONSTANTS.GET_ALL_COMPANY_SENT_MESSAGES_URL,
        type: 'GET',
        beforeSend: function (xhr) {
            xhr.setRequestHeader ("Authorization", "Bearer ")
        },
        success: function(response) {
            console.log(response);
            
            if (response.success) {
            	var template = '';
            	var counter = 1;

            	if (response.data.length > 0) {

                    template += `
            		    <h5 class='text-center'><b>SENT MESSAGES</b></h5><br>
            			<table class="table table-striped data-table table-hover table-sm">
						  	<thead>
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">Message</th>
							      <th scope="col">Receipients</th>
							      <th scope="col">Date</th>
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
						      <td>${item.message}<e/td>
						      <td>${item.recipients}</td>
						      <td>${item.created_at}</td>
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
                            <h1 class='text-center text-grey'><i class='fa fa-send-o'></i></h1>
                            <h5 class="text-center text-grey">No messages have been sent yet</h5>
                        </div>
                    `;
            	}

                jQuery('.company-messages-res').html(template);
            } else {

            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           console.log(XMLHttpRequest, textStatus, errorThrown);
        }
    });
}