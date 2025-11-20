@echo off

:: 新建分支

echo Please Input Repo Path:

set /p repo=

cd /d %repo%

echo Please Input New Branch Name:

set /p branch=

git checkout -b %branch%

git push --set-upstream origin %branch%

exit