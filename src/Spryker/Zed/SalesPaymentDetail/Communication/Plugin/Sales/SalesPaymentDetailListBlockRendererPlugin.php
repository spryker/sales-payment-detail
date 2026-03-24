<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesPaymentDetail\Communication\Plugin\Sales;

use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\SalesExtension\Dependency\Plugin\SalesDetailBlockRendererPluginInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Zed\SalesPaymentDetail\Communication\SalesPaymentDetailCommunicationFactory getFactory()
 * @method \Spryker\Zed\SalesPaymentDetail\Business\SalesPaymentDetailFacadeInterface getFacade()
 * @method \Spryker\Zed\SalesPaymentDetail\Persistence\SalesPaymentDetailRepositoryInterface getRepository()
 */
class SalesPaymentDetailListBlockRendererPlugin extends AbstractPlugin implements SalesDetailBlockRendererPluginInterface
{
    protected const string BLOCK_URL = '/sales-payment-detail/sales/list';

    /**
     * {@inheritDoc}
     * - Checks if the block URL is '/sales-payment-detail/sales/list'.
     *
     * @api
     *
     * @param string $blockUrl
     *
     * @return bool
     */
    public function isApplicable(string $blockUrl): bool
    {
        return $blockUrl === static::BLOCK_URL;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $blockUrl
     *
     * @return string
     */
    public function getTemplatePath(string $blockUrl): string
    {
        return '@SalesPaymentDetail/Sales/list.twig';
    }

    /**
     * {@inheritDoc}
     * - Returns payment metadata for the order as template data.
     *
     * @api
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param string $blockUrl
     *
     * @return array<string, mixed>
     */
    public function getData(Request $request, OrderTransfer $orderTransfer, string $blockUrl): array
    {
        $salesPaymentDetailTransfer = $this->getRepository()
            ->findByEntityReference((string)$orderTransfer->getOrderReference());

        return ['salesPaymentDetail' => $salesPaymentDetailTransfer ? $salesPaymentDetailTransfer->toArray() : null];
    }
}
