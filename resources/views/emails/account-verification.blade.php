<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        <meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=no'/>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'/>
        <title>Lendkash</title>

        <style type='text/css'>
            table         {mso-table-lspace:0pt;mso-table-rspace:0pt;}
            td,th	  {border-collapse:collapse;}
            td a img	  {text-decoration:none;border:none;}
        </style>


    </head>

    <body>
        <table align="center" cellspacing="0" cellpadding="0" width="730" style="table-layout:fixed;margin:0 auto;
        border:1px solid #2A05A7;border-collapse:collapse;padding:50px;font-family:Tahoma, Geneva, sans-serif;
        font-size:15px">
            <tbody>
            {{-- <tr bgcolor="#2A05A7">
                <td valign="middle" align="center" style="padding:15px 15px">
                    <img vspace="0" hspace="0" border="0" align="center" width="170" src="{{url('public/images/logo_email.png')}}"/>
                </td>
            </tr>  --}}
            <tr>
                <td valign="top" style="border:1px solid #2A05A7; padding:15px">
                    <p><strong>Dear {{ucfirst($data['name'])}}, </strong></p>
                    <p>Thank you for registering with Lendkash.</p>
                    <p>Your four digit verification code is <strong>{{$data['otp']}}.</strong> Please verify your email and start exploring Lendkash</p>


                        <p style="margin-top:5px;">Thank You</p>
                         <p style="margin-bottom:5px;"><b>Team Lendkash</b></p>
                    <p><a href="mailto:support@Lendkash.com" style="color:#EB8A7A;">support&#64;lendkash.com</a></p>
                </td>
            </tr>
                <tr bgcolor="#2A05A7"><td style="padding:10px 15px;color:#fff" align="center">Copyright &copy;2020 by <a style="color:#EB8A7A;" href="javascript:;" target="blank">Lendkash LLC </a></td></tr>
            </tbody>
        </table>
    </body>
</html>

