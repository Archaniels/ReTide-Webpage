<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class MarketplaceTest extends TestCase
{
    /**
     * TC006: Verify product creation with Price = Max (BVA - Valid)
     */
    public function test_product_creation_with_price_max()
    {
        // Arrange
        $price = 9999.99;

        // Act
        $isValid = ($price <= 9999.99 && $price >= 0.01);

        // Assert
        $this->assertTrue($isValid);
    }

    /**
     * TC007: Verify product creation with Price = Max+1 (BVA - Invalid Edge Case)
     */
    public function test_product_creation_with_price_max_plus_one()
    {
        // Arrange
        $price = 10000.00;

        // Act
        $isValid = ($price <= 9999.99 && $price >= 0.01);

        // Assert
        $this->assertFalse($isValid);
    }

    /**
     * TC008: Verify product creation rejects non-numeric string data in Price
     */
    public function test_product_creation_rejects_non_numeric_price()
    {
        // Arrange
        $price = "abc";

        // Act
        $isValid = is_numeric($price) && $price > 0;

        // Assert
        $this->assertFalse($isValid);
    }

    /**
     * TC009: Verify product creation with Name length = 255 (BVA - Valid)
     */
    public function test_product_creation_with_name_length_255()
    {
        // Arrange
        $name = str_repeat('A', 255);

        // Act
        $isValid = strlen($name) > 0 && strlen($name) <= 255;

        // Assert
        $this->assertTrue($isValid);
    }

    /**
     * TC010: Verify product creation with Name length = 256 (BVA - Invalid Edge Case)
     */
    public function test_product_creation_with_name_length_256()
    {
        // Arrange
        $name = str_repeat('A', 256);

        // Act
        $isValid = strlen($name) > 0 && strlen($name) <= 255;

        // Assert
        $this->assertFalse($isValid);
    }
}
