@echo off

echo Start Serve-01
start cmd /k "cd /d E:\xxx\ui && npm run dev"

echo Start Serve-02 with Port(8081) 
start cmd /k "cd /d E:\xxx\ui2 && set PORT=8081 && npm run dev"
