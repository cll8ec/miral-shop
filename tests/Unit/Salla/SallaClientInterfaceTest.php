<?php
namespace Tests\Unit\Salla;

use App\Domains\Salla\Client\SallaClientInterface;
use App\Domains\Salla\Client\FakeSallaClient;
use PHPUnit\Framework\TestCase;

class SallaClientInterfaceTest extends TestCase
{
    public function test_fake_client_can_be_instantiated(): void
    {
        $client = new FakeSallaClient();
        $this->assertInstanceOf(SallaClientInterface::class, $client);
    }

    public function test_get_products_returns_array(): void
    {
        $client = new FakeSallaClient();
        $products = $client->getProducts();
        $this->assertIsArray($products);
        $this->assertNotEmpty($products);
    }

    public function test_get_product_by_id_returns_product(): void
    {
        $client = new FakeSallaClient();
        $product = $client->getProduct(1);
        $this->assertNotNull($product);
 $this->assertArrayHasKey("name", $product);
    }

    public function test_get_product_returns_null_when_not_found(): void
    {
        $client = new FakeSallaClient();
        $product = $client->getProduct(999999);
        $this->assertNull($product);
    }

    public function test_get_categories_returns_array(): void
    {
        $client = new FakeSallaClient();
        $categories = $client->getCategories();
        $this->assertIsArray($categories);
        $this->assertNotEmpty($categories);
    }
}
