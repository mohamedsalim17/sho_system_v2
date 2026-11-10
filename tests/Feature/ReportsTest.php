<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ReportsTest extends TestCase
{
    public function test_report_pages_filters_and_local_exports_work_without_external_packages(): void
    {
        $this->withoutMiddleware();
        $this->createReportTables();

        DB::table('customers')->insert([
            'id' => 1,
            'name' => 'Test Customer',
            'phone' => '5551000',
            'national_id' => 'N-100',
            'gender' => 'ذكر',
            'city' => 'Test City',
            'state' => 'Test State',
            'job' => 'Customer',
            'date_of_death' => '2021-08-12',
            'place_of_death' => 'Test Customer Hospital',
        ]);
        DB::table('invoices')->insert([
            'id' => 1,
            'customer_id' => 1,
            'invoice_date' => '2026-11-01',
            'total_amount' => 25.50,
        ]);
        DB::table('employees')->insert([
            'id' => 1,
            'employee_no' => 'EMP-001',
            'name' => 'Test Employee',
            'death_date' => '2020-05-14',
            'death_place' => 'Test City Hospital',
            'department' => 'Sales',
            'hire_date' => '2026-01-10',
            'salary' => 500,
        ]);
        DB::table('employees')->insert([
            'id' => 2,
            'employee_no' => 'EMP-002',
            'name' => '=1+1',
        ]);
        DB::table('employee_relatives')->insert(['employee_id' => 1]);
        DB::table('products')->insert([
            'id' => 1,
            'name' => 'Test Product',
            'barcode' => 'P-001',
            'category' => 'General',
            'buy_price' => 10,
            'price' => 15,
            'quantity' => 2,
            'unit' => 'piece',
        ]);

        foreach ([
            '/reports',
            '/reports/sales',
            '/reports/customers',
            '/reports/employees',
            '/reports/products',
            '/reports/builder',
            '/reports/custom',
            '/reports/filter',
            '/reports/general',
        ] as $uri) {
            $this->get($uri)->assertOk();
        }

        $this->get('/reports/sales?customer_id=1&from=2026-11-01&to=2026-11-30')
            ->assertOk()
            ->assertSee('25.50');
        $this->get('/reports/customers?search=Test')
            ->assertOk()
            ->assertSee('Test Customer');
        $this->get('/reports/customers?search=Test+Customer+Hospital')
            ->assertOk()
            ->assertSee('2021-08-12')
            ->assertSee('Test Customer Hospital');
        $this->get('/reports/employees?search=Test')
            ->assertOk()
            ->assertSee('Test Employee');
        $this->get('/reports/products?search=Test')
            ->assertOk()
            ->assertSee('20.00');
        $this->get('/reports/builder?name=Test&columns%5B%5D=name')
            ->assertOk()
            ->assertSee('Test Employee');
        $this->get('/reports/builder?search=Test&columns%5B%5D=name')
            ->assertOk()
            ->assertSee('Test Employee')
            ->assertDontSee('=1+1');
        $builderResponse = $this->get('/reports/builder?columns%5B%5D=death_date&columns%5B%5D=death_place');
        $builderResponse->assertOk()
            ->assertSee('تاريخ الوفاة')
            ->assertSee('مكان الوفاة')
            ->assertSee('2020-05-14')
            ->assertSee('Test City Hospital')
            ->assertSee('value="death_date" checked', false)
            ->assertSee('value="death_place" checked', false);

        $this->get('/reports/builder?death_date=2020-05-14&death_place=Hospital')
            ->assertOk()
            ->assertSee('Test City Hospital');
        $customerDeathReport = $this->get('/reports/builder?source=customers&columns%5B%5D=name&columns%5B%5D=death_date&columns%5B%5D=death_place');
        $customerDeathReport->assertOk()
            ->assertSee('Test Customer')
            ->assertSee('2021-08-12')
            ->assertSee('Test Customer Hospital')
            ->assertSee('value="death_date" checked', false)
            ->assertSee('value="death_place" checked', false);
        $this->get('/reports/builder?source=customers&death_date=2021-08-12&death_place=Hospital&columns%5B%5D=name&columns%5B%5D=death_date&columns%5B%5D=death_place')
            ->assertOk()
            ->assertSee('Test Customer Hospital')
            ->assertDontSee('Test Employee');
        $customerCsv = $this->get('/reports/excel?source=customers&columns%5B%5D=death_date&columns%5B%5D=death_place')
            ->assertOk()
            ->streamedContent();
        $this->assertStringContainsString('2021-08-12', $customerCsv);
        $this->assertStringContainsString('Test Customer Hospital', $customerCsv);
        $this->get('/reports/pdf?source=customers&columns%5B%5D=death_date&columns%5B%5D=death_place')
            ->assertOk()
            ->assertSee('2021-08-12')
            ->assertSee('Test Customer Hospital');
        $this->get('/reports/general?search=Test&from_date=2026-01-01&to_date=2026-12-31')
            ->assertOk()
            ->assertSee('Test Employee')
            ->assertDontSee('=1+1');
        $this->get('/reports/filter?field=department&value=Sales')
            ->assertOk()
            ->assertSee('Test Employee')
            ->assertDontSee('=1+1');
        $fourFieldFilter = $this->get('/reports/filter?filters%5B0%5D%5Bfield%5D=name&filters%5B0%5D%5Bvalue%5D=Test+Employee&filters%5B1%5D%5Bfield%5D=department&filters%5B1%5D%5Bvalue%5D=Sales&filters%5B2%5D%5Bfield%5D=death_date&filters%5B2%5D%5Bvalue%5D=2020-05-14&filters%5B3%5D%5Bfield%5D=death_place&filters%5B3%5D%5Bvalue%5D=Hospital');
        $fourFieldFilter->assertOk()
            ->assertSee('Test Employee')
            ->assertSee('معيار 4')
            ->assertDontSee('=1+1');
        $singleFieldFilter = $this->get('/reports/filter?'.http_build_query([
            'filters' => [
                ['field' => '', 'value' => ''],
                ['field' => 'department', 'value' => 'Sales'],
                ['field' => 'death_date', 'value' => ''],
                ['field' => 'death_place', 'value' => ''],
            ],
        ]));
        $singleFieldFilter->assertOk()
            ->assertSee('Test Employee')
            ->assertDontSee('=1+1');
        $this->get('/reports/filter?filters%5B0%5D%5Bfield%5D=name&filters%5B0%5D%5Bvalue%5D=Test+Employee&filters%5B1%5D%5Bfield%5D=department&filters%5B1%5D%5Bvalue%5D=Sales&filters%5B2%5D%5Bfield%5D=death_date&filters%5B2%5D%5Bvalue%5D=2020-05-14&filters%5B3%5D%5Bfield%5D=death_place&filters%5B3%5D%5Bvalue%5D=Wrong+Place')
            ->assertOk()
            ->assertSee('لا توجد نتائج مطابقة.');
        $this->get('/reports/custom?customer_id=1&from=2026-11-01&to=2026-11-30')
            ->assertOk()
            ->assertSee('Test Customer')
            ->assertSee('25.50');

        $csvResponse = $this->get('/reports/excel?columns%5B%5D=name');
        $csvResponse->assertOk();
        $csv = $csvResponse->streamedContent();
        $this->assertStringContainsString('Test Employee', $csv);
        $this->assertStringContainsString("'=1+1", $csv);
        $deathCsvResponse = $this->get('/reports/excel?columns%5B%5D=death_date&columns%5B%5D=death_place');
        $deathCsvResponse->assertOk();
        $deathCsv = $deathCsvResponse->streamedContent();
        $this->assertStringContainsString('تاريخ الوفاة', $deathCsv);
        $this->assertStringContainsString('مكان الوفاة', $deathCsv);
        $this->assertStringContainsString('Test City Hospital', $deathCsv);
        $salesCsvResponse = $this->get('/reports/sales/export.csv?customer_id=1');
        $salesCsvResponse->assertOk();
        $salesCsv = $salesCsvResponse->streamedContent();
        $this->assertStringContainsString('Test Customer', $salesCsv);
        $this->assertStringContainsString('25.50', $salesCsv);
        $this->get('/reports/pdf?name=Test&columns%5B%5D=name')
            ->assertOk()
            ->assertSee('Test Employee');
    }

    private function createReportTables(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('national_id')->nullable();
            $table->string('gender')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('job')->nullable();
            $table->date('date_of_death')->nullable();
            $table->string('place_of_death')->nullable();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->date('invoice_date');
            $table->decimal('total_amount', 10, 2)->default(0);
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_no')->nullable();
            $table->string('national_id')->nullable();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->date('birth_date')->nullable();
            $table->date('death_date')->nullable();
            $table->string('death_place')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('job_title')->nullable();
            $table->string('department')->nullable();
            $table->decimal('salary', 10, 2)->nullable();
            $table->date('hire_date')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('street')->nullable();
        });

        Schema::create('employee_relatives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('barcode')->nullable();
            $table->string('category')->nullable();
            $table->decimal('buy_price', 10, 2)->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->string('unit')->nullable();
            $table->date('expiry_date')->nullable();
        });
    }
}
