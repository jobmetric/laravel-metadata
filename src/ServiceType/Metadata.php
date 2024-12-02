<?php

namespace JobMetric\Metadata\ServiceType;

use JobMetric\CustomField\CustomField;

/**
 * Class Metadata
 *
 * @package JobMetric\Metadata\ServiceType
 */
class Metadata
{
    /**
     * The custom field instance.
     *
     * @var CustomField $customField
     */
    public CustomField $customField;

    /**
     * The has filter status.
     *
     * @var bool $hasFilter
     */
    public bool $hasFilter = false;

    /**
     * Metadata constructor.
     *
     * @param CustomField $customField
     * @param bool $hasFilter
     */
    public function __construct(CustomField $customField, bool $hasFilter = false)
    {
        $this->customField = $customField;
        $this->hasFilter = $hasFilter;
    }
}
