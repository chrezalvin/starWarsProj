<?php
    /**
     * Clamps a number so it doesn't go over or under a certain value
     * @param $min the minimum value
     * @param $max the maximum value
     * @param $value the value to clamp
     * @return the clamped value
     */
    function clamp($min, $max, $value){
        return max($min, min($max, $value));
    }

    /**
     * @template T
     * @param callable(T):bool $fcn the function to call
     * @param array<T> $arr the array to search
     * @return T|null the object that matches the function
     **/
    function search_array(callable $fcn, array $arr){
        foreach($arr as $item){
            if($fcn($item))
                return $item;
        }
        return null;
    }

    /**
     * @template T
     * @param callable(T):bool $fcn the function to call
     * @param array<T> $arr the array to search
     * @return bool if the array includes the function
     */
    function array_includes(callable $fcn, array $arr){
        foreach($arr as $item){
            if($fcn($item))
                return true;
        }
        return false;
    }
