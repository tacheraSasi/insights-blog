<!DOCTYPE html>
<html>
<head>
    <title>{{ $subject }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f5f5f5;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <!-- Main Card -->
                <table width="100%" max-width="600px" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #428d5c; padding: 32px 40px; text-align: center;">
                            <div style="text-align: center;">
                                <img src="https://insights.ekilie.com/assets/img/icon.png" alt="Logo" style="width: 80px; height: auto; margin-bottom: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                <h1 style="color: #ffffff; margin: 0; font-size: 26px; font-weight: 700; letter-spacing: -0.5px; line-height: 1.4;">
                                    {{ config('app.name') }} Ekilie
                                </h1>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Content Section -->
                    <tr>
                        <td style="padding: 40px 40px 32px;">
                            <div style="color: #333333; line-height: 1.6; font-size: 16px;">
                                {!! nl2br(e($messageContent)) !!}
                            </div>
                        </td>
                    </tr>

                    <!-- Unsubscribe Section -->
                    <tr>
                        <td style="padding: 24px 40px 0; border-top: 1px solid #e9ecef;">
                            <p style="margin: 0; color: #6c757d; font-size: 12px; line-height: 1.5;">
                                This email was automatically sent by Ekilie's AI Agent<br>
                                <a href="https://insights.ekilie.com/unsubscribe" style="color: #428d5c; text-decoration: none; font-weight: 500;">Unsubscribe</a> | 
                                <a href="https://insights.ekilie.com" style="color: #428d5c; text-decoration: none; font-weight: 500;">Visit Insights</a>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 24px 40px; background-color: #f8f9fa;">
                            <p style="margin: 0; color: #6c757d; font-size: 12px; line-height: 1.5; text-align: center;">
                                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.<br>
                                <span style="font-size: 11px; color: #868e96;">Dar Es Salaam Tanzania</span>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>