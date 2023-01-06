<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $amazon_price
 * @property float $product_weight
 * @property float $width
 * @property float $height
 * @property float $depth
 */

class Item
{
    protected $amazon_price;
    protected $product_weight;
    protected $width;
    protected $height;
    protected $depth;
    protected $fee_by_product_type;
    public function __construct($amazon_price, $product_weight, $width, $height, $depth, $fee_by_product_type = null)
    {
        $this->amazon_price = $amazon_price;
        $this->product_weight = $product_weight;
        $this->width = $width;
        $this->height = $height;
        $this->depth = $depth;
        $this->fee_by_product_type = $fee_by_product_type;
    }

    const WEIGHT_COEFFICIENT = 11;

    const DIMENSION_COEFFICIENT = 11;

    /**
     * calculator item price
     * @return float|int
     */
    public function calItemPrice()
    {
        return $this->amazon_price * $this->calShippingFee();
    }

    /**
     * calculator fee by weight
     * @return float|int
     */
    private function calFeeByWeight()
    {
        return $this->product_weight * self::WEIGHT_COEFFICIENT;
    }

    /**
     * calculator fee by dimension
     * @return float|int
     */
    private function calFeeByDimension()
    {
        return $this->width * $this->height * $this->depth * self::DIMENSION_COEFFICIENT;
    }

    /**
     * calculator Shipping fee
     * @param $input
     * @return mixed
     */
    private function calShippingFee()
    {
        return max($this->calFeeByWeight(), $this->calFeeByDimension(), $this->fee_by_product_type);
    }

}
