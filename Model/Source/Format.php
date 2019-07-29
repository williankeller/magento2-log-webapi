<?php

/**
 * Log Webapi: Module provides log in file for all transactions in Web API.
 * Copyright (C) Magestat
 *
 * This file included in Magestat/LogWebapi is licensed under OSL 3.0
 *
 * http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * Please see LICENSE.txt for the full text of the OSL 3.0 license
 */

namespace Magestat\LogWebapi\Model\Source;

/**
 * Class Format
 */
class Format implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Get options as array
     *
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
