<?php

namespace Tests\Feature;

use Tests\TestCase;

class MainLayoutTest extends TestCase
{
    public function test_main_layout_renders_a_valid_page_title_and_preserves_navigation(): void
    {
        $html = view('layouts.main', [
            'companyInfo' => (object) ['name' => 'Test Company'],
        ])->render();

        $this->assertStringContainsString('<title>Test Company</title>', $html);
        $this->assertMatchesRegularExpression('/<title>[^<]*<\/title>/u', $html);
        $this->assertStringContainsString('images/logo.png', $html);
        $this->assertStringContainsString('href="/employees"', $html);
        $this->assertStringContainsString('href="/customers"', $html);
        $this->assertStringContainsString('href="/products"', $html);
        $this->assertStringContainsString('href="/invoices"', $html);
        $this->assertStringContainsString('href="/reports"', $html);
    }
}
