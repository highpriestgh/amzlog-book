getDashboardGuestRateGraph();

function getDashboardGuestRateGraph() {
    jQuery.ajax({
        url: CONSTANTS.GET_DASHBOARD_GUEST_RATE_DATA_URL,
        type: 'GET',
        beforeSend: function (xhr) {
            xhr.setRequestHeader ("Authorization", "Bearer ")
        },
        success: function(response) {
            if (response.success) {
                var ctx = document.getElementById('guestRateChart').getContext('2d');
                drawAreaChart(ctx, response.data.label, response.data.data, 'Monthly Guest Visit Rate');
            } else {
                
            }            
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            jQuery(".add-btn").html("Add").prop("disabled", false);
           console.log(XMLHttpRequest, textStatus, errorThrown);
        }
    });
}

function genPDF() {
	var pdf = new jsPDF('p', 'pt', 'a4');
    pdf.addHTML(jQuery('.content')[0], function () {
        pdf.save('Test.pdf');
    });
	
}