<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact form response</title>
    <style>
        .panel {
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid transparent;
            border-radius: 4px;
            -webkit-box-shadow: -7px 12px 34px 0px rgba(0,0,0,0.2), 0px 1px 0px 0px rgba(156,172,186,0.2);
            box-shadow: -7px 12px 34px 0px rgba(0,0,0,0.2), 0px 1px 0px 0px rgba(156,172,186,0.2);
            max-width: 720px;
            font-family: Helvetica, Arial, sans-serif;
        }

        .panel-default {
            border-color: #ddd;
        }

        .panel-default > .panel-heading {
            color: #333;
            background-color: #f5f5f5;
            border-color: #ddd;
        }

        .panel-heading {
            padding: 10px 15px;
            border-bottom: 1px solid transparent;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
            text-align: left;
        }

        .panel-body {
            padding: 15px;
        }

        p {
            text-align: left;
            color: gray;
        }

        .reset-btn {
            color: #fff;
            background-color: #e15501;
            border-color: orange;
            text-align: center;
            -ms-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: 100%;
            font-size: 12px;
            font-smoothing: always;
            font-style: normal;
            font-weight: 600;
            letter-spacing: 0.7px;
            line-height: 48px;
            mso-line-height-rule: exactly;
            text-decoration: none;
            vertical-align: top;
            width: 220px;
            border-radius: 28px;
            display: block;
            text-align: center;
            text-transform: uppercase;

        }

        .padding-15px {
            padding: 15px;
        }

        .padding-15px-top {
            padding-top: 15px;
        }
    </style>

</head>
<body style="padding: 15px">
<div align="center">
    <div class="panel panel-default" style="border: 1px solid #ddd;">
        <div class="panel-body">

            <p class="padding-15px-top">
                Hi Admin,
            </p>
            <p>
                {{$mailData['Name']}} has filled in the contact page with the current info.
            </p>

            <fieldset align="left">
                <legend>
                   <span style="font-weight:bold; padding-left: 5px; padding-right: 5px">
                       Details:
                   </span>
                </legend>
                <table style="width:100%">
                    <tr>
                        <td style="font-weight: bold;">Name</td>
                        <td>{{$mailData['Name']}}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; white-space: nowrap;">E-mailaddress</td>
                        <td>{{$mailData['email']}}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Concern type</td>
                        <td>{{$mailData['concern_type']}}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Category</td>
                        <td>{{$mailData['category']}}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Device</td>
                        <td>{{$mailData['device']}}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Text</td>
                        <td>{{$mailData['text']}}</td>
                    </tr>
                </table>
            </fieldset>
            <br/>
            <p>
                Kind regards,<br>
                Company
            </p>

        </div>
    </div>
    Company © {{ date('Y') }}
    <br>
    <br>
</div>
</body>
