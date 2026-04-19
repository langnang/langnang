@echo off 

:: Jump to the directory where this file reside.
cd /d "%~dp0"

:: 11.6.1
if exist 11.6.1 rmdir /s /q 11.6.1
curl -L https://gh-proxy.ygxz.in/https://github.com/laravel/laravel/archive/refs/tags/v11.6.1.tar.gz -o v11.6.1.tar.gz
tar -xf v11.6.1.tar.gz
ren laravel-11.6.1 11.6.1
del v11.6.1.tar.gz
:: 10.3.3
if exist 10.3.3 rmdir /s /q 10.3.3
curl -L https://gh-proxy.ygxz.in/https://github.com/laravel/laravel/archive/refs/tags/v10.3.3.tar.gz -o v10.3.3.tar.gz
tar -xf v10.3.3.tar.gz
ren laravel-10.3.3 10.3.3
del v10.3.3.tar.gz
:: 9.5.2
if exist 9.5.2 rmdir /s /q 9.5.2
curl -L https://gh-proxy.ygxz.in/https://github.com/laravel/laravel/archive/refs/tags/v9.5.2.tar.gz -o v9.5.2.tar.gz
tar -xf v9.5.2.tar.gz
ren laravel-9.5.2 9.5.2
del v9.5.2.tar.gz
:: 8.6.12
if exist 8.6.12 rmdir /s /q 8.6.12
curl -L https://gh-proxy.ygxz.in/https://github.com/laravel/laravel/archive/refs/tags/v8.6.12.tar.gz -o v8.6.12.tar.gz
tar -xf v8.6.12.tar.gz
ren laravel-8.6.12 8.6.12
del v8.6.12.tar.gz
:: 7.30.1
if exist 7.30.1 rmdir /s /q 7.30.1
curl -L https://gh-proxy.ygxz.in/https://github.com/laravel/laravel/archive/refs/tags/v7.30.1.tar.gz -o v7.30.1.tar.gz
tar -xf v7.30.1.tar.gz
ren laravel-7.30.1 7.30.1
del v7.30.1.tar.gz
:: 6.20.0
if exist 6.20.0 rmdir /s /q 6.20.0
curl -L https://gh-proxy.ygxz.in/https://github.com/laravel/laravel/archive/refs/tags/v6.20.0.tar.gz -o v6.20.0.tar.gz
tar -xf v6.20.0.tar.gz
ren laravel-6.20.0 6.20.0
del v6.20.0.tar.gz