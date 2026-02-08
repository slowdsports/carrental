@echo off
echo ==============================
echo  Backup BD: carrental
echo ==============================

"C:\xampp\mysql\bin\mysqldump.exe" ^
  -u root ^
  carrental ^
  > carrental.sql

echo.
echo Backup completado correctamente.
pause
