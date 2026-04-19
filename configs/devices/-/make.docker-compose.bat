@echo off






:ReadINI


:MakeNginxConf


:DockerRun

:DockerCompose
cd "%~dp0"

call docker compose up -d

:DockerComposeService