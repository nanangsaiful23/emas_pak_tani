<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_halaman_login_admin_dapat_dibuka(): void
    {
        $this->get('/admin/login')->assertOk();
    }

    public function test_halaman_login_kasir_dapat_dibuka(): void
    {
        $this->get('/cashier/login')->assertOk();
    }

    public function test_halaman_admin_butuh_login(): void
    {
        $this->get('/admin')->assertRedirect();
    }
}
