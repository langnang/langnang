---
title: Shield
layout: cheatsheet
brand: https://shields.io/img/favicon.ico
---

<div class="d-flex justify-content-around mb-3" style="height: 3rem;">
    <a target="_blank" class="d-inline-flex" href="https://shields.io/docs">
        <img src="{{site.storageUrl.favicon}}/shields.ico"/>
    </a>
</div>

# Utils.Shield.CheatSheet

```yml
baseUrl: https://img.shields.io/
query-params:
  style: string // flat, flat-square, plastic, for-the-badge, social
  logo: string // appveyor, ...
  logoColor: string // violet, ...
  logoSize: string // auto, ...
  label: string // healthiness, ...
  labelColor: string // abcdef, ...
  color: string // fedcba, ...
  cacheSeconds: string // 3600, ...
  link: string[]
```

- https://shields.io/badges

## Core

### Static Badge

```yml
[GET] /badge/:badgeContent
```

- ![](https://img.shields.io/badge/any_text-you_like-blue): `https://img.shields.io/badge/any_text-you_like-blue`
- ![](https://img.shields.io/badge/just%20the%20message-8A2BE2): `https://img.shields.io/badge/just%20the%20message-8A2BE2`

### Dynamic JSON Badge

```yml
[GET] /badge/dynamic/json
```

- ![](https://img.shields.io/badge/dynamic/json?url=https://github.com/badges/shields/raw/master/package.json&query=$.name): `https://img.shields.io/badge/dynamic/json?url=https://github.com/badges/shields/raw/master/package.json&query=$.name`

### Dynamic TOML Badge

```yml
[GET] /badge/dynamic/toml
```

### Dynamic XML Badge

```yml
[GET] /badge/dynamic/xml
```

### Dynamic YAML Badge

```yml
[GET] /badge/dynamic/yaml
```

### Endpoint Badge

```yml
[GET] /endpoint
```

## Activity

### AUR Last Modified

```yml
[GET] /
```

### Bitbucket last commit

```yml
[GET] /
```

### Eclipse Marketplace Last Update

```yml
[GET] /
```

### Factorio Mod Portal last updated

```yml
[GET] /
```

### Galaxy Toolshed - Created Date

```yml
[GET] /
```

### Gitea Last Commit

```yml
[GET] /
```

### Gitea Last Commit (branch)

```yml
[GET] /
```

### GitHub commit activity

> GitHub 提交活动

```yml
[GET] /
```

### GitHub commit activity (branch)

> GitHub 提交活动(分支)

```yml
[GET] /
```

### GitHub commits difference between two branches/tags/commits

```yml
[GET] /
```

### GitHub commits since latest release

```yml
[GET] /
```

### GitHub commits since latest release (branch)

```yml
[GET] /
```

### GitHub commits since tagged version

```yml
[GET] /
```

### GitHub commits since tagged version (branch)

```yml
[GET] /
```

### GitHub contributors from allcontributors.org

```yml
[GET] /
```

### GitHub contributors from allcontributors.org (with branch)

```yml
[GET] /
```

### Github Created At

```yml
[GET] /
```

### GitHub Gist last commit

```yml
[GET] /
```

### GitHub last commit

```yml
[GET] /
```

### GitHub last commit (branch)

```yml
[GET] /
```

### GitHub Release Date

```yml
[GET] /
```

### GitLab Contributors

```yml
[GET] /
```

### GitLab Last Commit

```yml
[GET] /
```

### NPM Collaborators

```yml
[GET] /
```

### Open VSX Release Date

```yml
[GET] /
```

### SourceForge Commit Count

```yml
[GET] /
```

### SourceForge Contributors

```yml
[GET] /
```

### SourceForge Last Commit

```yml
[GET] /
```

### SourceForge Translations

```yml
[GET] /
```

### Steam Release Date

```yml
[GET] /
```

### Steam Update Date

```yml
[GET] /
```

### Vaadin Directory Release Date

```yml
[GET] /
```

### Visual Studio Marketplace Last Updated

```yml
[GET] /
```

### Visual Studio Marketplace Release Date

```yml
[GET] /
```

### WhatPulse

```yml
[GET] /
```

### WordPress Plugin Last Updated

```yml
[GET] /
```

### WordPress Theme Last Updated

```yml
[GET] /
```

## Analysis

### CII Best Practices

```yml
[GET] /
```

### ClearlyDefined Score

```yml
[GET] /
```

### Cocoapods doc percentage

```yml
[GET] /
```

### Codacy grade

```yml
[GET] /
```

### Codacy grade (branch)

```yml
[GET] /
```

### Code Climate issues

```yml
[GET] /
```

### Code Climate maintainability

```yml
[GET] /
```

### Code Climate technical debt

```yml
[GET] /
```

### CodeFactor Grade

```yml
[GET] /
```

### CodeFactor Grade (with branch)

```yml
[GET] /
```

### Coverity Scan

```yml
[GET] /
```

### Gitea language count

```yml
[GET] /
```

### GitHub language count

```yml
[GET] /
```

### GitHub search hit counter

```yml
[GET] /
```

### GitHub top language

```yml
[GET] /
```

### GitLab Language Count

```yml
[GET] /
```

### npms.io

```yml
[GET] /
```

### npms.io (scoped package)

```yml
[GET] /
```

### OSSF-Scorecard Score

```yml
[GET] /
```

### Scrutinizer quality (GitHub/Bitbucket)

```yml
[GET] /
```

### Scrutinizer quality (GitHub/Bitbucket) with branch

```yml
[GET] /
```

### Scrutinizer quality (GitLab)

```yml
[GET] /
```

### Scrutinizer quality (GitLab) with branch

```yml
[GET] /
```

### Sonar Documented API Density

```yml
[GET] /
```

### Sonar Documented API Density (branch)

```yml
[GET] /
```

### Sonar Fortify Security Rating

```yml
[GET] /
```

### Sonar Fortify Security Rating (branch)

```yml
[GET] /
```

### Sonar Quality Gate

```yml
[GET] /
```

### Sonar Quality Gate (branch)

```yml
[GET] /
```

### Sonar Tech Debt

```yml
[GET] /
```

### Sonar Tech Debt (branch)

```yml
[GET] /
```

### Sonar Violations

```yml
[GET] /
```

### Sonar Violations (branch)

```yml
[GET] /
```

### SourceForge Languages

```yml
[GET] /
```

### SymfonyInsight Grade

```yml
[GET] /
```

### SymfonyInsight Stars

```yml
[GET] /
```

### SymfonyInsight Violations

```yml
[GET] /
```

### W3C Validation

```yml
[GET] /
```

## Build

### AppVeyor Build

```yml
[GET] /
```

### AppVeyor Build (with branch)

```yml
[GET] /
```

### AppVeyor Job

```yml
[GET] /
```

### AppVeyor Job (with branch)

```yml
[GET] /
```

### Azure DevOps builds

```yml
[GET] /
```

### Azure DevOps builds (branch)

```yml
[GET] /
```

### Azure DevOps releases

```yml
[GET] /
```

### Bitbucket Pipelines

```yml
[GET] /
```

### Bitrise

```yml
[GET] /
```

### Bitrise (branch)

```yml
[GET] /
```

### Buildkite

```yml
[GET] /
```

### Buildkite (branch)

```yml
[GET] /
```

### CircleCI

```yml
[GET] /
```

### CircleCI (branch)

```yml
[GET] /
```

### Cirrus CI - Default Branch Build Status

```yml
[GET] /
```

### Cirrus CI - Specific Branch Build Status

```yml
[GET] /
```

### Codeship

```yml
[GET] /
```

### Codeship (branch)

```yml
[GET] /
```

### Docker Automated build

```yml
[GET] /
```

### Docker Cloud Automated build

```yml
[GET] /
```

### Docker Cloud Build Status

```yml
[GET] /
```

### docs.rs

```yml
[GET] /
```

### docs.rs (with version)

```yml
[GET] /
```

### Drone

```yml
[GET] /
```

### Drone (branch)

```yml
[GET] /
```

### GitHub Actions Workflow Status

```yml
[GET] /
```

### GitHub pull request check contexts

```yml
[GET] /
```

### GitHub pull request check state

```yml
[GET] /
```

### GitHub tag checks state

```yml
[GET] /
```

### Gitlab Pipeline Status

```yml
[GET] /
```

### Jenkins Build

```yml
[GET] /
```

### Netlify

```yml
[GET] /
```

### OBS package build status

```yml
[GET] /
```

### Read the Docs

```yml
[GET] /
```

### Read the Docs (version)

```yml
[GET] /
```

### Scrutinizer build (GitHub/Bitbucket)

```yml
[GET] /
```

### Scrutinizer build (GitHub/Bitbucket) with branch

```yml
[GET] /
```

### Scrutinizer build (GitLab)

```yml
[GET] /
```

### Scrutinizer build (GitLab) with branch

```yml
[GET] /
```

### Sonar Test Count

```yml
[GET] /
```

### Sonar Test Count (branch)

```yml
[GET] /
```

### Sonar Test Execution Time

```yml
[GET] /
```

### Sonar Test Execution Time (branch)

```yml
[GET] /
```

### Sonar Test Success Rate

```yml
[GET] /
```

### Sonar Test Success Rate (branch)

```yml
[GET] /
```

### TeamCity Full Build Status

```yml
[GET] /
```

### TeamCity Simple Build Status

```yml
[GET] /
```

### Travis (.com)

```yml
[GET] /
```

### Travis (.com) branch

```yml
[GET] /
```

### Visual Studio App Center Builds

```yml
[GET] /
```

## Chat

### Discord

```yml
[GET] /
```

### Discourse Likes

```yml
[GET] /
```

### Discourse Posts

```yml
[GET] /
```

### Discourse Status

```yml
[GET] /
```

### Discourse Topics

```yml
[GET] /
```

### Discourse Users

```yml
[GET] /
```

### Gitter

```yml
[GET] /
```

### Matrix

```yml
[GET] /
```

### Stack Exchange monthly questions

```yml
[GET] /
```

### Stack Exchange questions

```yml
[GET] /
```

### Stack Exchange reputation

```yml
[GET] /
```

## Code Coverage

### Azure DevOps coverage

```yml
[GET] /
```

### Azure DevOps coverage (branch)

```yml
[GET] /
```

### Codacy coverage

```yml
[GET] /
```

### Codacy coverage (branch)

```yml
[GET] /
```

### Code Climate coverage

```yml
[GET] /
```

### Codecov

```yml
[GET] /
```

### Codecov (with branch)

```yml
[GET] /
```

### Coveralls

```yml
[GET] /
```

### Gitlab Code Coverage

```yml
[GET] /
```

### Jenkins Coverage

```yml
[GET] /
```

### nycrc config on GitHub

```yml
[GET] /
```

### Scrutinizer coverage (GitHub/Bitbucket)

```yml
[GET] /
```

### Scrutinizer coverage (GitHub/Bitbucket) with branch

```yml
[GET] /
```

### Scrutinizer coverage (GitLab)

```yml
[GET] /
```

### Scrutinizer coverage (GitLab) with branch

```yml
[GET] /
```

### Sonar Coverage

```yml
[GET] /
```

### Sonar Coverage (branch)

```yml
[GET] /
```

### TeamCity Coverage

```yml
[GET] /
```

## Dependencies

### Depfu

```yml
[GET] /
```

### GitHub Pipenv locked dependency version

```yml
[GET] /
```

### GitHub Pipenv locked dependency version (branch)

```yml
[GET] /
```

### GitHub Pipenv locked dev dependency version

```yml
[GET] /
```

### GitHub Pipenv locked dev dependency version (branch)

```yml
[GET] /
```

### Hackage Dependencies

```yml
[GET] /
```

### Libraries.io dependency status for GitHub repo

```yml
[GET] /
```

### Libraries.io dependency status for latest release

```yml
[GET] /
```

### Libraries.io dependency status for specific release

```yml
[GET] /
```

## Downloads

### Ansible Role

```yml
[GET] /
```

### Chocolatey Downloads

```yml
[GET] /
```

### Chrome Web Store Users

```yml
[GET] /
```

### Clojars Downloads

```yml
[GET] /
```

### Conda Downloads

```yml
[GET] /
```

### Crates.io Downloads (latest version)

```yml
[GET] /
```

### Crates.io Downloads (recent)

```yml
[GET] /
```

### Crates.io Downloads (version)

```yml
[GET] /
```

### Crates.io Total Downloads

```yml
[GET] /
```

### CurseForge Downloads

```yml
[GET] /
```

### Docker Pulls

```yml
[GET] /
```

### DUB Downloads

```yml
[GET] /
```

### DUB Downloads (specific version)

```yml
[GET] /
```

### Eclipse Marketplace Downloads

```yml
[GET] /
```

### Factorio Mod Portal downloads

```yml
[GET] /
```

### Flathub Downloads

```yml
[GET] /
```

### Galaxy Toolshed - Downloads

```yml
[GET] /
```

### Gem download rank

```yml
[GET] /
```

### Gem Downloads (for latest version)

```yml
[GET] /
```

### Gem Downloads (for specified version)

```yml
[GET] /
```

### Gem Total Downloads

```yml
[GET] /
```

### GitHub Downloads (all assets, all releases)

```yml
[GET] /
```

### GitHub Downloads (all assets, latest release)

```yml
[GET] /
```

### GitHub Downloads (all assets, specific tag)

```yml
[GET] /
```

### GitHub Downloads (specific asset, all releases)

```yml
[GET] /
```

### GitHub Downloads (specific asset, latest release)

```yml
[GET] /
```

### GitHub Downloads (specific asset, specific tag)

```yml
[GET] /
```

### Greasy Fork Downloads

```yml
[GET] /
```

### Hangar Downloads

```yml
[GET] /
```

### Hex.pm Downloads

```yml
[GET] /
```

### homebrew downloads

```yml
[GET] /
```

### Jenkins Plugin installs

```yml
[GET] /
```

### Jenkins Plugin installs (version)

```yml
[GET] /
```

### JetBrains Plugin Downloads

```yml
[GET] /
```

### JetBrains ReSharper plugins Downloads

```yml
[GET] /
```

### jsDelivr hits (GitHub)

```yml
[GET] /
```

### jsDelivr hits (npm scoped)

```yml
[GET] /
```

### jsDelivr hits (npm)

```yml
[GET] /
```

### Modrinth Downloads

```yml
[GET] /
```

### Mozilla Add-on Downloads

```yml
[GET] /
```

### Mozilla Add-on Users

```yml
[GET] /
```

### MyGet Downloads

```yml
[GET] /
```

### MyGet Downloads (tenant)

```yml
[GET] /
```

### NPM Downloads

```yml
[GET] /npm/:interval/:packageName

interval:
  - dw
  - dm
  - dy
  - d18m
```

### NPM Downloads by package author

```yml
[GET] /npm-stat/:interval/:author

interval:
  - dw
  - dm
  - dy
```

### NuGet Downloads

```yml
[GET] /
```

### Open VSX Downloads

```yml
[GET] /
```

### Open VSX Downloads (version)

```yml
[GET] /
```

### Ore Downloads

```yml
[GET] /
```

### Package Control Downloads

```yml
[GET] /
```

### Packagist Downloads

```yml
[GET] /packagist/:interval/:user/:repo

interval:
  - dd
  - dm
  - dt
```

### Pepy Total Downlods

```yml
[GET] /
```

### Polymart Downloads

```yml
[GET] /
```

### PowerShell Gallery Downloads

```yml
[GET] /
```

### Pulsar Downloads

```yml
[GET] /
```

### Puppet Forge downloads

```yml
[GET] /
```

### PyPI - Downloads

```yml
[GET] /
```

### Raycast extension downloads count

```yml
[GET] /
```

### SourceForge Downloads

```yml
[GET] /
```

### SourceForge Downloads (folder)

```yml
[GET] /
```

### Spiget Downloads

```yml
[GET] /
```

### Steam Downloads

```yml
[GET] /
```

### Thunderstore Downloads

```yml
[GET] /
```

### Visual Studio Marketplace Downloads

```yml
[GET] /
```

### Visual Studio Marketplace Installs

```yml
[GET] /
```

### Visual Studio Marketplace Installs - Azure DevOps Extension

```yml
[GET] /
```

### Wikiapiary installs

```yml
[GET] /
```

### WordPress Plugin Active Installs

```yml
[GET] /
```

### WordPress Plugin Downloads

```yml
[GET] /
```

### WordPress Theme Active Installs

```yml
[GET] /
```

### WordPress Theme Downloads

```yml
[GET] /
```

## Funding

### Bountysource

```yml
[GET] /
```

### GitHub Sponsors

```yml
[GET] /
```

### Liberapay giving

```yml
[GET] /
```

### Liberapay goal progress

```yml
[GET] /
```

### Liberapay patrons

```yml
[GET] /
```

### Liberapay receiving

```yml
[GET] /
```

### Open Collective backers

```yml
[GET] /
```

### Open Collective backers and sponsors

```yml
[GET] /
```

### Open Collective members by tier

```yml
[GET] /
```

### Open Collective sponsors

```yml
[GET] /
```

## Issue Tracking

### Bitbucket open issues

```yml
[GET] /
```

### Bitbucket open issues (raw)

```yml
[GET] /
```

### Bitbucket open pull requests

```yml
[GET] /
```

### Bitbucket open pull requests (raw)

```yml
[GET] /
```

### Bugzilla bug status

```yml
[GET] /
```

### Gerrit change status

```yml
[GET] /
```

### Gitea Issues

```yml
[GET] /
```

### Gitea Pull Requests

```yml
[GET] /
```

### GitHub commit merge status

```yml
[GET] /
```

### GitHub Hacktoberfest combined status

```yml
[GET] /
```

### GitHub issue custom search

```yml
[GET] /
```

### GitHub issue custom search in repo

```yml
[GET] /
```

### GitHub issue/pull request detail

```yml
[GET] /
```

### GitHub Issues or Pull Requests

```yml
[GET] /
```

### GitHub Issues or Pull Requests by label

```yml
[GET] /
```

### GitHub labels

```yml
[GET] /
```

### GitHub milestone details

```yml
[GET] /
```

### GitHub number of milestones

```yml
[GET] /
```

### GitLab Issues

```yml
[GET] /
```

### GitLab Merge Requests

```yml
[GET] /
```

### JIRA issue

```yml
[GET] /
```

### JIRA sprint completion

```yml
[GET] /
```

## License

### AUR License

```yml
[GET] /
```

### Bower License

```yml
[GET] /
```

### Cocoapods License

```yml
[GET] /
```

### Conda - License

```yml
[GET] /
```

### CPAN License

```yml
[GET] /
```

### CRAN/METACRAN License

```yml
[GET] /
```

### Crates.io License

```yml
[GET] /
```

### Crates.io License (version)

```yml
[GET] /
```

### CTAN License

```yml
[GET] /
```

### DUB License

```yml
[GET] /
```

### Eclipse Marketplace License

```yml
[GET] /
```

### GitHub License

```yml
[GET] /
```

### GitLab License

```yml
[GET] /
```

### Greasy Fork License

```yml
[GET] /
```

### Hex.pm License

```yml
[GET] /
```

### NPM License

```yml
[GET] /
```

### Ore License

```yml
[GET] /
```

### Packagist License

```yml
[GET] /packagist/l/:user/:repo
```

### PyPI - License

```yml
[GET] /
```

### REUSE Compliance

```yml
[GET] /
```

### Weblate component license

```yml
[GET] /
```

## Monitoring

### Chromium HSTS preload

```yml
[GET] /
```

### Mozilla HTTP Observatory Grade

```yml
[GET] /
```

### NodePing status

```yml
[GET] /
```

### NodePing uptime

```yml
[GET] /
```

### PingPong status

```yml
[GET] /
```

### PingPong uptime (last 30 days)

```yml
[GET] /
```

### Security Headers

```yml
[GET] /
```

### Uptime Robot ratio (30 days)

```yml
[GET] /
```

### Uptime Robot ratio (7 days)

```yml
[GET] /
```

### Uptime Robot status

```yml
[GET] /
```

### Website

```yml
[GET] /
```

## Other

### AUR Maintainer

```yml
[GET] /
```

### Bit Components

```yml
[GET] /
```

### bStats Players

```yml
[GET] /
```

### bStats Servers

```yml
[GET] /
```

### Coincap (Change Percent 24Hr)

```yml
[GET] /
```

### Coincap (Price USD)

```yml
[GET] /
```

### Coincap (Rank)

```yml
[GET] /
```

### Dependent repos (via libraries.io)

```yml
[GET] /
```

### Dependent repos (via libraries.io), scoped npm package

```yml
[GET] /
```

### Dependents (via libraries.io)

```yml
[GET] /
```

### Dependents (via libraries.io), scoped npm package

```yml
[GET] /
```

### Eclipse Marketplace Favorites

```yml
[GET] /
```

### Ecologi (Carbon Offset)

```yml
[GET] /
```

### Ecologi (Trees)

```yml
[GET] /
```

### freeCodeCamp points

```yml
[GET] /
```

### Gem Owner

```yml
[GET] /
```

### GitHub deployments

```yml
[GET] /
```

### GitHub Discussions

```yml
[GET] /
```

### GitHub discussions custom search

```yml
[GET] /
```

### GitHub discussions custom search in repo

```yml
[GET] /
```

### GitHub manifest.json dynamic

```yml
[GET] /
```

### GitHub manifest.json dynamic (branch)

```yml
[GET] /
```

### GitHub package.json dynamic

```yml
[GET] /
```

### GitHub package.json dynamic (branch)

```yml
[GET] /
```

### Hangar Views

```yml
[GET] /
```

### Localizely progress

```yml
[GET] /
```

### Localizely progress (branch)

```yml
[GET] /
```

### Maintenance

```yml
[GET] /
```

### Ore Category

```yml
[GET] /
```

### OSS Lifecycle

```yml
[GET] /
```

### OSS Lifecycle (branch)

```yml
[GET] /
```

### POEditor

```yml
[GET] /
```

### Pub Publisher

```yml
[GET] /
```

### Puppet Forge modules by user

```yml
[GET] /
```

### Puppet Forge releases by user

```yml
[GET] /
```

### PyPI - Format

```yml
[GET] /
```

### PyPI - Status

```yml
[GET] /
```

### Relative date

```yml
[GET] /
```

### Sourceforge Open Tickets

```yml
[GET] /
```

### Sourcegraph for Repo Reference Count

```yml
[GET] /
```

### Steam Collection Files

```yml
[GET] /
```

### Steam Views

```yml
[GET] /
```

### Swagger Validator

```yml
[GET] /
```

### Treeware (Trees)

```yml
[GET] /
```

### Vaadin Directory Status

```yml
[GET] /
```

### Weblate entities

```yml
[GET] /
```

### Weblate project translated

```yml
[GET] /
```

### Weblate user statistic

```yml
[GET] /
```

### Wheelmap

```yml
[GET] /
```

## Platform & Version Support

### Cocoapods platforms

```yml
[GET] /
```

### Compatible versions (plugins on Ore)

```yml
[GET] /
```

### Conda Platform

```yml
[GET] /
```

### Crates.io MSRV

```yml
[GET] /
```

### Crates.io MSRV (version)

```yml
[GET] /
```

### CurseForge Game Versions

```yml
[GET] /
```

### Factorio Mod Portal factorio versions

```yml
[GET] /
```

### GitHub package.json dev/peer/optional dependency version

```yml
[GET] /
```

### GitHub package.json dev/peer/optional dependency version (branch)

```yml
[GET] /
```

### GitHub package.json prod dependency version

```yml
[GET] /
```

### GitHub package.json prod dependency version (branch)

```yml
[GET] /
```

### GitHub Pipenv locked Python version

```yml
[GET] /
```

### GitHub Pipenv locked Python version (branch)

```yml
[GET] /
```

### Modrinth Game Versions

```yml
[GET] /
```

### Node Current

```yml
[GET] /
```

### Node Current (with tag)

```yml
[GET] /
```

### Node LTS

```yml
[GET] /
```

### Node LTS (with tag)

```yml
[GET] /
```

### NPM (prod) Dependency Version

```yml
[GET] /
```

### NPM dev or peer Dependency Version

```yml
[GET] /
```

### NPM Type Definitions

```yml
[GET] /
```

### Packagist Dependency Version

```yml
[GET] /packagist/dependency-v/:user/:repo/:dependency

dependency:
  example: php
```

### PowerShell Gallery Platform Support

```yml
[GET] /
```

### Puppet Forge - PDK version

```yml
[GET] /
```

### PyPI - Implementation

```yml
[GET] /
```

### PyPI - Python Version

```yml
[GET] /
```

### PyPI - Versions from Framework Classifiers

```yml
[GET] /
```

### PyPI - Wheel

```yml
[GET] /
```

### Python Version from PEP 621 TOML

```yml
[GET] /
```

### Repology - Repositories

```yml
[GET] /
```

### SourceForge Platform

```yml
[GET] /
```

### Spiget tested server versions

```yml
[GET] /
```

### WordPress Plugin Required PHP Version

```yml
[GET] /
```

### WordPress Plugin: Required WP Version

```yml
[GET] /
```

### WordPress Plugin: Tested WP Version

```yml
[GET] /
```

### WordPress Theme Required PHP Version

```yml
[GET] /
```

### WordPress Theme: Required WP Version

```yml
[GET] /
```

## Rating

### AUR Votes

```yml
[GET] /
```

### Chrome Web Store Rating

```yml
[GET] /
```

### Chrome Web Store Rating Count

```yml
[GET] /
```

### Chrome Web Store Stars

```yml
[GET] /
```

### Docker Stars

```yml
[GET] /
```

### DUB Score

```yml
[GET] /
```

### Greasy Fork Rating

```yml
[GET] /
```

### JetBrains Plugin Rating

```yml
[GET] /
```

### Libraries.io SourceRank

```yml
[GET] /
```

### Libraries.io SourceRank, scoped npm package

```yml
[GET] /
```

### Mozilla Add-on Rating

```yml
[GET] /
```

### Mozilla Add-on Stars

```yml
[GET] /
```

### Open VSX Rating

```yml
[GET] /
```

### Ore Stars

```yml
[GET] /
```

### Packagist Stars

```yml
[GET] /packagist/stars/:user/:repo
```

### Polymart Rating

```yml
[GET] /
```

### Pub Likes

```yml
[GET] /
```

### Pub Points

```yml
[GET] /
```

### Pub Popularity

```yml
[GET] /
```

### Pulsar Stargazers

```yml
[GET] /
```

### Puppet Forge endorsement

```yml
[GET] /
```

### Puppet Forge feedback score

```yml
[GET] /
```

### Spiget Rating

```yml
[GET] /
```

### Steam Favorites

```yml
[GET] /
```

### Steam Subscriptions

```yml
[GET] /
```

### Vaadin Directory Rating

```yml
[GET] /
```

### Vaadin Directory Rating Count

```yml
[GET] /
```

### Visual Studio Marketplace Rating

```yml
[GET] /
```

### WordPress Plugin Rating

```yml
[GET] /
```

### WordPress Plugin Stars

```yml
[GET] /
```

### WordPress Theme Rating

```yml
[GET] /
```

### WordPress Theme Stars

```yml
[GET] /
```

## Size

### Docker Image Size

```yml
[GET] /
```

### Docker Image Size (tag)

```yml
[GET] /
```

### GitHub code size in bytes

```yml
[GET] /
```

### GitHub file size in bytes

```yml
[GET] /
```

### GitHub repo file or directory count

```yml
[GET] /
```

### GitHub repo file or directory count (in path)

```yml
[GET] /
```

### GitHub repo size

```yml
[GET] /
```

### Lines of code

```yml
[GET] /
```

### npm bundle size

```yml
[GET] /
```

### npm bundle size (scoped version)

```yml
[GET] /
```

### npm bundle size (scoped)

```yml
[GET] /
```

### npm bundle size (version)

```yml
[GET] /
```

### npm package minimized gzipped size

```yml
[GET] /
```

### npm package minimized gzipped size (scoped)

```yml
[GET] /
```

### NPM Unpacked Size

```yml
[GET] /
```

### NPM Unpacked Size (with version)

```yml
[GET] /
```

### Spiget Download Size

```yml
[GET] /
```

### Steam File Size

```yml
[GET] /
```

### Visual Studio App Center Size

```yml
[GET] /
```

## Social

### Gitea Forks

```yml
[GET] /
```

### Gitea Stars

```yml
[GET] /
```

### GitHub followers

```yml
[GET] /
```

### GitHub forks

```yml
[GET] /
```

### Github Gist stars

```yml
[GET] /
```

### GitHub Org's stars

```yml
[GET] /
```

### GitHub Repo stars

```yml
[GET] /
```

### GitHub User's stars

```yml
[GET] /
```

### GitHub watchers

```yml
[GET] /
```

### GitLab Forks

```yml
[GET] /
```

### GitLab Stars

```yml
[GET] /
```

### HackerNews User Karma

```yml
[GET] /
```

### Hangar Stars

```yml
[GET] /
```

### Hangar Watchers

```yml
[GET] /
```

### Keybase BTC

```yml
[GET] /
```

### Keybase PGP

```yml
[GET] /
```

### Keybase XLM

```yml
[GET] /
```

### Keybase ZEC

```yml
[GET] /
```

### Lemmy

```yml
[GET] /
```

### Mastodon Follow

```yml
[GET] /
```

### Modrinth Followers

```yml
[GET] /
```

### Nostr.band Followers

```yml
[GET] /
```

### Reddit User Karma

```yml
[GET] /
```

### Subreddit subscribers

```yml
[GET] /
```

### Thunderstore Likes

```yml
[GET] /
```

### Twitch Status

```yml
[GET] /
```

### X (formerly Twitter) Follow

```yml
[GET] /
```

### X (formerly Twitter) URL

```yml
[GET] /
```

### YouTube Channel Subscribers

```yml
[GET] /
```

### YouTube Channel Views

```yml
[GET] /
```

### YouTube Video Comments

```yml
[GET] /
```

### YouTube Video Likes

```yml
[GET] /
```

### YouTube Video Views

```yml
[GET] /
```

## Test Results

### AppVeyor tests

```yml
[GET] /
```

### AppVeyor tests (with branch)

```yml
[GET] /
```

### Azure DevOps tests

```yml
[GET] /
```

### Azure DevOps tests (branch)

```yml
[GET] /
```

### Jenkins Tests

```yml
[GET] /
```

### Sonar Tests

```yml
[GET] /
```

### Sonar Tests (branch)

```yml
[GET] /
```

### Testspace pass ratio

```yml
[GET] /
```

### Testspace tests

```yml
[GET] /
```

### Testspace tests count

```yml
[GET] /
```

## Version

### Arch Linux package

```yml
[GET] /
```

### AUR Version

```yml
[GET] /
```

### Bower Version

```yml
[GET] /
```

### Cdnjs

```yml
[GET] /
```

### Chef cookbook

```yml
[GET] /
```

### Chocolatey Version

```yml
[GET] /
```

### Chrome Web Store Version

```yml
[GET] /
```

### Clojars Version

```yml
[GET] /
```

### Cocoapods Version

```yml
[GET] /
```

### Conan Center

```yml
[GET] /
```

### Conda Version

```yml
[GET] /
```

### CPAN Version

```yml
[GET] /
```

### CRAN/METACRAN Version

```yml
[GET] /
```

### Crates.io Version

```yml
[GET] /
```

### CTAN Version

```yml
[GET] /
```

### CurseForge Version

```yml
[GET] /
```

### Debian package

```yml
[GET] /
```

### Debian package (for distribution)

```yml
[GET] /
```

### Docker Image Version

```yml
[GET] /
```

### Docker Image Version (tag)

```yml
[GET] /
```

### DUB Version

```yml
[GET] /
```

### Eclipse Marketplace Version

```yml
[GET] /
```

### Elm package

```yml
[GET] /
```

### F-Droid Version

```yml
[GET] /
```

### Factorio Mod Portal mod version

```yml
[GET] /
```

### Fedora package

```yml
[GET] /
```

### Fedora package (with branch)

```yml
[GET] /
```

### Feedz Version

```yml
[GET] /
```

### Flathub Version

```yml
[GET] /
```

### Galaxy Toolshed - Repository Version

```yml
[GET] /
```

### Galaxy Toolshed - Tool Requirement Version

```yml
[GET] /
```

### Galaxy Toolshed - Tool Version

```yml
[GET] /
```

### Gem Version

```yml
[GET] /
```

### Gitea Release

```yml
[GET] /
```

### GitHub go.mod Go version

```yml
[GET] /
```

### GitHub go.mod Go version (branch)

```yml
[GET] /
```

### Github lerna version

```yml
[GET] /
```

### Github lerna version (branch)

```yml
[GET] /
```

### GitHub manifest version

```yml
[GET] /
```

### GitHub manifest version (branch)

```yml
[GET] /
```

### GitHub package.json version

```yml
[GET] /
```

### GitHub package.json version (branch)

```yml
[GET] /
```

### GitHub R package version

```yml
[GET] /
```

### GitHub R package version (branch)

```yml
[GET] /
```

### GitHub Release

```yml
[GET] /
```

### GitHub Tag

```yml
[GET] /
```

### GitLab Release

```yml
[GET] /
```

### GitLab Tag

```yml
[GET] /
```

### Gradle Plugin Portal Version

```yml
[GET] /
```

### Greasy Fork Version

```yml
[GET] /
```

### Hackage Version

```yml
[GET] /
```

### Hex.pm Version

```yml
[GET] /
```

### homebrew cask

```yml
[GET] /
```

### homebrew version

```yml
[GET] /
```

### iTunes App Store

```yml
[GET] /
```

### Jenkins Plugin Version

```yml
[GET] /
```

### JetBrains Plugin Version

```yml
[GET] /
```

### JetBrains ReSharper plugins Version

```yml
[GET] /
```

### JitPack

```yml
[GET] /
```

### JSR Version

```yml
[GET] /
```

### LuaRocks

```yml
[GET] /
```

### Maven Central Version

```yml
[GET] /
```

### Maven metadata URL

```yml
[GET] /
```

### Modrinth Version

```yml
[GET] /
```

### Mozilla Add-on Version

```yml
[GET] /
```

### MyGet Version

```yml
[GET] /
```

### MyGet Version (tenant)

```yml
[GET] /
```

### NPM Version

```yml
[GET] /
```

### NPM Version (with dist tag)

```yml
[GET] /
```

### NuGet Version

```yml
[GET] /
```

### Open VSX Version

```yml
[GET] /
```

### OPM Version

```yml
[GET] /
```

### Ore Version

```yml
[GET] /
```

### Packagist Version

```yml
[GET] /packagist/v/:user/:repo
```

### PiWheels Version

```yml
[GET] /
```

### Polymart Version

```yml
[GET] /
```

### PowerShell Gallery Version

```yml
[GET] /
```

### Pub Version

```yml
[GET] /
```

### Puppet Forge version

```yml
[GET] /
```

### PyPI - Version

```yml
[GET] /
```

### ROS Package Index

```yml
[GET] /
```

### Scoop Version

```yml
[GET] /
```

### Snapcraft version

```yml
[GET] /
```

### Sonatype Nexus (Releases)

```yml
[GET] /
```

### Sonatype Nexus (Repository)

```yml
[GET] /
```

### Sonatype Nexus (Snapshots)

```yml
[GET] /
```

### Spack

```yml
[GET] /
```

### Spiget Version

```yml
[GET] /
```

### Thunderstore Version

```yml
[GET] /
```

### Twitch Extension Version

```yml
[GET] /
```

### Ubuntu Package Version

```yml
[GET] /
```

### Ubuntu Package Version (for series)

```yml
[GET] /
```

### Vaadin Directory Version

```yml
[GET] /
```

### Vcpkg Version

```yml
[GET] /
```

### Visual Studio App Center (Minimum) OS Version

```yml
[GET] /
```

### Visual Studio App Center Releases

```yml
[GET] /
```

### Visual Studio Marketplace Version

```yml
[GET] /
```

### VPM Package Version

```yml
[GET] /
```

### WordPress Plugin Version

```yml
[GET] /
```

### WordPress Theme Version

```yml
[GET] /
```
