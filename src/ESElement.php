<?php

namespace Eightfold\Shoop;

// use Eightfold\HtmlComponent\Interfaces\Compile;

// use Eightfold\HtmlComponent\Traits\HasParent;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Interfaces\Shooped;

use Eightfold\Shoop\Traits\ShoopedImp;

class ESElement implements Shooped
{
    use ShoopedImp;

    const openingFormat = "<%s%s>";

    protected $element = '';

    protected $extends = '';

    protected $role = '';

    protected $content;

    protected $omitEndTag = false;

    protected $attributes = [];

    static public function fold($args)
    {
        return new static($args);
    }

    // static public function make(string $element, Compile ...$content)
    // {
    //     $self = new static(...$content);

    //     $self->element = $element;

    //     return $self->attr(...$attributes);
    // }

    public function __construct($elements)
    {
        $this->element = Type::sanitizeType($elements[0], ESString::class)->unfold();
        $this->element = str_replace("_", "-", $this->element);
        unset($elements[0]);

        $this->value = $elements;
    }

    public function unfold()
    {
        $elem = $this->element;
        if (strlen($this->extends) > 0) {
            $elem = $this->extends;
            $this->attr("is {$this->element}");
        }

        $attributes = Shoop::array([]);
        foreach ($this->attributes as $key => $value) {
            $attributes = $attributes->plus("{$key}=\"{$value}\"");
        }
        $attributes = $attributes->join(" ");
        if (strlen($attributes) > 0) {
            $attributes = $attributes->start(" ");
        }

        $opening = "<{$elem}{$attributes}>";

        $content = "";
        foreach ($this->value as $value) {
            if (Type::isShooped($value)) {
                $content .= $value->unfold();

            } else {
                $value = Type::sanitizeType($value, ESString::class);
                $content .= $value;

            }
        }

        $closing = "</{$elem}>";
        if ($this->omitEndTag) {
            $closing = "";
        }
        return $opening . $content . $closing;
    }

// - Type Juggling
    public function string(): ESString {}

    public function array(): ESArray {}

    public function dictionary(): ESDictionary {}

    public function object(): ESObject {}

    public function int(): ESInt {}

    public function bool(): ESBool {}

    public function json(): ESJson {}

// - PHP single-method interfaces
// - Math language
    public function multiply($int) {}

// - Other
    public function attr(string ...$attributes): ESElement
    {
        foreach ($attributes as $attribute) {
            if (strlen($attribute) > 0) {
                // return array where
                // [0] is string before first space and
                // [1] is string after first space
                list($key, $value) = Shoop::string($attribute)->split(" ")->unfold(); // explode(' ', $attribute, 2);
                $this->attributes[$key] = $value;
            }
        }
        return $this;
    }

    public function extends($extends): ESElement
    {
        $extends = Type::sanitizeType($extends, ESString::class);
        $this->extends = $extends;
        return $this;
    }

    public function omitEndTag(bool $omit = true): ESElement
    {
        $this->omitEndTag = $omit;
        return $this;
    }

    // public function getElement(): string
    // {
    //     return $this->element;
    // }

    // private function isWebComponent(): bool
    // {
    //     return (strlen($this->element) > 0 && strlen($this->extends) > 0);
    // }

    // public function role(string $role): Component
    // {
    //     $this->role = $role;
    //     return $this;
    // }

    // public function attr(string ...$attributes): ESElement
    // {
    //     foreach ($attributes as $attribute) {
    //         if (strlen($attribute) > 0) {
    //             // return array where
    //             // [0] is string before first space and
    //             // [1] is string after first space
    //             list($key, $value) = $this->splitFirstSpace($attribute);
    //             $this->attributes[$key] = $value;
    //         }
    //     }
    //     return $this;
    // }

    // protected function splitFirstSpace(string $attribute): array
    // {
    //     return explode(' ', $attribute, 2);
    // }

    // unfold
    // public function compile(string ...$attributes): string
    // {
    //     $this->attr(...$attributes);

    //     $elementName = str_replace('_', '-', $this->element);
    //     if ($this->isWebComponent()) {
    //         $this->attr("is {$elementName}");
    //         $elementName = $this->extends;
    //     }

    //     if (strlen($this->role) > 0) {
    //         $this->attr("role {$this->role}");
    //     }

    //     $attributes = $this->compileAttributes();
    //     if (strlen($attributes) > 0) {
    //         $attributes = ' '. $attributes;
    //     }

    //     $opening = "<{$elementName}{$attributes}>";

    //     $closing = ($this->hasEndTag())
    //         ? "</{$elementName}>"
    //         : '';

    //     $content = $this->compileContent($this->content);

    //     return $opening . $content . $closing;
    // }

    // private function hasEndTag(): bool
    // {
    //     return ( ! $this->omitEndTag);
    // }

    // private function compileAttributes(): string
    // {
    //     $string = [];
    //     foreach ($this->attributes as $key => $value) {
    //         if ($key == $value && strlen($value) > 0) {
    //             // required=required => required
    //             $string[] = $value;

    //         } else {
    //             $string[] = "{$key}=\"{$value}\"";

    //         }
    //     }
    //     return implode(' ', $string);
    // }

    // private function compileContent($contentToCompile): string
    // {
    //     $content = '';
    //     if ($contentToCompile instanceof Compile) {
    //         $content = $contentToCompile->parent($this)->compile();

    //     } elseif (is_array($contentToCompile)) {
    //         foreach ($contentToCompile as $maker) {
    //             $content .= $this->compileContent($maker);

    //         }
    //     }
    //     return $content;
    // }

    // public function print(string ...$attributes)
    // {
    //     return print $this->compile(...$attributes);
    // }

    // public function echo(string ...$attributes)
    // {
    //     echo $this->compile(...$attributes);
    // }

    // public function __toString()
    // {
    //     return $this->compile();
    // }
}
