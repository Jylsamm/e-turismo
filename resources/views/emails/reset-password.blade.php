<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Reset Password Notification</title>
</head>
<body style="margin:0;padding:0;background-color:#f0fdf4;font-family:'Segoe UI',-apple-system,BlinkMacSystemFont,Roboto,Helvetica,Arial,sans-serif;-webkit-font-smoothing:antialiased;">

  <!-- Outer background wrapper -->
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
         style="background-color:#f0fdf4;padding:48px 16px 64px;margin:0;">
    <tr>
      <td align="center">

        <!-- Main Email Container Card -->
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
               style="max-width:540px;width:100%;background:#ffffff;border-radius:24px;overflow:hidden;border:1px solid #dcfce7;box-shadow:0 12px 36px rgba(11,61,46,0.08);">

          <!-- ── Header: Emerald Horizon with Vector Brand Emblem ── -->
          <tr>
            <td align="center"
                style="background:linear-gradient(145deg,#052e16 0%,#0B3D2E 40%,#166534 80%,#15803d 100%);
                       padding:40px 32px 32px;text-align:center;">

              <!-- Vector Brand Emblem (Pure Inline SVG + Typography — Zero Download Overlay) -->
              <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin:0 auto 20px;">
                <tr>
                  <td align="center" style="background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.25);border-radius:999px;padding:8px 20px;">
                    <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <!-- Compass Spark SVG -->
                        <td style="vertical-align:middle;padding-right:10px;">
                          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:block;">
                            <path d="M12 2L14.2 8.8L21 11L14.2 13.2L12 20L9.8 13.2L3 11L9.8 8.8L12 2Z" fill="#86efac"/>
                            <circle cx="12" cy="11" r="2.5" fill="#0B3D2E"/>
                          </svg>
                        </td>
                        <td style="vertical-align:middle;">
                          <span style="font-family:'Segoe UI',Arial,sans-serif;font-size:16px;font-weight:900;letter-spacing:2.5px;color:#ffffff;text-transform:uppercase;line-height:1;">
                            E-TURISMO
                          </span>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>

              <!-- Main Title -->
              <h1 style="margin:0 0 6px;color:#ffffff;font-size:24px;font-weight:800;letter-spacing:-0.4px;line-height:1.25;">
                Password Reset Request
              </h1>
              <p style="margin:0;color:#86efac;font-size:13px;font-weight:600;letter-spacing:0.5px;text-transform:uppercase;">
                Account Security Notification
              </p>

            </td>
          </tr>

          <!-- ── Body Content ── -->
          <tr>
            <td style="padding:36px 36px 32px;background:#ffffff;">

              <!-- Lead Description -->
              <p style="margin:0 0 24px;color:#334155;font-size:15px;line-height:1.65;font-weight:500;">
                Hello! We received a request to reset the password for your <strong style="color:#0f172a;">E-Turismo</strong> account. Click the button below to choose a new secure password.
              </p>

              <!-- Action Button -->
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:24px 0 32px;">
                <tr>
                  <td align="center">
                    <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td align="center" style="background:#16a34a;border-radius:14px;box-shadow:0 6px 20px rgba(22,163,74,0.35);">
                          <a href="{{ $url }}"
                             target="_blank"
                             style="display:inline-block;padding:14px 36px;color:#ffffff;font-size:15px;font-weight:700;text-decoration:none;letter-spacing:0.3px;font-family:'Segoe UI',Arial,sans-serif;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                              <tr>
                                <td style="vertical-align:middle;padding-right:8px;">
                                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="display:block;">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                  </svg>
                                </td>
                                <td style="vertical-align:middle;color:#ffffff;font-size:15px;font-weight:700;">
                                  Reset Password
                                </td>
                              </tr>
                            </table>
                          </a>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>

              <!-- Expiry Alert Banner -->
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                     style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:14px;margin-bottom:24px;">
                <tr>
                  <td style="padding:14px 18px;">
                    <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td style="vertical-align:middle;padding-right:8px;">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#15803d" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="display:block;">
                            <circle cx="12" cy="12" r="9"/>
                            <polyline points="12 7 12 12 15 15"/>
                          </svg>
                        </td>
                        <td style="vertical-align:middle;color:#334155;font-size:13px;font-weight:600;">
                          This reset link will expire in <span style="color:#15803d;font-weight:700;">60 minutes</span>.
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>

              <!-- Fallback Link Section -->
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                     style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:14px;margin-bottom:24px;">
                <tr>
                  <td style="padding:16px 20px;">
                    <p style="margin:0 0 6px;color:#0f172a;font-size:12.5px;font-weight:700;">
                      Having trouble with the button?
                    </p>
                    <p style="margin:0 0 8px;color:#64748b;font-size:12px;line-height:1.5;">
                      Copy and paste the URL below directly into your web browser:
                    </p>
                    <p style="margin:0;color:#16a34a;font-size:12px;word-break:break-all;line-height:1.5;">
                      <a href="{{ $url }}" style="color:#16a34a;text-decoration:underline;">{{ $url }}</a>
                    </p>
                  </td>
                </tr>
              </table>

              <!-- Security Notice Banner (Clean Vector Shield — Zero Emojis) -->
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                     style="background:#fffbeb;border:1px solid #fde68a;border-radius:14px;margin-bottom:24px;">
                <tr>
                  <td style="padding:14px 18px;">
                    <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td style="vertical-align:top;padding-right:10px;padding-top:2px;">
                          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#b45309" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                          </svg>
                        </td>
                        <td style="vertical-align:middle;color:#92400e;font-size:12.5px;line-height:1.55;">
                          <strong style="color:#78350f;">Security Notice:</strong> If you did not request a password reset, you can safely ignore this email. Your existing credentials remain completely secure.
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>

              <p style="margin:0;color:#94a3b8;font-size:12px;line-height:1.5;text-align:center;">
                This is an automated security transmission. Please do not reply to this email.
              </p>

            </td>
          </tr>

          <!-- ── Footer ── -->
          <tr>
            <td align="center"
                style="background:#052e16;padding:24px 32px;text-align:center;">
              <p style="margin:0 0 4px;color:#ffffff;font-size:13px;font-weight:700;letter-spacing:0.2px;">
                Tigbao E-Turismo Digital Tourism Portal
              </p>
              <p style="margin:0;color:#86efac;font-size:11.5px;line-height:1.5;">
                Promoting tourism and local heritage in Tigbao, Zamboanga del Sur
              </p>
              <p style="margin:12px 0 0;color:#4ade80;font-size:10.5px;opacity:0.75;">
                &copy; {{ date('Y') }} E-Turismo. All rights reserved.
              </p>
            </td>
          </tr>

        </table>
        <!-- /Container Card -->

      </td>
    </tr>
  </table>

</body>
</html>
