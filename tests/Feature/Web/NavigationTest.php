<?php

use App\Models\Product;
use App\Models\User;

test('"Nosotros" page is accessible', function () {
    $response = $this->get('/nosotros');
    $response->assertStatus(200);
    $response->assertSee('Ludika');
    $response->assertSee('Nuestros 5 Creadores');
});

test('products can be filtered by category', function () {
    // Create products with different categories
    Product::factory()->create(['name' => 'Soap A', 'category' => 'Jabones']);
    Product::factory()->create(['name' => 'Mask B', 'category' => 'Mascarillas en polvo']);
    Product::factory()->create(['name' => 'Cream C', 'category' => 'Cremas faciales']);

    // Filter by 'Jabones'
    $response = $this->get('/?category=Jabones');
    $response->assertStatus(200);
    $response->assertSee('Soap A');
    $response->assertDontSee('Mask B');
    $response->assertDontSee('Cream C');

    // Filter by 'Mascarillas en polvo'
    $response = $this->get('/?category=Mascarillas en polvo');
    $response->assertStatus(200);
    $response->assertSee('Mask B');
    $response->assertDontSee('Soap A');
    $response->assertDontSee('Cream C');
});

test('navbar contains the new links', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertSee('Nosotros');
    $response->assertSee('Jabones');
    $response->assertSee('Mascarillas en polvo');
    $response->assertSee('Bálsamos');
    $response->assertSee('Cremas faciales');
    $response->assertSee('Cremas corporales');
});
