<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use Eightfold\Shoop\Foldable\Foldable;

trait AddableImp
{
    public function plus($value)
    {
        // if (Type::is($this, ESArray::class)) {
        //     $array = $this->main();
        //     $count = count($args);
        //     if ($count === 0) {
        //         return static::fold($array);
        //     }
        //     $merged = array_merge($array, $args);
        //     return Shoop::array($merged);

        // } elseif (Type::is($this, ESDictionary::class)) {
        //     // TODO: Pretty sure this should be the same expections as set()
        //     $dictionary = $this->main();
        //     $suffixes = PhpIndexedArray::toValueMemberAssociativeArray($args);
        //     $dictionary = array_merge($dictionary, $suffixes);
        //     return Shoop::dictionary($dictionary);

        // } elseif (Type::is($this, ESInteger::class)) {
        //     $total = $this->main();
        //     foreach ($args as $term) {
        //         $term = Type::sanitizeType($term, ESInteger::class)->unfold();
        //         $total += $term;
        //     }
        //     return Shoop::integer($total);

        // } elseif (Type::is($this, ESJson::class)) {
        //     // TODO: Pretty sure this should be the same expectations as set()
        //     $dictionary = PhpIndexedArray::toValueMemberAssociativeArray($args);
        //     $object = json_decode($this->main());
        //     foreach ($dictionary as $member => $value) {
        //         $object->{$member} = $value;
        //     }
        //     $json = json_encode($object);
        //     return Shoop::json($json);

        // } elseif (Type::is($this, ESTuple::class)) {
        //     // TODO: Pretty sure this should be the same expectations as set()
        //     //      or that set, should use plus()
        //     $dictionary = PhpIndexedArray::toValueMemberAssociativeArray($args);
        //     $object = (object) $dictionary;
        //     return Shoop::object($object);

        // } elseif (Type::is($this, ESString::class)) {
        //     // $total = $this->unfold();
        //     // $terms = $args;
        //     // foreach ($terms as $term) {
        //     //     $term = Type::sanitizeType($term, ESString::class)->unfold();
        //     //     $total .= $term;
        //     // }
        //     // return Shoop::string($total);
        // }
    }
}
