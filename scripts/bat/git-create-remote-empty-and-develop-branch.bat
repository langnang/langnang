@echo off

:: 一次新建empty和develop分支

echo Please Input Repo Path:

set /p repo=

cd /d %repo%

set branch="empty"

git checkout -b %branch%

git push --set-upstream origin %branch%

set branch="develop"

git checkout -b %branch%

git push --set-upstream origin %branch%

exit