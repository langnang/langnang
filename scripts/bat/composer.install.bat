@echo off


@REM 添加到用户环境变量
setx COMPOSER_HOME "D:\Documents\Composer"

@REM 添加到系统环境变量（需管理员权限）
@REM setx /M COMPOSER_HOME "D:\Documents\Composer"

pause & exit