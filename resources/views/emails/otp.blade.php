<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f4f4; padding: 20px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #FF6B35, #ff8c5a); padding: 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px;">🐰 Service Rabbit</h1>
                            <p style="color: rgba(255,255,255,0.9); margin: 10px 0 0; font-size: 16px;">Email Verification</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="font-size: 18px; color: #333; margin: 0 0 20px;">
                                Hi <strong>{{ $user->first_name }}</strong>,
                            </p>
                            
                            <p style="font-size: 16px; color: #555; line-height: 1.6; margin: 0 0 30px;">
                                Thank you for signing up with Service Rabbit! Please use the verification code below to complete your registration:
                            </p>
                            
                            <!-- OTP Box -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center">
                                        <div style="background: linear-gradient(135deg, rgba(255,107,53,0.1), rgba(255,140,90,0.05)); border: 2px dashed #FF6B35; border-radius: 12px; padding: 30px; display: inline-block;">
                                            <p style="color: #666; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 10px;">Your Verification Code</p>
                                            <p style="color: #FF6B35; font-size: 36px; font-weight: bold; letter-spacing: 8px; margin: 0;">{{ $otp }}</p>
                                            <p style="color: #888; font-size: 13px; margin: 15px 0 0;">⏱️ Expires in 10 minutes</p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="font-size: 16px; color: #555; line-height: 1.6; margin: 30px 0;">
                                Enter this code on the verification page to activate your account.
                            </p>
                            
                            <!-- Warning -->
                            <div style="background: #fff8f0; border-left: 4px solid #FF6B35; padding: 15px; margin: 25px 0; border-radius: 0 8px 8px 0;">
                                <p style="color: #666; font-size: 14px; margin: 0;">
                                    <strong>🔒 Security Notice:</strong> Never share this code with anyone. Service Rabbit team will never ask for your verification code.
                                </p>
                            </div>
                            
                            <p style="font-size: 14px; color: #888; margin: 0;">
                                If you didn't create an account, please ignore this email.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background: #f9fafb; padding: 20px 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="color: #888; font-size: 13px; margin: 0;">
                                © {{ date('Y') }} Service Rabbit. All rights reserved.
                            </p>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>