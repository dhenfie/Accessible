# CHANGELOG
## v1.0.0 (2023-09-19)
- Initial Release

## v1.1.0 (2023-09-23)
- Remove method `getMethod()` and `getMethod()`
- Rename  method `allow()` to `inspect()`
- Prevent public method a invoked

## v1.2.0 (2023-10-4)
- Rename method `inspector()` to `inspectorMethod`
- Improvement error handler 
  - Trying to call a public method will return a message that this method is public and can be called without needing this library.
  - throw `BadMethodException` class when invoke undefined method.
- new helper method `accessible($object)` as alternative short syntax for `Accessible::inspect($object)`
- Support accessing and set value on private / protected property