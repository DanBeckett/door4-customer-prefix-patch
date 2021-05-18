<?php namespace Door4\CustomerPrefixPatch\Plugin\Sales\Model\Order\Address;

use Magento\Sales\Model\Order\Address;
use Magento\Customer\Model\Options;

class PrefixPatch {

    protected Options $options;

    public function __construct(
        Options $options
    ) {
        $this->options = $options;
    }

    public function afterGetData(Address $subject, $result)
    {
        if (is_array($result) && (!empty($result['prefix']) || $result['prefix'] === "0")) {
            $result['prefix'] = $this->formatPrefix($result['prefix']);
        }
        return $result;
    }

    public function afterGetPrefix(Address $subject, $result)
    {
        return $this->formatPrefix($result);
    }

    private function formatPrefix(?string $prefixValue) : ?string {
        if (array_key_exists($prefixValue, $prefixOptions = $this->options->getNamePrefixOptions())) {
            return $prefixOptions[$prefixValue];
        }
        return $prefixValue;
    }
}
