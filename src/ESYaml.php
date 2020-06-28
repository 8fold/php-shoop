<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\{
    Type,
    SymfonyYaml
};

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    Compare,
    MathOperations,
    Sort,
    Toggle,
    Wrap,
    Drop,
    Has,
    IsIn,
    Each
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    // CompareImp,
    // MathOperationsImp,
    // SortImp,
    // ToggleImp,
    // WrapImp,
    // DropImp,
    // HasImp,
    // IsInImp,
    // EachImp
};

use Eightfold\Shoop\ESDictionary;

class ESYaml implements Shooped //, Compare, MathOperations, Wrap, Drop, Has, IsIn, Each, \JsonSerializable
{
    use ShoopedImp; //, CompareImp, ToggleImp, MathOperationsImp, SortImp, WrapImp, DropImp, HasImp, IsInImp, EachImp;

    /**
     * @todo Need a solution for the path
     */
    protected $path = "";

    static public function to(ESYaml $instance, string $className)
    {
        if ($className === ESArray::class) {
            return SymfonyYaml::toIndexedArray($instance->value());

        } elseif ($className === ESBool::class) {
            return SymfonyYaml::toBool($instance->value());

        } elseif ($className === ESDictionary::class) {
            return SymfonyYaml::toAssociativeArray($instance->value());

        } elseif ($className === ESInt::class) {
            return PhpJson::toInt($instance->value());

        } elseif ($className === ESJson::class) {
            return $instance->value();

        } elseif ($className === ESObject::class) {
            return PhpJson::toObject($instance->value());

        } elseif ($className === ESString::class) {
            return $instance->value();

        } elseif ($className === ESYaml::class) {
            return $instance->value();

        }
    }

	public function __construct($initial)
	{
		if (Type::isYaml($initial)) {
			$this->value = $initial;

		} else {
            $exception = null;
            try {
                $value = Yaml::parse($initial);

            } catch (ParseException $e) {
                $exception = $e;

            }
            $message = $exception->getMessage();
			trigger_error("Given string does not appear to be valid YAML: {$initial}\n{$message}", ParseException::class);

		}
	}

    // TODO: yamlSerialize - not a PHP-native method but would further the JSON parallel
}
