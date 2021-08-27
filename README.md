Parameter Verify
================
A simple package to verify a set of array values, which are most likely
parameters in a call. Sometimes you cannot specify in a list of arguments
perhaps because it's too long, or because they might vary too much between
derived class types.

This class is configured with an array which provides what values are required
and their types. Non-required values can also be included to be checked - in
which case they are only checked if they are present.

The main function returns an array of errors. If it's empty then everything
was fine.

Structure
---------
The settings array looks like this:
```php
[
  'name' => [
    'required' => true,
    'type' => 'string',
    'data' => '',
    'range' => []
  ]
]
```
The 'name' is the key value in the array being tested (the name of the 
_property_).

Only the 'type' key is mandatory, and must be one of the acceptable values;
the 'required' key is assumed false if missing; some types require an
additional data string, for a 'regex' type it's the regular expression, for
the 'class' type it's the fully qualified class name, and so on.

The 'range' key applies to string, int and float, and allows length and
range restrictions to be inserted.

If a named parameter is in the settings array but not "required", no error is
generated if it's missing, but it will be tested if it is present.

Types
-----
The complete list of types:
 - **any** matches anything
 - **null** matches only a null value (for completeness, you never know)
 - **class** matches a specific class or interface (FQN in 'data')
 - **object** matches any object
 - **array** matches any array
 - **int** matches an integer value (and can have a range)
 - **bool** only matches true or false
 - **float** matches a float value (and can have a range)
 - **string** matches any string (and can have a range)
 - **string_list** matches a string against a fixed list of strings (in 'data'
   separated by '|'). This is an old style "enum" which is also used to verify
   the types of the settings/configuration items.
 - **regex** tests a string with a regular expression (in 'data')
 - **callable** only matches a callable
 - **resource** only matches a resource
 - **url** matches a string which is also a valid URL
 - **email** matches a string which is also a valid email address
 - _**enum** only matches a PHP8.1 enum  (FQN in 'data')_

How to use it
-------------
```php
$settings = [
  'name' => [
    'required' => true,
    'type' => 'string'
  ],
  'value' => [
    'required' => true,
    'type' => 'int'
    'range' => [
      'min_value' => 1,
      'max_value' => 10
    ]
  ]
];

$paramVerifyFactory = new \ParamVerify\ParamVerifyFactory();

// This checks the settings and will throw an exception on error.
$verifier = $paramVerifyFactory->make($settings);

// Will return an error because 'name' is missing.
$parameters = ['value' => 5];
$errors = $verifier->verify($parameters);

// Will return no errors.
$parameters = ['name' => 'banana', 'value' => 5];
$errors = $verifier->verify($parameters);

// Will return an error because value is out of range.
$parameters = ['name' => 'banana', 'value' => 15];
$errors = $verifier->verify($parameters);

// Will return an error because name is not a string.
$parameters = ['name' => ['banana'], 'value' => 15];
$errors = $verifier->verify($parameters);
```

Future
------
 - Allow verification of sub-arrays (with repeated entries);
