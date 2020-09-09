# 8fold Shoop for PHP

Shoop is a horizontally-consistent interface into PHP, whereas PHP could be described as a vertically-consistent interface into C.

Shoop is built on [8fold Foldable](https://github.com/8fold/php-foldable) allowing for ubiquitous construction of data objects.

## Installation

```
composer require 8fold/php-shoop
```

## Usage

Contrived examples...live examples coming soon and available in the tests folder.

Apply a single filter.

```php
Apply::plus(1)->unfoldUsing(2);
// indirect call to output: 3

Plus::applyWith(1)->unfoldUsing(2);
// direct call to output: 3
```

Pipe multiple filters.

```php
Shoop::pipe(2,
  Apply::plus(1),
  Apply::divide(1)
)->unfold();
// output: 3
```

Nesting pipes and filters. (Variation on part of the `PlusAt` Filter.)

```php
Shoop::pipe([1, 2, 3],
  Apply::from(0, 1), // output: [1, 2]
  Apply::plus("hello"), // output: [1, 2, "hello"]
  Apply::plus(
    Apply::from(1)->unfoldUsing([1, 2, 3]) // output: [3]
  )
)->unfold();
// output [1, 2, "hello", 3]
```

Fluent using method chaining.

```php
Shoop::this(2)->plus(1)->divide(2)->unfold();
// output 1.5

Shooped::fold(2)->plus(1)->divide(2)->unfold();
// output: 1.5
```

### Types and type juggling

- Content (abstract):
  - Boolean (`boolean`, Shoop `sequential`): same as PHP.
  - Number (`float` or `integer`, Shoop `sequential`): all real numbers.
    - Integer (`integer`, Shoop `sequential`): all whole numbers.
  - String (`string` not `JSON`, Shoop `sequential`): sequence of characters.
- Collection (abstract): contains mixed content, collections, or objects accessible using members.
  - List (abstract - `array`): A PHP `array` that does not comply with being a Shoop Dictionary or Array
    - Dictionary (`array`): non-sequential string keys or empty, values accessed using array notion. ex. $var[]
    - Array (`array`, Shoop `sequential`): sequential integer keys.
  - Tuple (`stdClass` or `object`): non-sequential string members, accessed using object notation, not string notation, and contains no methods. ex. $var->
    - JSON (`string`): longer than two characters, begins with opening curly-brace, ends with closing curly-brace, and can be decoded without error.
- Object (`object`): contains at least one public method.

Abstract Shoop types can be juggled *from* but not *to*. Juggling from abstract type to concrete using Shoop method applies the type rules. ex. Juggling from Object to Dictionary removes methods and private properties.

We offer multiple Interfaces and default Implementations for juggling between the supported, concrete types. Each interface offers two methods: one returns an object implementing the interface and the other returns the PHP types. The former are prefixed with "as" for use in Fluent Interfaces. The latter are prefixed with "ef" and can be thought of as similar to [PHP Magic Methods](https://www.php.net/manual/en/language.oop5.magic.php) which are prefixed with a double-underscore (`__`). See:

### PHP deviations

#### Boolean

|Shoop                                            |Shoop result                                 |PHP equivalent   |PHP result                  |
|:------------------------------------------------|:--------------------------------------------|:----------------|:---------------------------|
|`TypeAsInteger::apply()->unfoldUsing(false)`     |0                                            |`count(false)`   |PHP warning                 |
|`TypeAsString::apply()->unfoldUsing(false)`      |"false"                                      |`(string) false` |"0"                         |
|`TypeAsArray::apply()->unfoldUsing(false)`       |[0 => true, 1 => false]                      |`(array) false`  |[0] => false                |
|`TypeAsDictionary::apply()->unfoldUsing(false)`  |["false" => true, "true" => false]           |''               |''                          |
|`TypeAsTuple::apply()->unfoldUsing(false)`       |object(["false"] => true, ["true"] => false) |`(object)` false |object(["scalar"] => false) |

#### Number and integer

|Shoop                                            |Shoop result                                   |PHP equivalent   |PHP result                  |
|:------------------------------------------------|:----------------------------------------------|:----------------|:---------------------------|
|`TypeAsInteger::apply()->unfoldUsing(2)`         |2                                              |`count(2)`       |PHP warning                 |
|`TypeAsArray::apply()->unfoldUsing(2)`           |[0 => 0, 1 => 1, 2 => 2]                       |`(array) 2`      |[0 => 2]                    |
|`TypeAsDictionary::apply()->unfoldUsing(2)`      |["i0" => 0, "i1" => 1, "i2" => 2]              |''               |''                          |
|`TypeAsTuple::apply()->unfoldUsing(2)`           |object(["i0"] => 0, ["i1"] => 1, ["i2"] => 2]) |`(object) 2`     |object(["scalar"] => 2)     |

Should array to tuple be the PHP default for array to object?? Reduces deviations.

#### String

|Shoop                                            |Shoop result                                  |PHP equivalent   |PHP result                  |
|:------------------------------------------------|:---------------------------------------------|:----------------|:---------------------------|
|`TypeAsInteger::apply()->unfoldUsing("Hi!")`     |3                                             |`(int) "Hi!"`    |0                           |
|`TypeAsInteger::apply()->unfoldUsing("Hi!")`     |3                                             |`count("Hi!")`   |PHP warning                 |
|`TypeAsArray::apply()->unfoldUsing("Hi!")`       |[0 => "H", 1 => "i", 2 => "!"]                |`(array) "Hi!"`  |[0 => "Hi!"]                |
|`TypeAsDictionary::apply()->unfoldUsing("Hi!")`  |["content" => "Hi!"]                          |''               |''                          |
|`TypeAsTuple::apply()->unfoldUsing("Hi!")`       |object(["content"] => "Hi!")                  |`(object) "Hi!"` |object(["scalar"] => "Hi!") |

#### Dictionary, tuple, and JSON

Ditionary and tuple deviate from PHP in similar ways, syntax might be different.

|Shoop                                                       |Shoop result     |PHP equivalent                 |PHP result                     |
|:-----------------------------------------------------------|:----------------|:------------------------------|:------------------------------|
|`TypeAsInteger::apply()->unfoldUsing(["a" => 1, "b" => 2])` |2                |`(int) ["a" => 1, "b" => 2]`   |1                              |
|`TypeAsInteger::apply()->unfoldUsing(["a" => 1, "b" => 2])` |2                |`count(["a" => 1, "b" => 2])`  |2                              |
|`TypeAsString::apply()->unfoldUsing(["a" => 1, "b" => 2])`  |"", configurable |`(string) ["a" => 1, "b" => 2]`|PHP Notice: Array to string... |
|`TypeAsArray::apply()->unfoldUsing(["a" => 1, "b" => 2])`   |[0 => 1, 1 => 2] |`(array) ["a" => 1, "b" => 2]` |["a" => 1, "b" => 2]           |

Note: A JSON string is converted to a Tuple, and a Tuple is converted to a Dictionary.

Note: The default implementation of the PHP JsonSerialize interface results in the PHP type being converted to a Shoop Tuple, then being encoded.

#### Array

|Shoop                                                |Shoop result                         |PHP equivalent        |PHP result                         |
|:----------------------------------------------------|:------------------------------------|:---------------------|:----------------------------------|
|`TypeAsInteger::apply()->unfoldUsing(["a", "b"])`    |2                                    |`(int) ["a", "b"]`    |1                                  |
|`TypeAsString::apply()->unfoldUsing(["a", "b"])`     |"ab", configurable                   |`(string) ["a", "b"]` |PHP Notice: Array to string...     |
|`TypeAsDictionary::apply()->unfoldUsing(["a", "b"])` |["i0" => "a", "i1" => "b"]           |`(array) ["a", "b"]`  |["a", "b"]                         |
|`TypeAsTuple::apply()->unfoldUsing(["a", "b"])`      |object(["i0"] => "a", ["i1"] => "b") |`(object) ["a", "b"]` |object(["0"] => "a", ["1"] => "b") |

Should array to tuple be the PHP default for array to object?? Reduces deviations. Accessing those properties doesn't work as expected.

ex. $object = object(["0"] => 1, ["1"] => 2):

- $object->0   = parse error
- $object->"0" = parse error
- $object->{0} = expected behavior

#### Object

ex. `$using = new class {}`

|Shoop                                         |Shoop result                                         |PHP equivalent    |PHP result                  |
|:---------------------------------------------|:----------------------------------------------------|:-----------------|:---------------------------|
|`TypeAsBoolean::apply()->unfoldUsing($using)` |false: Opposite of `IsEmpty`, can be overridden      |`(bool) $using`   |true, cannot be overridden  |
|`IsEmpty::apply()->unfoldUsing($using)`       |true: Boolean of `TypeAsInteger`, can be overridden  |`empty($using)`   |false, cannot be overridden |
|`TypeAsInteger::apply()->unfoldUsing($using)  |0 (count of public properties), can be overridden    |`(int) $using`    |PHP Notice...               |
|`TypeAsNumber::apply()->unfoldUsing($using)   |0.0 (count of public properties)                     |`(float) $using`  |''                          |
|`TypeAsString::apply()->unfoldUsing($using)   |"" (concatenated string properties), can be overridden |`(string) $using` |''                          |
|`TypeAsArray::apply()->unfoldUsing($using)    |[]                                                   |`(array) $using`  |[]                          |
|`TypeAsTuple::apply()->unfoldUsing($using)    |object(): all methods and private properties removed |`(object) $using` |object(): all methods are removed, private properties remain |

### What's in a name?

Shoop, as an acronym, points to the insipirations of the library:

- Swift, Smalltalk, and Squeak;
- Haskell (functional programming and immutability);
- Object-Oriented (encapsulation, composition, and communication); and
- Procedural (sequential, logical programming).

Shoop, as a word, is akin to "photoshopping" (and sounds nicer than "Foops").

Shoop, as a name, is the title of a song by Salt-N-Pepa released in 1993 and used in the first installment of the [Deadpool](https://youtu.be/FOJWJmlYxlE) franchise in 2016.

## Project

A `Filter` should only return a PHP data type, not an object.

`Shooped` methods MUST have a rational default for all Shoop types.

The `Shooped` object MAY contain functions that take advantage of filters; however, filters should never use an instance of `Shooped`.

The `Shooped` object MAY contain functions that do not have an equivalent filter.

For more general advice see our [Contributing](https://github.com/8fold/php-shoop/blob/master/.github/CONTRIBUTING.md) documentation.

### Goals

The primary goals for Shoop, in no particular order:

* Plain language (approachable): PHP is pretty accessible to new developers who maybe don't have a computer science background; Shoop continues this theme.
* Syntactically and semantically light: PHP is understandably heavy on syntax (special characters to help the parser) and semantically expansive when it comes to capabilities (short function names, but many of them). We review Filters and capabilities based on production need, not gut feel and "because we can."
* Immutable: Whenever possible, we return new instances and values as opposed to altering the state.
* Type-safe: The flexibility of Shoop means we don't check types every step along the way, but do check types before returning the result of a request.
* Defer processing: Whenever possible we defer processing until the last possible moment.
* Ubiquity across types: We favor a small number of filters that can then be minimally configured using arguments.
* DRY (don't repeat yourself): We strive to leverage capabilities already available in Shoop rather than implementing PHP solutions; most of the Filters came from developing a different Filter.
* Let nothing mean nothing: As developers, we spend a lot of time accounting for, working around, and defending against things that represent nothing. `null` is arguably the most known thing representing nothing, Shoop doesn't use nor account for `null`. `false` also equates to zero, which represents nothing. The idea that zero represents nothing is the primary argument for Shoop arrays to start at one, as requesting the "nothing index" should always result in receiving nothing...something cannot be contained by nothing.

An oft cited criticism of PHP is its inconsistent API. PHP's creator, [Rasmus, has explained it](https://youtu.be/Qa_xVjTiOUw) this way (paraphrased):

> PHP is perfectly consistent, just not the way you expect. It's vertically consistent. So, for every function in PHP,  if you look at what's underneath it, the `libc` function under some of the string functions, for example, the argument order and naming matches what they're built upon. So, there's not consistency horitzontally, but there's perfect consistency vertically digging down into the stack.

If you use classes from the [Illuminate Support](https://laravel.com/api/5.5/Illuminate/Support.html) portion of Laravel or some of the [Symfony Components](https://symfony.com/doc/current/components/index.html), you're familiar with the desire for horizontally consistent APIs problem (even beyond PHP itself).

While this immplementation is language-specific, the fundamental concepts, patterns, and naming strive to be language agnostic.

PHP is extremely [simple for new developers](https://www.php.net/manual/en/intro-whatis.php), Shoop follows this tradition.

### Other

- [Versioning](https://github.com/8fold/php-shoop/blob/master/.github/VERSIONING.md)
- [Governance](https://github.com/8fold/php-shoop/blob/master/.github/GOVERNANCE.md)

## History

This library has been under development since the beginning of 2019 and has been used in the majority of 8fold projects since the middle of 2019. With every new project created we tried to go without it but found ourselves becoming annoyed, which is why we've decided to make it a more formal project and library consumable by others.
