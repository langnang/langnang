docker search docker.1ms.run/hello-world

docker search docker.1ms.run/hello-world -t latest

docker search --format "{{.Name}}: {{.Tag}}" docker.1ms.run/hello-world

docker search --filter "name=nginx" --filter "is-official=true" --format "table {{.Name}}\t{{.Tag}}\t{{.Description}}"