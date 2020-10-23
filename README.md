# Confluence Changelog

Creates Confluence pages for git tags containing JIRA issue links.

[travis-img]: https://img.shields.io/travis/remindgmbh/confluence-changelog.svg?style=flat-square
[codecov-img]: https://img.shields.io/codecov/c/github/remindgmbh/confluence-changelog.svg?style=flat-square
[php-v-img]: https://img.shields.io/packagist/php-v/remind/confluence-changelog?style=flat-square
[github-issues-img]: https://img.shields.io/github/issues/remindgmbh/confluence-changelog.svg?style=flat-square
[contrib-welcome-img]: https://img.shields.io/badge/contributions-welcome-blue.svg?style=flat-square
[license-img]: https://img.shields.io/github/license/remindgmbh/confluence-changelog.svg?style=flat-square
[styleci-img]: https://styleci.io/repos/306676364/shield

[![travis-img]](https://travis-ci.com/github/remindgmbh/confluence-changelog)
[![codecov-img]](https://codecov.io/gh/remindgmbh/confluence-changelog)
[![styleci-img]](https://github.styleci.io/repos/306676364)
[![php-v-img]](https://packagist.org/packages/remind/confluence-changelog)
[![github-issues-img]](https://github.com/remindgmbh/confluence-changelog/issues)
[![contrib-welcome-img]](https://github.com/remindgmbh/confluence-changelog/blob/master/CONTRIBUTING.md)
[![license-img]](https://github.com/remindgmbh/confluence-changelog/blob/master/LICENSE)

--------------------------------------------------------------------------------

## Example

Could be used during CI to collect and bundle the referenced issues.

### Run confluence changelog generator

This will run the documentor and create a page for each tag name in a
Confluence space with the id 'ABC' under the parent page titled 'Changelog'.
Every issue id found after the latest tag will be put on a page titled
'develop' under the same parent.

```shell
./vendor/bin/conflog document --spacekey ABC --token xyz --ancestor Changelog --uri https://myname.atlassian.net/wiki/rest/api/
```

### Display help for the command

```shell
./vendor/bin/conflog help document
```

--------------------------------------------------------------------------------

## Authors
- REMIND GmbH - <technik@remind.de>
- Hauke Schulz - <h.schulz@remind.de>
