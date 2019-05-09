“Shoop,” as internet slang in this context, means Photoshopped. 

We’re “photoshopping” the way we interact with PHP. Most notably the PHP API, which is fairly criticized regarding inconsistent patterns used (and other criticisms). Wouldn’t it be interesting if a somewhat common API could be created for various languages, which could increase accessibility to not only PHP but other languages as well. As such, Shoop is language agnostic and should be easily portable to other languages.

|Acronym part |Description |
|------------:|:-----------|
| S           |Swift, specifically, its API, basic data types, and emphasis on protocol-oriented programming (composition over inheritance). |
| H           |Haskel, specifically, immutability (stateless) over mutability (stateful), keep side-effects local. 							 |
| OO          |Object-oriented, specifically, encapsulation by way of namespacing.                                                           |
| P           |Procedural, specifically, not a logical style but giving the computer a sequence of statements to be executed.                |

Classes SHOULD favor composition over inheritance.

Classes SHOULD be viewed only as an entry point not necessarily the result. (The return value may not be of the same type as the one starting it.)

Classes SHOULD follow the open-closed principle.

Classes SHOULD NOT allow direct access to property members.

Functions SHOULD NOT reside in the global scope and namespace.

Class methods SHOULD follow the Single Responsibility Principle (SRP) by doing one thing.

Class methods SHOULD be named to favor the result, rather than the command (ex. “sum” over “add”).

Class methods SHOULD NOT mutate state outside of itself and MUST NOT mutate state beyond the class in which they are defined.