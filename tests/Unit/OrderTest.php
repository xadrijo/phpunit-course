<?php

use App\Order;
use App\Product;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /** @test */
    public function an_order_consist_of_products()
    {

        $order = $this->createOrderWithProducts();

        $this->assertCount(2, $order->products());
    }

    /** @test */
    public function an_order_can_determine_the_total_cost_of_all_its_products()
    {
        $order = $this->createOrderWithProducts();

        $this->assertEquals(66, $order->total());
    }

    public function createOrderWithProducts()
    {
        $order = new Order();
        $product1 = new Product('Fallout 4', 59);
        $product2 = new Product('Pillowcase', 7);

        $order->add($product1);
        $order->add($product2);

        return $order;
    }
}