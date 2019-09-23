“Shoop,” as internet slang in this context, means Photoshopped.

We’re “photoshopping” the way we interact with PHP. Most notably the PHP API, which is fairly criticized regarding inconsistent patterns used (and other criticisms). Wouldn’t it be interesting if a somewhat common API could be created for various languages, which could increase accessibility to not only PHP but other languages as well. As such, Shoop is language agnostic and should be easily portable to other languages.

|Acronym part |Description |
|------------:|:-----------|
| S           |Swift, specifically, its API, basic data types, and emphasis on protocol-oriented programming (composition over inheritance). |
| H           |Haskel, specifically, immutability (stateless) over mutability (stateful), keep side-effects local. 							 |
| OO          |Object-oriented, specifically, encapsulation by way of namespacing.                                                           |
| P           |Procedural, specifically, not a logical style but giving the computer a sequence of statements to be executed.                |

Classes SHOULD be viewed only as an entry point not necessarily the result. (The return value may not be of the same type as the one starting it.)

## Principles & Recommendations

### Functions

Functions SHOULD NOT reside in the global scope and namespace.

### Clases

Classes SHOULD favor composition over inheritance.

Classes SHOULD follow the open-closed principle.

Sub-classes MUST NOT override superclass implementation.

Sub-classes SHOULD inherit from the base type directly AND the inheritance hierarchy MUST NOT exceed three levels.

### Class Properties & Methods

Class properties MUST BE declared `protected` or `private` (preferring `private`).

Class methods SHOULD follow the Single Responsibility Principle (SRP) by doing one thing.

Class methods SHOULD be named to favor the result, rather than the command (ex. “sum” over “add”).

Class methods SHOULD NOT mutate state outside of itself and MUST NOT mutate state beyond the class in which they are defined.

## Possible naming convention

// Prefix reserved words - further namespacing
// (could also be all of them has the prefix)
class ESBool {}

class ESString {}

class ESCharacter {}

Class ESInt {}

class ESDouble {}

class ESFloat {}

class ESRange {
	static public function init(Int $min, Int $max, bool $includesMax = true);
}

class ESClosedRange {}

class ESArray {}

class ESDictionary {}

class ESSet {}

 // Rename classes and let the initializers handle conflicts
class Boolean {}

class Symbols {
	static public function init() {}

	static public function character() {}

	static public function string() {}
}

class Number {
	static public function init() {}

	static public function int() {}

	static public function double() {}

	static public function float() {}
}

class Range {
	static public function init($x, $y, true) {}
}

class Collection {
	static public function init() {}

	static public function array() {}

	static public function dictionary() {}

	static public function set() {}
}

## Governance

- Higher the number, higher the priority (labels on issues)
