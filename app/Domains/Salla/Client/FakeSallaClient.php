<?php

namespace App\Domains\Salla\Client;

class FakeSallaClient implements SallaClientInterface
{
    private array $products;
    private array $categories;

    public function __construct()
    {
        $this->products = [
            [
                "id" => 1,
                "salla_id" => 1,
                "slug" => "iphone-15-pro",
                "name" => "iPhone 15 Pro",
                "description" => "Latest Apple flagship phone",
                "price" => 4999.00,
                "currency" => "SAR",
                "stock" => 25,
                "category_slug" => "electronics",
                "image_url" => "https://placehold.co/600x400?text=iPhone+15",
            ],
            [
                "id" => 2,
                "salla_id" => 2,
                "slug" => "samsung-s24-ultra",
                "name" => "Samsung Galaxy S24 Ultra",
                "description" => "Premium Android phone",
                "price" => 4599.00,
                "currency" => "SAR",
                "stock" => 15,
                "category_slug" => "electronics",
                "image_url" => "https://placehold.co/600x400?text=Samsung+S24",
            ],
            [
                "id" => 3,
                "salla_id" => 3,
                "slug" => "macbook-pro-m3",
                "name" => "MacBook Pro M3",
                "description" => "Professional laptop",
                "price" => 8999.00,
                "currency" => "SAR",
                "stock" => 8,
                "category_slug" => "computers",
                "image_url" => "https://placehold.co/600x400?text=MacBook+Pro",
            ],
            [
                "id" => 4,
                "salla_id" => 4,
                "slug" => "sony-wh1000xm5",
                "name" => "Sony WH-1000XM5",
                "description" => "Noise-cancelling headphones",
                "price" => 1499.00,
                "currency" => "SAR",
                "stock" => 30,
                "category_slug" => "electronics",
                "image_url" => "https://placehold.co/600x400?text=Sony+XM5",
            ],
            [
                "id" => 5,
                "salla_id" => 5,
                "slug" => "nike-air-max-90",
                "name" => "Nike Air Max 90",
                "description" => "Classic sneakers",
                "price" => 599.00,
                "currency" => "SAR",
                "stock" => 50,
                "category_slug" => "fashion",
                "image_url" => "https://placehold.co/600x400?text=Nike+AirMax",
            ],
        ];

        $this->categories = [
            ["id" => 1, "salla_id" => 1, "name" => "Electronics", "slug" => "electronics", "parent_id" => null],
            ["id" => 2, "salla_id" => 2, "name" => "Computers", "slug" => "computers", "parent_id" => 1],
            ["id" => 3, "salla_id" => 3, "name" => "Fashion", "slug" => "fashion", "parent_id" => null],
        ];
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function getProduct(int $sallaId): ?array
    {
        foreach ($this->products as $product) {
            if ($product["salla_id"] === $sallaId) {
                return $product;
            }
        }
        return null;
    }

    public function getProductsByCategory(string $categorySlug): array
    {
        return array_values(array_filter($this->products, fn($p) => $p["category_slug"] === $categorySlug));
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function checkStock(int $sallaProductId, int $quantity): array
    {
        $product = $this->getProduct($sallaProductId);
        if (!$product) {
            return ["available" => false, "current_stock" => 0, "message" => "Product not found"];
        }
        $available = $product["stock"] >= $quantity;
        return [
            "available" => $available,
            "current_stock" => $product["stock"],
            "requested" => $quantity,
            "message" => $available ? "In stock" : "Insufficient stock",
        ];
    }

    public function createOrder(array $orderData): array
    {
        return [
            "salla_order_id" => "SALLA-" + str_pad((string) random_int(100000, 999999), 6, "0", STR_PAD_LEFT),
            "status" => "pending",
            "payment_url" => "https://salla.example/pay/" + uniqid(),
            "created_at" => date("c"),
        ];
    }
}
