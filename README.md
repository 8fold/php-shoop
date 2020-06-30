# 8fold Shoop for PHP

8fold Shoop is a wrapper that seeks to a create a rational and nearly ubiquitous API for interacting with PHP primitives.

While the immplementations are language-specific, the fundamental concepts strive to be language agnostic: contracts, inheritence, and generic implementations via traits (in PHP).

## What's in a name?

Shoop, as an acronym, points to the insipirations of the library: Swift, Haskell (functional programming and immutability), Object-Oriented (encapsulation, composition, and communication), and Procedural (sequential, logical programming).

Shoop, as a word, is akin to "photoshopping" (and sounds nicer than "Foops").

Shoop, as a name, is the title of a song by Salt-N-Pepa released in 1993 and used in the first installment of the [Deadpool](https://youtu.be/FOJWJmlYxlE) franchise in 2016.

## Installation

```
composer require 8fold/php-shoop
```

## Usage

```php
// A regular PHP string
$string = "Hello!";

$reversed = Shoop::string($string)->toggle();

print($reversed);

// output: !olleH
```

You can see the Shoop type works seamlessly within the standard PHP environment (specifically as native PHP strings and arrays).

Speaking of PHP API complaints, that means arrays can be immediately changed to strings. This does put a little more responsibility on the user.

```php
print(Shoop::string("Hello!")->first());

// output: H
```

Sometimes you will want to explicitly unfold the value of the Shoop type.

```php
$string = Shoop::string("Hello!")->first();

var_dump($string->unfold());

// string: H

$unfolded = Shoop::string("Hello!")->firstUnfolded();

var_dump($unfolded);

// string: H

$property = Shoop::string("Hello!")->first;

// string: H
```

Let's try a more complex manipulation as these examples only marginally better than the standard library.

```php
// Let's say we have a folder path:
// /Users/josh/Desktop/ProjectSupreme/SecretFolder/SecretSubfolder
// And we want to have the following path:
// /Users/josh/Documents/ProjectMaxEffort/SecretFolder/SecretSubfolder

// One way in PHP might look something like this
$path = "/Users/josh/Desktop/ProjectSupreme/SecretFolder/SecretSubfolder";

// PHP standard library
$parts = explode("/", $path);
array_pop($parts); // ../
array_pop($parts); // ../
array_pop($parts); // ../
array_pop($parts); // ../
$parts[] = "Documents";
$parts[] = "ProjectMaxEffort";
$parts[] = "SecretFolder";
$parts[] = "SecretSubfolder";
$path = "/". implode("/", $parts);

// Shoop
$path = Shoop::string($path)
	->divide("/")
	->dropLast(4)
	->plus("Documents", "ProjectMaxEffort", "SecretFolder", "SecretSubfolder")
	->join("/")
	->start("/");

print($path); // both should be: /Users/josh/Documents/ProjectMaxEffort/SecretFolder/SecretSubfolder
```

### A note on YAML (ESYaml)

`ESYaml` is design to take accept one block of YAML, not a document containing YAML parts. Therefore, parsing of YAML parts should be done before folding those parts into individual `ESYaml` instances.

Almost any string can, strictly speaking, be considered YAML. Therefore, to help minimize confusion, to considered valid YAML in Shoop, the string must start with three hyphens (-), followed by a new line character, followed by almost any character.

So, if you have Markdown with YAML front matter such as the following example:

```markdown
---
hello
---
```

If you parse out the following string, Shoop will be able to recognize it as valid YAML, and will return an `ESYaml` instance with "hello" as the value:

```markdown
---
hello
```

Note: If the following Markdown YAML front matter is given, the trailing three hyphens will be removed, also leaving just "hello":

```markdown
---
hello
---
```

When you `unfold` an `ESYaml` instance, we will wrap the resulting string in triple hyphens to further facilitate type juggling and automation.

## Why?

The PHP standard library and APIs have been criticized a bit over the years. Not for lack of functionality or robustness; rather, most noteably, inconsistent pattern usage and naming. We think this criticism is actually justified. Given how long PHP has been around and how many times various aspects have changed hands, the standard library and API list is expansive (I've been using it since 2005, and continue to find new things).

## Guiding Principles

Classes SHOULD be viewed only as an entry point not the result.

Classes SHOULD favor composition over inheritance. The inheritance hierarchy MUST NOT exceed three levels.

Classes SHOULD follow the open-closed principle.

Class properties MUST BE declared `protected` or `private` (preferring `private`).

Class methods SHOULD follow the Single Responsibility Principle (SRP) by doing one thing.

Class methods SHOULD NOT mutate state outside of themselves and MUST NOT mutate state beyond the class in which they are defined.

Class methods SHOULD NOT use Shoop to solve a specified problem.

## Versioning

We follow [semantic versioning](https://semver.org/). We are operating under a [zero-major](https://semver.org/#spec-item-4) at this time. `x.y.z`: `x` = major, `y` = minor, `z` = patch. In this case `x` remains at 0 to communicate that APIs may come and go without warning. With that said, changes to `y` are typically reserved for breaking changes and changes to `z` represent added features and APIs or bug fixes.

## Contibuting

Anyone can submit PRs to add funcationality as we are only adding things we need for the solutions we are developing.

Please submit PRs from a fork of this project. If you are part of the core team, you are not required to fork the project.

Each PR will be reviewed, including those submitted by core developers (no direct push).

ALL type classes must conform to the Shooped interface to all leveraging of the type system by users.

The criteria for adding new capabilities is:

1. The capability must be needed (or used) in a production application.
2. The capability cannot eaily be achieved by stacking, chaining, or otherwise piping present capaiblities together.

### Naming conventions

ES{type}: Shoop types MUST be named using the ES (Eightfold Shoop) prefixed concatenated with the type name following [PSR-12 guidelines](https://www.php-fig.org/psr/psr-12/) with no spaces. ex. ESBool indicates that the class represents a PHP `bool`.

{interface name}: Shoop interfaces SHOULD be named after the categorization of the methods found within, which is admittedly subjective.

{insterface name}Imp: Shoop traits holding the generic implementations of the methods in the interface MUST be prefixed with the name of the interface and suffixed with "Imp," denoting one is the definition while the other is the declaration.

{test suite name}Test: Tests MUST follow standard phpUnit naming conventions.

php_{magic method name}{description}Test: Test classes with a "php_" prefix and "Test" suffix indicate the methods under test directly involve a PHP magic method. The optional description is used to indicate what is being tested, usually only used if more than one possibility exists. ex. php_Call uses `__call()`.

php{interface name}{method name}Test: Test classes prefixed with "php" followed by the name of a PHP interface name (ex. Iterator), indicates the methods under test is one of those found in the interface, which comes after the interface name and prior to the obligatory "Test" suffix.

We use the term "member" as an umbrella that covers an index for values in indexed arrays, keys for values in associative arrays, and members for values in JSON and objects.

## Governance

- Higher the number, higher the priority (labels on issues).
- [Benevolant Dictatorship](https://github.com/8fold/php-shoop/blob/master/GOVERNANCE.md) for now.

## History

This library has been under development since the beginning of 2019 and has been used in the majority of 8fold projects since the middle of 2019. With every new project created we tried to go without it but found ourselves becoming annoyed, which is why we've decided to make it a more formal project and library consumable by others.





