<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;

/**
 * @phpstan-require-extends Model
 */
trait FormatsApproximatePrice
{
    public function approximatePriceLabel(?string $fallbackCurrency = null): ?string
    {
        $priceFrom = $this->getAttribute('price_from');

        if ($priceFrom === null) {
            return null;
        }

        $currency = $this->getAttribute('currency') ?? $fallbackCurrency ?? 'USD';
        $from = Number::currency((float) $priceFrom, in: $currency);
        $priceTo = $this->getAttribute('price_to');

        if ($priceTo !== null) {
            return $from.'–'.Number::currency((float) $priceTo, in: $currency);
        }

        return $from.'+';
    }
}
