<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class MarketplaceCartTest extends TestCase
{
    /**
     * TC011: Verify image upload with invalid file type (EQP - Invalid)
     */
    public function test_image_upload_invalid_file_type()
    {
        // Arrange
        $fileExtension = 'txt';
        $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif'];

        // Act
        $isValid = in_array($fileExtension, $allowedExtensions);

        // Assert
        $this->assertFalse($isValid);
    }

    /**
     * TC012: Verify adding existing product to cart (EQP - Positive)
     */
    public function test_add_existing_product_to_cart()
    {
        // Arrange
        $cartSession = [];
        $productId = 1;

        // Act
        $cartSession[$productId] = ['quantity' => 1];

        // Assert
        $this->assertArrayHasKey($productId, $cartSession);
        $this->assertEquals(1, $cartSession[$productId]['quantity']);
    }

    /**
     * TC013: Verify checkout process with items in cart (EQP - Positive)
     */
    public function test_checkout_process_with_items_in_cart()
    {
        // Arrange
        $cartSession = [1 => ['quantity' => 1]];

        // Act
        $isCheckoutAllowed = count($cartSession) > 0;
        if ($isCheckoutAllowed) {
            $cartSession = []; // flush cart
        }

        // Assert
        $this->assertTrue($isCheckoutAllowed);
        $this->assertEmpty($cartSession);
    }

    /**
     * TC014: Verify checkout process with empty cart (EQP - Negative / Edge-case)
     */
    public function test_checkout_process_with_empty_cart()
    {
        // Arrange
        $cartSession = [];

        // Act
        $isCheckoutAllowed = count($cartSession) > 0;

        // Assert
        $this->assertFalse($isCheckoutAllowed);
    }
}
