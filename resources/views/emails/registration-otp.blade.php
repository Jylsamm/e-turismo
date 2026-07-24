<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>E-Turismo Verification Code</title>
</head>
<body style="margin:0;padding:0;background-color:#f0fdf4;font-family:'Segoe UI',Arial,sans-serif;">

  <!-- Outer wrapper -->
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
         style="background-color:#f0fdf4;padding:40px 16px;">
    <tr>
      <td align="center">

        <!-- Card -->
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
               style="max-width:560px;width:100%;border-radius:20px;overflow:hidden;
                      box-shadow:0 8px 40px rgba(11,61,46,0.13);">

          <!-- ── Header gradient ── -->
          <tr>
            <td align="center"
                style="background:linear-gradient(135deg,#0B3D2E 0%,#166534 45%,#16a34a 80%,#4ADE80 100%);
                       padding:36px 32px 28px;">

              <!-- Logo (embedded inline via CID — works in all email clients without external fetch) -->
              @php
                $logoPath = public_path('Pictures/LOGO/LOGO-eturismo3.png');
              @endphp
              @if(file_exists($logoPath) && isset($message))
              <img src="{{ $message->embed($logoPath) }}"
                   alt="E-Turismo"
                   width="160"
                   height="40"
                   style="display:block;margin:0 auto 20px;max-width:160px;height:auto;border:none;" />
              @else
              <p style="margin:0 0 20px;color:#4ade80;font-size:18px;font-weight:900;letter-spacing:.05em;">
                E-TURISMO
              </p>
              @endif

              <!-- Title -->
              <h1 style="margin:0;color:#ffffff;font-size:22px;font-weight:800;
                         letter-spacing:-.3px;line-height:1.3;">
                Email Verification Code
              </h1>
              <p style="margin:8px 0 0;color:#bbf7d0;font-size:14px;line-height:1.6;">
                E-Turismo Digital Tourism Portal
              </p>
            </td>
          </tr>

          <!-- ── Body ── -->
          <tr>
            <td style="background:#ffffff;padding:36px 36px 28px;">

              <p style="margin:0 0 20px;color:#374151;font-size:15px;line-height:1.7;">
                Hello! You're just one step away from completing your
                <strong style="color:#065f46;">E-Turismo</strong> registration.
                Use the verification code below to confirm your Gmail address.
              </p>

              <!-- OTP Box -->
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td align="center" style="padding:8px 0 28px;">

                    <div style="display:inline-block;background:linear-gradient(135deg,#f0fdf4,#dcfce7);
                                border:2px solid #16a34a;border-radius:16px;
                                padding:28px 48px;text-align:center;
                                box-shadow:0 4px 20px rgba(22,163,74,0.15);">

                      <p style="margin:0 0 8px;color:#065f46;font-size:11px;font-weight:700;
                                 letter-spacing:.12em;text-transform:uppercase;">
                        Your Verification Code
                      </p>

                      <div style="font-size:48px;font-weight:900;letter-spacing:12px;
                                  color:#0B3D2E;line-height:1.1;font-family:'Courier New',monospace;">
                        {{ $otp }}
                      </div>

                      <p style="margin:12px 0 0;color:#16a34a;font-size:12px;font-weight:600;">
                        ⏱ Valid for <strong>10 minutes</strong>
                      </p>
                    </div>

                  </td>
                </tr>
              </table>

              <!-- Steps hint -->
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                     style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;
                            margin-bottom:24px;">
                <tr>
                  <td style="padding:18px 20px;">
                    <p style="margin:0 0 10px;color:#0f172a;font-size:13px;font-weight:700;">
                      How to use this code:
                    </p>
                    <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td style="padding:3px 0;color:#475569;font-size:13px;line-height:1.6;">
                          <span style="color:#16a34a;font-weight:700;margin-right:6px;">1.</span>
                          Go back to the E-Turismo registration page
                        </td>
                      </tr>
                      <tr>
                        <td style="padding:3px 0;color:#475569;font-size:13px;line-height:1.6;">
                          <span style="color:#16a34a;font-weight:700;margin-right:6px;">2.</span>
                          Enter the 6-digit code in the verification field
                        </td>
                      </tr>
                      <tr>
                        <td style="padding:3px 0;color:#475569;font-size:13px;line-height:1.6;">
                          <span style="color:#16a34a;font-weight:700;margin-right:6px;">3.</span>
                          Click <strong>Verify</strong> to unlock the rest of the form
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>

              <!-- Warning note -->
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                     style="background:#fff7ed;border:1px solid #fed7aa;border-radius:10px;
                            margin-bottom:24px;">
                <tr>
                  <td style="padding:14px 18px;">
                    <p style="margin:0;color:#92400e;font-size:12.5px;line-height:1.6;">
                      ⚠️ <strong>Didn't request this?</strong>
                      If you did not attempt to register on E-Turismo, you can safely ignore this email.
                      Your account will not be created.
                    </p>
                  </td>
                </tr>
              </table>

              <p style="margin:0;color:#94a3b8;font-size:12px;line-height:1.6;text-align:center;">
                This is an automated email — please do not reply.
              </p>

            </td>
          </tr>

          <!-- ── Footer ── -->
          <tr>
            <td align="center"
                style="background:#052e16;padding:22px 32px;">
              <p style="margin:0 0 4px;color:#ffffff;font-size:13px;font-weight:700;">
                Tigbao E-Turismo Digital Tourism Portal
              </p>
              <p style="margin:0;color:#4ade80;font-size:11.5px;">
                Promoting tourism and local heritage in Tigbao, Zamboanga del Sur
              </p>
              <p style="margin:12px 0 0;color:#166534;font-size:10.5px;">
                © {{ date('Y') }} E-Turismo. All rights reserved.
              </p>
            </td>
          </tr>

        </table>
        <!-- /Card -->

      </td>
    </tr>
  </table>

</body>
</html>
