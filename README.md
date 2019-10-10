8fold Shoop creates a predominately ubiquitous API for interacting with and manipulating PHP primitives and a bit beyond. While the implementations are language specific, the underlying concepts are language agnostic.

Shoop has many meanings, in this context it is most akin to "photoshopping" (and we thought it was catchier than "Foops," though the 1993 song by Salt-N-Pepa is pretty catchy as well). Shoop is also an acronym turned proper noun for Swift, Haskell, Objer-Oriented, and Procedural (or Functional, Object-Oriented, Procedural, and Swift, which could have quickly become f*cking oops as though this library was unintentionally designed).

We’re “photoshopping” the way we interact with PHP primitives (and more). The PHP standard library and APIs have been criticized a fair amount over the years. Not for lack of functionality or robustness; rather, most noteably, inconsistent pattern usage and naming. We think this criticism is actually fair. Given how long PHP has been around and how many times various aspects have changed hands, the standard library and API list is also expansive (I've been using it since 2005, and continue to find new things).

8fold Shoop is inspired by:

- the basic data types, APIs, and protocol oriented nature of Swift;
- the desire of functional programming to favor immutability and keep side-effects local to a given scope;
- the encapsulation, composition, and communication of object-oriented programming; and
- the step-by-step sequence style of procedural programming compared to something like logical programming.

## Guiding Principles

Classes SHOULD be viewed only as an entry point not the result.

Classes SHOULD favor composition over inheritance.

Classes SHOULD follow the open-closed principle.

Sub-classes SHOULD inherit from the base type directly AND the inheritance hierarchy MUST NOT exceed three levels.

Class properties MUST BE declared `protected` or `private` (preferring `private`).

Class methods SHOULD NOT reside in the global scope or namespace.

Class methods SHOULD follow the Single Responsibility Principle (SRP) by doing one thing.

Class methods SHOULD NOT mutate state outside of themselves and MUST NOT mutate state beyond the class in which they are defined.

Class methods SHOULD NOT use Shoop to solve problem.

## Shooped

The `Shooped` interface defines the base methods needed in order to say an object can play inside the Shoop-land.

- `__construct($initial)`
- `fold($args)`
- `unfolded()`

## Governance

- Higher the number, higher the priority (labels on issues).
- Benevolant Dictatorship for now.
