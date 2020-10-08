![Main workflow](https://github.com/InfluxOW/XSolla-News-Feed/workflows/Main%20workflow/badge.svg)

# News Feed
Xsolla Summer School 2020 (Backend) introductory assignment.

Task: https://github.com/xsolla/xsolla-backend-school-2020#%D0%B2%D0%B0%D1%80%D0%B8%D0%B0%D0%BD%D1%82-2

## Requirements
You can check PHP dependencies with the `composer check-platform-reqs` command.

* PHP ^7.4
* Extensions:
    * mbstring
    * curl
    * dom
    * xml
    * zip
    * sqlite
    * json

## Commands
1. Run `make setup` to setup the project.
2. Run `make test` to run tests.
3. Run `make seed` to seed the database with fake data.
