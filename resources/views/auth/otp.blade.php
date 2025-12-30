<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Verification Code</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .email-wrapper {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #FF6B35 0%, #ff8c5a 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .header p {
            color: rgba(255, 255, 255, 0.9);
            margin: 10px 0 0;
            font-size: 16px;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .otp-box {
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(255, 140, 90, 0.05));
            border: 2px dashed #FF6B35;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
        }
        .otp-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .otp-code {
            font-size: 36px;
            font-weight: 700;
            color: #FF6B35;
            letter-spacing: 8px;
            margin: 0;
        }
        .expiry {
            font-size: 13px;
            color: #888;
            margin-top: 15px;
        }
        .expiry i {
            margin-right: 5px;
        }
        .message {
            color: #555;
            font-size: 15px;
            line-height: 1.8;
        }
        .warning {
            background: #fff8f0;
            border-left: 4px solid #FF6B35;
            padding: 15px;
            margin: 25px 0;
            font-size: 14px;
            color: #666;
            border-radius: 0 8px 8px 0;
        }
        .footer {
            background: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            margin: 5px 0;
            font-size: 13px;
            color: #888;
        }
        .footer a {
            color: #FF6B35;
            text-decoration: none;
        }
        .social-links {
            margin: 20px 0;
        }
        .social-links a {
            display: inline-block;
            width: 36px;
            height: 36px;
            background: #e5e7eb;
            border-radius: 50%;
            margin: 0 5px;
            line-height: 36px;
            color: #666;
            text-decoration: none;
        }
        .logo {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }
        .logo-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="email-wrapper">
            <div class="header">
                <div class="logo">
                    <div class="logo-icon">🐰</div>
                    ServiceRabbit
                </div>
                <h1>Email Verification</h1>
                <p>Complete your registration</p>
            </div>
            
            <div class="content">
                <p class="greeting">Hi {{ $user->first_name }},</p>
                
                <p class="message">
                    Thank you for signing up with Service Rabbit! To complete your registration and secure your account, please use the verification code below:
                </p>
                
                <div class="otp-box">
                    <p class="otp-label">Your Verification Code</p>
                    <p class="otp-code">{{ $otp }}</p>
                    <p class="expiry">⏱️ This code expires in 10 minutes</p>
                </div>
                
                <p class="message">
                    Enter this code on the verification page to activate your account and start exploring Service Rabbit.
                </p>
                
                <div class="warning">
                    <strong>🔒 Security Notice:</strong> Never share this code with anyone. Service Rabbit team will never ask for your verification code.
                </div>
                
                <p class="message">
                    If you didn't create an account with Service Rabbit, please ignore this email or contact our support team.
                </p>
            </div>
            
            <div class="footer">
                <p><strong>Service Rabbit</strong></p>
                <p>Your trusted marketplace for local services</p>
                <p style="margin-top: 20px;">
                    <a href="#">Help Center</a> | 
                    <a href="#">Privacy Policy</a> | 
                    <a href="#">Terms of Service</a>
                </p>
                <p style="margin-top: 15px; color: #aaa;">
                    © {{ date('Y') }} Service Rabbit. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>