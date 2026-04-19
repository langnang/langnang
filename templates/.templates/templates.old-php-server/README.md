# PHP Server

- `Dependency` [Composer](https://packagist.org/)
- `Router` [nikic/fast-route](https://packagist.org/packages/nikic/fast-route)
- `SQL` [doctrine/dbal](https://packagist.org/packages/doctrine/dbal) | [Docs](https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/index.html#)
- `ApiDoc` [zircote/swagger-php](https://packagist.org/packages/zircote/swagger-php)
- `FileSystem` [league/flysystem](https://packagist.org/packages/league/flysystem)
- `Request` [rmccue/requests](https://packagist.org/packages/rmccue/requests)
- `FakeData` [fakerphp/faker](https://packagist.org/packages/fakerphp/faker)
- `FTP` [nicolab/php-ftp-client](https://packagist.org/packages/nicolab/php-ftp-client)
- `XML`

## Branches

```sh
┌──────────────────────┐       ┌─────────────────────────────┐       ┌───────────┐       ┌──────────┐
|                      |       |                             |       |           |       |          |
|  @langnang-temp/php  | ====> |  @langnang-temp/php-server  | ====> |  develop  | ====> |  master  |
|  Sync from template  |       |       Sync to remote        |       |           |       |          |
└──────────────────────┘       └─────────────────────────────┘       └───────────┘       └──────────┘
```

### Sync to remote

```sh
# add remote url
git remote set-url --add origin [url]
# checkout the branch for sync
git checkout [branch]

git pull
# force push
git push -f
```
