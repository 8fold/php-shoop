![Illustration of final code sample](https://github.com/8fold/php-shoop/blob/master/zzAssets/shoop-flow.png?raw=true)

# 8fold Shoop for PHP

8fold Shoop is a horizontally-consistent interface into PHP, whereas PHP is described as a vertically-consistent interface into C.

An oft cited criticism of PHP is its inconsistent API. PHP's creator, [Rasmus, has explained it](https://youtu.be/Qa_xVjTiOUw) this way (paraphrased):

> PHP is perfectly consistent, just not the way you expect. It's vertically consistent. So, for every function in PHP,  if you look at what's underneath it, the `libc` function under some of the string functions, for example, the argument order and naming matches what they're built upon. So, there's not consistency horitzontally, but there's perfect consistency vertically digging down into the stack.

If you are familiar with and use classes form [Illuminate Support](https://laravel.com/api/5.5/Illuminate/Support.html) portion of Laravel or some of the [Symfony Components](https://symfony.com/doc/current/components/index.html), you're familiar with this desire and other solutions to the same horizontally inconsistent API problem.

Shoop's approach emphasizes, in no particular order:

* Human-readability: Chaining methods and applying filters should result in a relatively easy to follow sentence-like structure.
* Ubiquitous naming across types: Fluent Shoop types should minimize type-specific methods whenever possible. Filter functions should have a rational output across all supported PHP types.
* Immutability: Methods and Filters return new instances of types, not a mutated variation of the same instance.
* Type-safety: Methods use Filters, Filters specify the PHP type whenever possible, without limiting flexibility.
* `null` is not a type.

While this immplementation is language-specific, the fundamental concepts, patterns, and naming strive to be language agnostic.

PHP is extremely [simple for new developers](https://www.php.net/manual/en/intro-whatis.php), Shoop follows this tradition.

## Installation

```
composer require 8fold/php-shoop
```

## Usage

You can interact with a Shoop type like a PHP string.

```php
// A regular PHP string
$string = "Hello!";

$reversed = Shoop::string($string)->toggle();

print $reversed;

// output: !olleH
```

You can use the same method names horitzontally across Shoop types to reduce cognitive load. (You can also interact with a Shoop type like a PHP array.)

```php
// A regular PHP array
$array = [0, 1, 2];

print $array[0];

// output: 0

$reversed = Shoop::array($array)->toggle();

// becomes: [2, 1, 0]

print $reversed[0];

// output: 2
```
Shoop is unobtrusive to your developer workflow even when PHP can't interact with it directly.

```php
$array = [true, false, false];

// We are not aware of a way to let PHP know how to respond to an instance as a boolean value.
if (Shoop::array($array)->first()->unfold()) {}

// One step instead of two
if (Shoop::array($array)->firstUnfolded()) {}

// One step using object property notation
if (Shoop::array($array)->first) {}

// all three output: true
```

Let's try something more complex.

Shoop types, by default, return other Shoop types. This, coupled with a majority ubiquitous API allows for chaining (not quite pipes, currently not available in PHP). As such, each chain is almost like creating a functional program wherein you can change the start and get a different output, without modifying the functional code. (Don't have to use different function from the PHP standard library.)

We might talk more about that later, for now, let's say we have the path to a folder:

`/Users/8fold/Desktop/ProjectSupreme/SecretFolder/SecretSubfolder`

And we want to move to a different folder:

`/Users/8fold/Documents/ProjectMaxEffort/SecretFolder/SecretSubfolder`


```php
// Our starting path
$path = "/Users/8fold/Desktop/ProjectSupreme/SecretFolder/SecretSubfolder";

// PHP standard library - one way
$parts = explode("/", $path);
$slice = array_slice($parts, -4);
$parts[] = "Documents";
$parts[] = "ProjectMaxEffort";
$parts[] = "SecretFolder";
$parts[] = "SecretSubfolder";
if (count($parts) === 6) {
  $path = "/". implode("/", $parts);

} else {
  $path = "Not the Middle Path.";
}

// Shoop
$path = Shoop::string($path)
  ->divide("/")
  ->dropLast(4)
  ->plus(
      "Documents",
      "ProjectMaxEffort",
      "SecretFolder",
      "SecretSubfolder"
  )->countIsGreaterThanOrEqualTo(6, function($result, $array) {
    return ($result->unfold())
      ? $array->join("/")
      : "Not the Middle Path.";
  });

print $path; // both should be: /Users/8fold/Documents/ProjectMaxEffort/SecretFolder/SecretSubfolder
```

## Definitions

> Communication is hard because language is soft.

These definitions are meant to be accessible to new developers, not necessarily technically accurate.

### Nouns

* Member: An assignable or callable property, method, or key in an array.
* Content: What has been assigned to a Member.
* Data type:
* Method:
* Filter:

### Verbs

We strive for minimal verbs to maximize capability while minimizing cognitive load. Verbs are the root of Method and Filter names.

* Drop:
* Assign:
* Pull:
* Split:
* Join:
* Add:
* Subtract:
* Multiply:
* Divide:
* Has:
* Lacks:
* Is:

### Types and type juggling

|Shoop      |PHP                |content\|storage |Details and deviations                           |
|:---------:|:-----------------:|:---------------:|:------------------------------------------------|
|Boolean    |boolean            |content          |Same as PHP                                      |
|Integer    |integer or float   |content          |All whole numbers. ex. 1 or 1.0                  |
|Number     |integer or float   |content          |All real numbers. ex. 1 or 1.0 or 1.1            |
|List       |array              |storage          |Abstract: Any Shoop Array or Dictionary          |
|Array      |array              |storage          |Integer members in sequence, using array access. |
|Dictionary |array              |storage          |String members unordered, using array access.    |
|Tuple      |stdClass or object |storage          |String members unordered, using object access. All instances of PHP stdClass are Shoop Tuples. Class instances with public properties and no public methods are also considered Shoop Tuples. |
|Json       |string             |storage          |A Tuple represented as a String starting and ending with left and right curly braces, respectively. |
|Object     |object             |storage          |Abstract: A PHP object (excluding stdClass) implementing at least one public method. |

Abstract Shoop types are types that can be juggled *from* but not *to*. When juggling from the abstract type to a concrete type, the rules of that type are applied. ex. Juggling from Object to Dictionary removes all methods and private properties.

Any Shoop type can be juggled (cast) as any other Shoop type, except an object as those are defined by users and fed into Shoop.

Each filter (function) identifies a canonical type and response. For example, the canonical type for `pullFirst` is a Shoop Array. Most types uses an alternative type to start the juggle to whatever other type is desired. The following identifies the first alternate Shoop type for each type:

```
Object      -> Tuple (removes all privates and methods, public properties only)
Json       <-> Tuple
Tuple      <-> Dictionary
Dictionary  -> Array (replaces string keys with sequential integers)
String     <-> Array
Array      <-> Integer
Integer    <-> Number
Boolean    <-> Integer (0 or 1)
```

This flow means Shoop primarily has two types: Dictionary and Number. The former are key-value associations and the latter is all real numbers. This flow also means mutations moving upward may be more dramatic than moving down. For example:

```
Integer -> Array (results in an array from a user-specified starting number up to and including the value of the original integer, default is 0)
Array   -> Integer (the count of elements in the array - or other non-number type)
Array   -> Dictionary (prefixes each integer index with a user-specified string prefix, default is "efs")
Integer -> Dictionary (goes through an Array transformation first)
Boolean -> Dictionary (has a "true" and "false" key; if the original boolean is true, the value of "true" will be true, otherwise will be false, the oppisite applies to the "false" key.)
```

We do our best to ensure results of transformations are rational. For example, Dictionary, Tuple, and Json types have string-based, named members that store values. Therefore, juggling between those three mainly changes the preferred access method or native language in the case of JSON. Finally, juggling from one type to another may not include all options available for any in-between steps.

If you have a recommendation for what you believe is a more rational default, please do submit a PR or issue.

### What's in a name?

Shoop, as an acronym, points to the insipirations of the library: Swift, Haskell (functional programming and immutability), Object-Oriented (encapsulation, composition, and communication), and Procedural (sequential, logical programming).

Shoop, as a word, is akin to "photoshopping" (and sounds nicer than "Foops").

Shoop, as a name, is the title of a song by Salt-N-Pepa released in 1993 and used in the first installment of the [Deadpool](https://youtu.be/FOJWJmlYxlE) franchise in 2016.

## Project

- [Versioning](https://github.com/8fold/php-shoop/blob/master/.github/VERSIONING.md)
- [Contributing](https://github.com/8fold/php-shoop/blob/master/.github/CONTRIBUTING.md)
- [Governance](https://github.com/8fold/php-shoop/blob/master/.github/GOVERNANCE.md)

### Naming conventions

ES{type}: Shoop types MUST be named using the ES (Eightfold Shoop) prefixed concatenated with the type name following [PSR-12 guidelines](https://www.php-fig.org/psr/psr-12/) with no spaces. ex. ESBool indicates that the class represents a PHP `bool`.

{interface name}: Shoop interfaces SHOULD be named after the categorization of the methods found within, which is admittedly subjective.

{insterface name}Imp: Shoop traits holding the generic implementations of the methods in the interface MUST be prefixed with the name of the interface and suffixed with "Imp," denoting one is the definition while the other is the declaration.

{test suite name}Test: Tests MUST follow standard phpUnit naming conventions.

php_{magic method name}{description}Test: Test classes with a "php_" prefix and "Test" suffix indicate the methods under test directly involve a PHP magic method. The optional description is used to indicate what is being tested, usually only used if more than one possibility exists. ex. php_Call uses `__call()`.

php{interface name}{method name}Test: Test classes prefixed with "php" followed by the name of a PHP interface name (ex. Iterator), indicates the methods under test is one of those found in the interface, which comes after the interface name and prior to the obligatory "Test" suffix.

We use the term "member" as an umbrella that covers an index for values in indexed arrays, keys for values in associative arrays, and members for values in JSON and objects.

## History

This library has been under development since the beginning of 2019 and has been used in the majority of 8fold projects since the middle of 2019. With every new project created we tried to go without it but found ourselves becoming annoyed, which is why we've decided to make it a more formal project and library consumable by others.
