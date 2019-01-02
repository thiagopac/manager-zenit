<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['invoice_mail_body'] = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Invoice</title>
	<style type="text/css">
		#outlook a {padding:0;} 
		body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;} 
		.ExternalClass {width:100%;}
		.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
		#backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
		img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;} 
		a img {border:none;} 
		.image_fix {display:block;}
		p {margin: 1em 0;}
		h1, h2, h3, h4, h5, h6 {color: black !important;}

		h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}

		h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
		color: red !important;
		}

		h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
		color: purple !important;
		}

		table td {border-collapse: collapse;}
    table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
		a {color: #0058A8;}

		@media only screen and (max-device-width: 480px) {
			
			a[href^="tel"], a[href^="sms"] {
						text-decoration: none;
						color: blue; 
						pointer-events: none;
						cursor: default;
					}

			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
						text-decoration: default;
						color: orange !important;
						pointer-events: auto;
						cursor: default;
					}

		}

		@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
			a[href^="tel"], a[href^="sms"] {
						text-decoration: none;
						color: blue; 
						pointer-events: none;
						cursor: default;
					}

			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
						text-decoration: default;
						color: orange !important;
						pointer-events: auto;
						cursor: default;
					}
		}

		@media only screen and (-webkit-min-device-pixel-ratio: 2) {
		}
		@media only screen and (-webkit-device-pixel-ratio:.75){
		}
		@media only screen and (-webkit-device-pixel-ratio:1){
		}
		@media only screen and (-webkit-device-pixel-ratio:1.5){
		}
	</style>
</head>
<body  style="background:#F8F8F8;" bgcolor="#F8F8F8">
<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable" align="center">
	<tr>
		<td valign="top"> 
		<table cellpadding="0" cellspacing="0" border="0" align="center">
			<tr><td width="600" height="50"></td></tr>
			<tr><td width="600" height="100">
			
			</td></tr>
			<tr>
				<td width="600" height="200" valign="top" style="background:#FFFFFF; border:1px solid #DDD; font-family:"Helvetica,Arial,sans-serif" bgcolor="#FFFFFF">
					<table cellpadding="0" cellspacing="0" border="0" align="center">
						<tr><td  width="560" height="10"></td></tr>
						<tr><td width="560" >
							<h4>Invoice</h4>
							<p style="font-size:12px">Hello {client_contact},</p>
							<p>please see your new invoice attached.
									<br>You can login to see the status of your project if you follow this link: <a href="{client_link}" style="color: #0eb6ce; text-decoration: none;">{client_link}</a>
									<br>
									Best regards,<br>
									{company}</p>
						</td></tr>
						<tr><td  width="560" height="10"></td></tr>
					</table>

				</td>
			</tr>
			<tr><td width="600" height="10"></td></tr>
			<tr>
				<td  align="right">
						{company}
					</td>
			</tr>
		</table>

		</td>
	</tr>
</table>  
</body>
</html>
';


