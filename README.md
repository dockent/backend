# Dockent: Back-end

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dockent/backend/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dockent/backend/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/dockent/backend/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/dockent/backend/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/dockent/backend/badges/build.png?b=master)](https://scrutinizer-ci.com/g/dockent/backend/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/dockent/backend/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![GitHub Issues](https://img.shields.io/github/issues-raw/ScaryDonetskiy/Phalcon-Migration-Runner.svg)]()

Dockent - it's Web GUI for Docker.

### Usage ###

In this repository you have a Dockerfile for starting all parts of Dockent project.

```bash
docker build -t dockent:latest .
docker run -it -d -p 8080:8080 -v /var/run/docker.sock:/var/run/docker.sock dockent:latest
```

### Contribution guidelines ###

* Writing tests
* Code review
* Guidelines accord