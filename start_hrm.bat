@echo off
echo Starting Laravel server...
start php artisan serve
start php artisan queue:work
echo Laravel server started
start "" "C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe" http://localhost:8000
exit