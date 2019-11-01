8fold Shoop creates a near ubiquitous API for interacting with and manipulating PHP primitives and a bit beyond. While the implementations are language specific, the underlying concepts are language agnostic.

Shoop has many meanings, in this context it is most akin to "photoshopping" (and we thought it was catchier than "Foops"). Shoop is also a song by Salt-N-Pepa released in 1993 (and [Deadpool favorite](https://youtu.be/FOJWJmlYxlE)).

For our purposes, Shoop is also an acronym turned proper noun standing for Swift, Haskell, Object-Oriented, and Procedural (or Functional, Object-Oriented, Procedural, and Swift, which could be interpreted as f*cking oops as though this library was an accident or poorly designed - one might argue the latter).

We’re “photoshopping” the way we interact with PHP primitives (and more). The PHP standard library and APIs have been criticized a bit over the years. Not for lack of functionality or robustness; rather, most noteably, inconsistent pattern usage and naming. We think this criticism is actually justified. Given how long PHP has been around and how many times various aspects have changed hands, the standard library and API list is expansive (I've been using it since 2005, and continue to find new things).

8fold Shoop is inspired by:

- the basic data types, APIs, and protocol-oriented nature of Swift;
- the desire of functional programming to favor immutability and keeping side-effects local to a given scope;
- the encapsulation, composition, and communication of object-oriented programming; and
- the step-by-step sequence style of procedural programming compared to something like logical programming.

## Usage

We have done our best to ensure Shoop types work seamlessly within the standard PHP environment. All Shoop types, for example, can be interacted with as native strings and arrays. They can also be type juggled to any other type...yes, even arrays directly to strings (speaking of API complaints).

```php
// Just a regular string.
// What if we want to print the "H"?
$string = "Hello!";

// Standard PHP (long)
$result = array_shift(preg_split("//u", $string, null, PREG_SPLIT_NO_EMPTY));

// Standard PHP (short) - PHP 5.3+
$result = $string[0];

// Shoop (full)
$result = Shoop::string($string)->first()->unfold();

// Shoop (shorthand)
$result = Shoop::string($string)->firstUnfolded();

// Shoop String is PHP string; therefore,
// no need to unfold the result to print, php will recognize it.
$result = Shoop::string($string)->first();

// Shoop String is PHP string w/ array access; therefore,
// no need to make the method call.
$shoop = Shoop::string($string);
$result = $shoop[0];

print($result); // Results in "H" for all of the above.
```

Of course, something that has been made simple by PHP 5.3+ itself isn't why we enjoy using Shoop.

One other, simple exmaple would be to go from one file path (string) to another in one shot.

```php
// Let's say we are here:
// /Users/josh/Desktop/ProjectSupreme/SecretFolder/SecretSubfolder
// And we want to get here:
// /Users/josh/Documents/ProjectMaxEffort/SecretFolder/SecretSubfolder

// One way might look something like this.
$path = "/Users/josh/Desktop/ProjectSupreme/SecretFolder/SecretSubfolder";

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

## Guiding Principles

Classes SHOULD be viewed only as an entry point not the result.

Classes SHOULD favor composition over inheritance. The inheritance hierarchy MUST NOT exceed three levels.

Classes SHOULD follow the open-closed principle.

Class properties MUST BE declared `protected` or `private` (preferring `private`).

Class methods SHOULD follow the Single Responsibility Principle (SRP) by doing one thing.

Class methods SHOULD NOT mutate state outside of themselves and MUST NOT mutate state beyond the class in which they are defined.

Class methods SHOULD NOT use Shoop to solve a specified problem.

## Governance

- Higher the number, higher the priority (labels on issues).
- Benevolant Dictatorship for now.





