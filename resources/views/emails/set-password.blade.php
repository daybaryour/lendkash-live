<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html
  xmlns="http://www.w3.org/1999/xhtml"
  xmlns:v="urn:schemas-microsoft-com:vml"
  xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--
        <![endif]-->
        <title>Forget-Password | Lendkash</title>
    </head>
        <body>
            Hello {{$data['name']}},
            <div>
                <div style="color:#555555;line-height:120%; padding-right: 25px; padding-left: 25px; padding-top: 10px; padding-bottom: 10px;">
                    <div style="font-size:12px;line-height:14px;color:#555555;text-align:left;">
                        <p style="margin: 0;font-size: 14px;line-height: 17px">Your profile is successfully added in Savour platform.
                        <span style="font-size: 14px; line-height: 16px;"></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="">
                <div style="color:#555555;line-height:120%; padding-right: 25px; padding-left: 25px; padding-top: 10px; padding-bottom: 20px;">
                    <div style="font-size:12px;line-height:14px;color:#555555;text-align:left;">
                        <p style="margin: 0;font-size: 14px;line-height: 25px">You can set your password from below link and login with your registered Email
                            <b>{{$data['email']}}</b>.
                        </p>
                    </div>
                </div>
            </div>
            <div class="">
                <div style="color:#555555;line-height:120%; padding-right: 25px; padding-left: 25px; padding-top: 10px; padding-bottom: 20px;">
                    <div style="font-size:12px;line-height:14px;color:#555555;text-align:left;">
                        <p style="margin: 0;font-size: 14px;line-height: 14px">
                            <a style="color:#0068A5;text-decoration: underline;" title="password" href="{{$data['link']}}" target="_blank" rel="noopener" data-mce-selected="1">Set password</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="">
                <div style="color:#555555;line-height:120%; padding-right: 25px; padding-left: 25px; padding-top: 10px; padding-bottom: 10px;">
                    <div style="font-size:12px;line-height:14px;color:#555555;text-align:left;">
                        <p style="margin: 0;font-size: 12px;line-height: 14px">
                            <span style="font-size: 14px; line-height: 16px;">Regards, Savour</span>
                            <br>
                        </p>
                    </div>
                </div>
            </div>

        </body>
</html>
