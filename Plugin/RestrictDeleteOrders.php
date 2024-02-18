<?php

namespace TechImprovement\DeleteOrders\Plugin;

use Magento\Ui\Component\MassAction;
use TechImprovement\DeleteOrders\Helper\Data;

class RestrictDeleteOrders
{
    /**
     * @var Data
     */
    protected Data $helperData;

    /**
     * @param Data $helperData
     */

    public function __construct(
        Data $helperData
    )
    {
        $this->helperData = $helperData;
    }

    /**
     * @param MassAction $subject
     * @param $result
     * @return mixed
     */

    public function afterPrepare(MassAction $subject, $result): mixed
    {
        if (!$this->helperData->isModuleEnabled()) {
            $config = $subject->getData('config');
            if (isset($config['actions'])) {
                foreach ($config['actions'] as $key => $action) {
                    if (isset($action['type']) && $action['type'] === 'delete-orders') {
                        unset($config['actions'][$key]);
                        $subject->setData('config', $config);
                        break;
                    }
                }
            }
        }

        return $result;
    }
}
