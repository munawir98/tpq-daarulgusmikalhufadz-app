<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi - TPQ Digital</title>
</head>

<body
    style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f6f8f6;">
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation"
                    style="max-width: 480px; width: 100%; background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); overflow: hidden;">
                    <!-- Header -->
                    <tr>
                        <td
                            style="background: linear-gradient(135deg, #13ec5b 0%, #0fd650 100%); padding: 32px 24px; text-align: center;">
                            <h1 style="margin: 0; color: #102216; font-size: 24px; font-weight: 700;">
                                🕌 TPQ Digital
                            </h1>
                            <p style="margin: 8px 0 0 0; color: #102216; opacity: 0.8; font-size: 14px;">
                                Reset Kata Sandi
                            </p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 32px 24px;">
                            <p style="margin: 0 0 16px 0; color: #111813; font-size: 16px; line-height: 1.5;">
                                Assalamu'alaikum <strong>{{ $userName }}</strong>,
                            </p>
                            <p style="margin: 0 0 24px 0; color: #666; font-size: 14px; line-height: 1.6;">
                                Kami menerima permintaan untuk mereset kata sandi akun TPQ Anda. Gunakan kode verifikasi
                                berikut:
                            </p>

                            <!-- OTP Code -->
                            <div
                                style="background-color: #f6f8f6; border-radius: 12px; padding: 24px; text-align: center; margin: 24px 0;">
                                <p
                                    style="margin: 0 0 8px 0; color: #666; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">
                                    Kode Verifikasi
                                </p>
                                <div
                                    style="font-size: 36px; font-weight: 800; letter-spacing: 8px; color: #13ec5b; font-family: 'Courier New', monospace;">
                                    {{ $otp }}
                                </div>
                            </div>

                            <p style="margin: 24px 0 0 0; color: #666; font-size: 13px; line-height: 1.6;">
                                ⏱️ Kode ini berlaku selama <strong>5 menit</strong>.
                            </p>
                            <p style="margin: 8px 0 0 0; color: #666; font-size: 13px; line-height: 1.6;">
                                Jika Anda tidak meminta reset kata sandi, abaikan email ini.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background-color: #f6f8f6; padding: 20px 24px; text-align: center; border-top: 1px solid #e8f2ea;">
                            <p style="margin: 0; color: #999; font-size: 12px;">
                                © {{ date('Y') }} TPQ Daarul Gusmik Al-Hufadz
                            </p>
                            <p style="margin: 8px 0 0 0; color: #999; font-size: 11px;">
                                Email ini dikirim otomatis. Jangan membalas email ini.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
