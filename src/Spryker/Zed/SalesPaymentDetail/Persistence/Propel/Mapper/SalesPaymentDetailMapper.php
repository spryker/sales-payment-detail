<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesPaymentDetail\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\SalesPaymentDetailTransfer;
use Orm\Zed\SalesPaymentDetail\Persistence\SpySalesPaymentDetail;

class SalesPaymentDetailMapper
{
    public function mapSalesPaymentDetailTransferToSalesPaymentDetailEntity(
        SalesPaymentDetailTransfer $salesPaymentDetailTransfer,
        SpySalesPaymentDetail $salesPaymentDetailEntity
    ): SpySalesPaymentDetail {
        return $salesPaymentDetailEntity->fromArray($salesPaymentDetailTransfer->toArray());
    }

    public function mapSalesPaymentDetailEntityToSalesPaymentDetailTransfer(
        SpySalesPaymentDetail $salesPaymentDetailEntity,
        SalesPaymentDetailTransfer $salesPaymentDetailTransfer
    ): SalesPaymentDetailTransfer {
        $salesPaymentDetailTransfer->fromArray($salesPaymentDetailEntity->toArray(), true);
        $salesPaymentDetailTransfer->setStructuredDetails(json_decode((string)$salesPaymentDetailEntity->getDetails(), true));

        return $salesPaymentDetailTransfer;
    }
}
