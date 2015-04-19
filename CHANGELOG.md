# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased] / [unreleased]

### Fixed:
  - Bug fix: Listener propagation to child classes.
  - Bug fix: `Http\Client::delListener()` now actually deletes the listener

### Changed:
  - Better docs available at http://gentlero.github.io/duckduckgo-api/
  - Added helper methods for setting/getting application name.
  - Added possibility to set extra parameters for each endpoint.
  - Simplified ClientInterface.
  - `verify_peer` option for HTTP transport client is now enabled by default.
  - More tests

### Added:
  - Added Api::api() as a single entry point.
  - Added JsonBodyListener which can be used to decode json response.
  - OpenSSL PHP extension is now required.

## 0.1.0 / 2014-10-20

  - First public release
