# Change Log
All notable changes to this project will be documented in this file.

## 0.2.0 / 2014-xx-yy

  - Bug fix: `Http\Client::delListener()` now actually deletes the listener
  - Added helper methods for setting/getting application name.
  - Simplified ClientInterface.
  - Added Api::api() as a single entry point.
  - `verify_peer` option for HTTP transport client is now enabled by default.
  - Added JsonBodyListener which can be used to decode json response.
  - More tests

## 0.1.0 / 2014-10-20

  - First public release
