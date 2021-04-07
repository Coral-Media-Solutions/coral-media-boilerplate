<?php


namespace CoralMedia\Component\Printing\Helper;


class DoubleSidedHelper
{
    public function getABLabels(array $elements)
    {
        $this->_validateInput($elements);


    }

    private function _validateInput(array $elements)
    {
        if (count($elements) % 2 !== 0) {
            throw new \InvalidArgumentException('Input does not contains an even number of elements');
        }
    }
}