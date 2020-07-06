![Illustration of final code sample](https://github.com/8fold/php-shoop/blob/master/zzAssets/shoop-flow.png?raw=true)

# 8fold Shoop for PHP

8fold Shoop provides minimal linguistic differentiation and maximum utility for manipulating base data types.

Shoop is as close to interacting with native PHP types as we can get without writing a PHP extension and asking you to install it.

Shoop is not a framework. A drawback to many frameworks is they're often like learning a new language that exists on top of the base language.

While the immplementations are language-specific, the fundamental concepts strive to be language agnostic: contracts, inheritence, and generic implementations via traits (in PHP).

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
array_pop($parts); // ../
array_pop($parts); // ../
array_pop($parts); // ../
array_pop($parts); // ../
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
	->plus("Documents", "ProjectMaxEffort", "SecretFolder", "SecretSubfolder")
	->countIsGreaterThanOrEqualTo(6, function($result, $array) {
		return ($result->unfold())
			? $array->join("/")
			: "Not the Middle Path.";
	});

print $path; // both should be: /Users/8fold/Documents/ProjectMaxEffort/SecretFolder/SecretSubfolder
```

## Why?

[Rasmus](https://en.wikipedia.org/wiki/Rasmus_Lerdorf), the creator of PHP, has mentioned criticisms of PHP in multiple talks over the years. In [one talk](https://youtu.be/Qa_xVjTiOUw?t=1007) (that I had close at hand), Rasmus mentions a criticism I've often heard and even made in the past: Naming inconsistencies. To which he responded (paraphrased):

> PHP is perfectly consistent, just not the way you expect. It's vertically consistent. So, for every function in PHP,  if you look at what's underneath it, the `libc` function under some of the string functions, for example, the argument order and naming matches what they're built upon. So, there's not consistency horitzontally, but there's perfect consistency vertically digging down into the stack. [There] was just no way, that I could create a horizontally consistent design of a language that I didn't know was going to become a languge at all in an environment that was changing too rapidly. [So, all the people coming from Oracle, it was easy for them to interact with the parts sitting on top of Oracle. But, if you jumped from MySQL to Oracle, it would be painful, like a different language.]

That was a long quote, but we like to be as fair as we can. This makes sense. This is also why I don't complain so much about the inconsisttencies in the language, as such. With that said, I think we can make Shoop be that more horizontally satisfying variant for interacting with PHP base types. Not only that, but I think many developers (self included) want it but maybe don't know it yet.

One of the praise points for the popular Laravel framework is its drive toward generic interfaces into multiple, disparate underlying structures. Switch from MySQL to NoSQL to something custom without having to revisit your other code. Use Stripe, PayPal, or something else, without having to rewrite your checkout code.

So, I think this particular criticism of PHP is justified *and* at the same time completely understandable.

I don't like dependencies, even when I write them. Therefore, I can also honestly say, after using Shoop to develop multiple live projects from low-level libraries to higher-level websites:

> I always start by avoiding using Shoop &mdash; and, I always end up grabbing it after about the first class or two.

## What's in a name?

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