$config['credentials_mail_body'] = '
    
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <title>
      Invoice
    </title>
	<style type="text/css">
	a:hover { text-decoration: none !important; }
	.header h1 {color: #444444 !important; font: bold 28px Helvetica, Arial, sans-serif; margin: 0; padding: 0; line-height: 40px;}
	.header p {color: #c6c6c6; font: normal 12px Helvetica, Arial, sans-serif; margin: 0; padding: 0; line-height: 18px;}

	.content h2 {color:#646464 !important; font-weight: bold; margin: 0; padding: 0; line-height: 26px; font-size: 18px; font-family: Helvetica, Arial, sans-serif;  }
	.content p {color:#767676; font-weight: normal; margin: 0; padding: 0; line-height: 20px; font-size: 12px;font-family: Helvetica, Arial, sans-serif;}
	.content a {color: #0eb6ce; text-decoration: none;}
	.footer p {font-size: 11px; color:#7d7a7a; margin: 0; padding: 0; font-family: Helvetica, Arial, sans-serif;}
	.footer a {color: #0eb6ce; text-decoration: none;}
	</style>
  
  
  		<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="padding: 35px 0;">
		  <tbody><tr>
		  	<td align="center" style="margin: 0; padding: 0;">
			    <table cellpadding="0" cellspacing="0" border="0" align="center" width="600" style="font-family: Helvetica, Arial, sans-serif; background-color:#f2f2f2; border-bottom:1px solid #DDDDDD" class="header">
			      	<tbody><tr>
						<td width="600" align="left" style=" padding: font-size: 0; line-height: 0; height: 7px;" height="7" colspan="2"></td>
				      </tr>
					<tr>
					<td width="20" style="font-size: 0px;"><b>&nbsp;</b></td>
			        <td width="580" align="left" style="padding: 18px 0 10px;">
						<h1 style="color: rgb(85, 85, 85); font-family: Helvetica, Arial, sans-serif; font-size: 28px; font-style: normal; font-variant: normal; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; line-height: 36px; "><span style="font-weight: normal;">Login Details</span></h1>
						<p style="color: #c6c6c6; font: normal 12px Helvetica, Arial, sans-serif; margin: 0; padding: 0; line-height: 18px;">{company}</p>
			        </td>
			      </tr>
				</tbody></table>
				<table cellpadding="0" cellspacing="0" border="0" align="center" width="600" style=" font-family: Helvetica, Arial, sans-serif; background: #fff;" bgcolor="#fff">
			      	
					<tbody><tr>
			        <td width="600" valign="top" align="left" style="font-family: Helvetica, Arial, sans-serif; padding: 20px 0 0;" class="content">
						<table cellpadding="0" cellspacing="0" border="0" style=" color: #717171; font: normal 11px Helvetica, Arial, sans-serif; margin: 0; padding: 0;" width="600">
						<tbody><tr>
							
							
							
						</tr>
						<tr>
							<td width="21" style="font-size: 1px; line-height: 1px;"></td>
							<td style="padding: 20px 0 0;" align="left">			
								<h2 style="color:#646464; font-weight: bold; margin: 0; padding: 0; line-height: 26px; font-size: 18px; font-family: Helvetica, Arial, sans-serif; ">Hello {client_contact},</h2>
							</td>
							<td width="21" style="font-size: 1px; line-height: 1px;"></td>
						</tr>
						<tr>
							<td width="21" style="font-size: 1px; line-height: 1px;"></td>
							<td style="padding: 15px 0 15px;" valign="top">
								<p style="color:#767676; font-weight: normal; margin: 0; padding: 0; line-height: 20px; font-size: 12px;font-family: Helvetica, Arial, sans-serif; ">
									your credentials are:<br>
									Username: {username}<br>
									Password: {password}<br>
									<br>Use this link to login: <a href="{client_link}" style="color: #0eb6ce; text-decoration: none;">{client_link}</a>
									<br>
									Best regards,<br>
									{company}

								</p><br>
								
							</td>
							<td width="21" style="font-size: 1px; line-height: 1px;"></td>
						</tr>
						
						</tbody></table>	
					</td>
					
			      </tr>
				  	<tr>
						
				      </tr>	
				</tbody></table>
				<table cellpadding="0" cellspacing="0" border="0" align="center" width="600" style="font-family: Helvetica, Arial, sans-serif; line-height: 10px;" class="footer"> 
				<tbody><tr>
			        <td align="center" style="padding: 5px 0 10px; font-size: 11px; color:#7d7a7a; margin: 0; line-height: 1.2;font-family: Helvetica, Arial, sans-serif;" valign="top">
						<br><p style="font-size: 11px; color:#7d7a7a; margin: 0; padding: 0; font-family: Helvetica, Arial, sans-serif;"></p>
						
					</td>
			      </tr>
				</tbody></table>
		  	</td>
		  	
		</tr>
    </tbody></table>
  ';