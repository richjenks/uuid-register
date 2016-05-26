# UUID Register

General-purpose register for in-use UUIDs able to generate an available ID or check whether a given ID is in use.

UUIDs are, [for all intents and purposes](http://stackoverflow.com/a/39776/1562799), unique and the probability of collision is considered negligable.

However, if for any reason you wish to ensure that a UUID is in fact unique, this small application serves as a register enabling you to do so. For example, issuing single-use tokens or ensuring IDs are unique accross distributed systems under eventual consistency.

## Usage

HTTP GET requests will generate a UUID that has not already been registered and respond with that UUID in the response body. An HTTP status code of 201 will confirm that success.

Appending a query string to the URI will test whether the given string has been registered and will respond with either a 200 or 404 status code, depending on whether the string was found or not. To support this, the response body will be "1" or "0" depending on whether the string was found or not.

## Examples

`http://uuid-register.dev` returns 201 response with `dc2b8155-2ff8-46ed-8e29-f5c81b328349` body.

Then, `http://uuid-register.dev?dc2b8155-2ff8-46ed-8e29-f5c81b328349` would return a 200 response with `1` body.

However, `http://uuid-register.dev?dc2b8155-2ff8-46ed-8e29-f5c81b328340` would return a 404 response with `0` body.