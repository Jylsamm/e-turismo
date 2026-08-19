@echo off
title E-Turismo - Ngrok Tunnel (Port 80)
echo ============================================================
echo   E-Turismo - Starting Ngrok Tunnel on Port 80
echo   Target: http://localhost:80 (XAMPP / Apache)
echo ============================================================
echo.
ngrok http 80 --host-header=localhost
pause
