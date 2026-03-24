<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\SalesPaymentDetail\Communication\Plugin\Sales;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\OrderTransfer;
use Orm\Zed\SalesPaymentDetail\Persistence\SpySalesPaymentDetail;
use Spryker\Zed\SalesPaymentDetail\Communication\Plugin\Sales\SalesPaymentDetailListBlockRendererPlugin;
use SprykerTest\Zed\SalesPaymentDetail\SalesPaymentDetailCommunicationTester;
use Symfony\Component\HttpFoundation\Request;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group SalesPaymentDetail
 * @group Communication
 * @group Plugin
 * @group Sales
 * @group SalesPaymentDetailListBlockRendererPluginTest
 * Add your own group annotations below this line
 */
class SalesPaymentDetailListBlockRendererPluginTest extends Unit
{
    protected const string BLOCK_URL = '/sales-payment-detail/sales/list';

    protected const string OTHER_URL = '/other/url';

    protected SalesPaymentDetailCommunicationTester $tester;

    public function testIsApplicableReturnsTrueForMatchingUrl(): void
    {
        // Arrange
        $plugin = $this->getBlockRendererPlugin();

        // Act
        $result = $plugin->isApplicable(static::BLOCK_URL);

        // Assert
        $this->assertTrue($result);
    }

    public function testIsApplicableReturnsFalseForNonMatchingUrl(): void
    {
        // Arrange
        $plugin = $this->getBlockRendererPlugin();

        // Act
        $result = $plugin->isApplicable(static::OTHER_URL);

        // Assert
        $this->assertFalse($result);
    }

    public function testGetTemplatePathReturnsExpectedPath(): void
    {
        // Arrange
        $plugin = $this->getBlockRendererPlugin();

        // Act
        $result = $plugin->getTemplatePath(static::BLOCK_URL);

        // Assert
        $this->assertSame('@SalesPaymentDetail/Sales/list.twig', $result);
    }

    public function testGetDataReturnsSalesPaymentDetailKey(): void
    {
        // Arrange
        $plugin = $this->getBlockRendererPlugin();
        $orderTransfer = (new OrderTransfer())->setOrderReference('non-existing-reference');

        // Act
        $result = $plugin->getData(new Request(), $orderTransfer, static::BLOCK_URL);

        // Assert
        $this->assertArrayHasKey('salesPaymentDetail', $result);
        $this->assertNull($result['salesPaymentDetail']);
    }

    public function testGetDataReturnsSalesPaymentDetailForExistingReference(): void
    {
        // Arrange
        $orderReference = 'test-order-reference-' . uniqid();
        $paymentDetails = ['amount' => 1000, 'currency' => 'EUR'];

        $paymentDetailEntity = (new SpySalesPaymentDetail())
            ->setEntityReference($orderReference)
            ->setPaymentReference('payment-ref-' . uniqid())
            ->setDetails(json_encode($paymentDetails));
        $paymentDetailEntity->save();

        $plugin = $this->getBlockRendererPlugin();
        $orderTransfer = (new OrderTransfer())->setOrderReference($orderReference);

        // Act
        $result = $plugin->getData(new Request(), $orderTransfer, static::BLOCK_URL);

        // Assert
        $this->assertArrayHasKey('salesPaymentDetail', $result);
        $this->assertIsArray($result['salesPaymentDetail']);
        $this->assertSame($orderReference, $result['salesPaymentDetail']['entity_reference']);
    }

    public function getBlockRendererPlugin(): SalesPaymentDetailListBlockRendererPlugin
    {
        return new SalesPaymentDetailListBlockRendererPlugin();
    }
}
