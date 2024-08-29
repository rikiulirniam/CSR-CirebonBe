<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin: 0; padding: 0;height: 520px; font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333333;">
    <table role="presentation" height="100%" width="100%" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-collapse: collapse; border-spacing: 0;">
        <tr>
            <td style="padding: 20px; text-align: center;">
                <h1 style="color: #333333; font-size: 24px; margin: 0;">Hi, {{ $user->name }}</h1>
                <p style="color: #666666; font-size: 16px; line-height: 1.5; margin: 20px 0;">
                    Terima kasih telah mendaftar. Silakan klik tautan di bawah ini untuk mengaktivasi akun Anda:
                </p>
                <a href="{{ $verificationUrl }}" style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #ffffff; background-color: #98100A; text-decoration: none; border-radius: 5px;">Verifikasi Email</a>
                <p style="color: #666666; font-size: 14px; margin-top: 20px;">
                    Jika Anda tidak melakukan pendaftaran ini, abaikan email ini.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
