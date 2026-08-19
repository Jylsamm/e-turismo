Write-Host "============================================================" -ForegroundColor Cyan
Write-Host "  E-Turismo - Starting Ngrok Tunnel on Port 80" -ForegroundColor Green
Write-Host "  Target: http://localhost:80 (XAMPP / Apache)" -ForegroundColor Yellow
Write-Host "============================================================" -ForegroundColor Cyan
Write-Host ""
ngrok http 80 --host-header=localhost
