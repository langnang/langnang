# node

## Branches

```sh
┌──────────────────────────────┐       ┌───────────────────────────────────┐       ┌───────────┐       ┌──────────┐
|                              |       |                                   |       |           |       |          |
|  @langnang-temp/npm-package  | ====> |   @langnang-temp/vue-ui-package   | ====> |  develop  | ====> |  master  |
|      Sync from template      |       |          Sync to remote           |       |           |       |          |
└──────────────────────────────┘       └───────────────────────────────────┘       └───────────┘       └──────────┘
```

### Sync to remote

```sh
# add remote url
git remote set-url --add origin [url]
# checkout the branch for sync
git checkout @langnang-temp/vue-ui-package

git pull
# force push
git push -f
```
