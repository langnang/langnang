@echo off

:: Jump to the directory where this file reside.
cd /d "%~dp0"

git clone git@github.com:langnang-applications/.github.git applications

git clone git@github.com:langnang-assets/.github.git assets

git clone git@github.com:langnang-configs/.github.git configs

git clone git@github.com:langnang-documents/.github.git documents

git clone git@github.com:langnang-examples/.github.git examples

git clone git@github.com:langnang-extensions/.github.git extensions 

git clone git@github.com:langnang-frameworks/.github.git frameworks 

git clone git@github.com:langnang-modules/.github.git modules 

git clone git@github.com:langnang-packages/.github.git packages 

git clone git@github.com:langnang-projects/.github.git projects 

git clone git@github.com:langnang-relax/.github.git relax 

git clone git@github.com:langnang-scripts/.github.git scripts 

git clone git@github.com:langnang-softwares/.github.git softwares 

git clone git@github.com:langnang-templates/.github.git templates 

git clone git@github.com:langnang/langnang.github.io.git