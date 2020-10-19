<!DOCTYPE html>
<html>
    <head>
        <title>Amazing Technologies</title>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
    </head>
    <body style='margin: 0; padding: 0;'>
        <br><br>
        <table border='0' cellpadding='0' cellspacing='0' width='100%'>
            <tr>
                <td>
                    <table align='center' border='0' cellpadding='0' cellspacing='0' width='600' style='border-collapse: collapse;border: 1px solid #c0c0c0;'>
                    	<!-- Row 1 -->
                    	<tr>
                    		<td>
                    			<table border='0' cellpadding='0' cellspacing='0' width='100%'>
                    				<tr>
                    					<td width="33%"></td>
			                    		<td width="33%">
			                    			<div style="background: #ffffff;">
								                <img src='https://res.cloudinary.com/amazing-technologies/image/upload/v1557224965/logbook/logos/logo.png' alt='Amazing Technologies' style='display: block;width:150px; height: 150px;'>
								            </div>
			                    		</td>
			                    		<td width="33%"></td>
                    				</tr>
                    			</table>
                    		</td>
                    	</tr>
                    	<!-- Row 2 -->
                        <tr>
                            <td bgcolor='#ffffff' style='padding: 20px;'>
                                <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                    <tr>
                                        <td style='color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;'>
                                            <h2 style='text-align: center;'><b>{{ $title }}</b></h2><br>
                                            {{ $salutation }},
                                            <br><br>
                                            {!! $text !!}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- Row 3 -->
                        <tr>
                            <td bgcolor='#f7f7f7'>
                                <p style='text-align: center;font-family: Arial, sans-serif;'><small>&copy; <?php echo date('Y') ?> Amazing Technologies. All rights reserved</small></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>