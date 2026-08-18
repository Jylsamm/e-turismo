## 2024-11-20 - [MitM Vulnerability in External API Call]
**Vulnerability:** Insecure cURL configuration (`CURLOPT_SSL_VERIFYPEER => false`) when calling the external OCR.space API.
**Learning:** External API integrations via cURL in legacy or hastily developed code might disable SSL verification to bypass local certificate errors during development, but this is a critical security risk (MitM) in production when transmitting sensitive data (like ID photos).
**Prevention:** Ensure `CURLOPT_SSL_VERIFYPEER` is always `true` (or omitted to default to true) for any external service calls.
