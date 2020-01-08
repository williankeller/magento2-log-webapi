<?php

namespace Magestat\LogWebapi\Model\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Format
 * Configuration options to the log creation.
 */
class Format implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => 1,
                'label' => __('Create a Different File Each Day')
            ],
            [
                'value' => 2,
                'label' => __('Concat All the Data to the Same File')
            ]
        ];
    }
}
