<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class InputScreensAndPermissionsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createTables();
    }

    public function test_hr_can_create_and_edit_customer_employee_and_product_records(): void
    {
        $this->actingAs($this->user('hr'));

        $this->get('/employees/create')->assertOk()->assertSee('death_date');
        $this->post('/employees', [
            'name' => 'Test Employee',
            'national_id' => 'EMP-NID-1',
            'phone' => '555-1000',
            'birth_date' => '1990-02-01',
            'death_date' => '2020-03-04',
            'death_place' => 'Local Hospital',
            'marital_status' => 'married',
            'job_title' => 'Accountant',
            'department' => 'Finance',
            'salary' => '4500.50',
            'hire_date' => '2020-01-01',
            'state' => 'State',
            'city' => 'City',
            'neighborhood' => 'District',
            'street' => 'Main Road',
        ])->assertRedirect('/employees');

        $this->assertDatabaseHas('employees', [
            'name' => 'Test Employee',
            'job_title' => 'Accountant',
            'death_place' => 'Local Hospital',
        ]);
        $employee = DB::table('employees')->where('name', 'Test Employee')->first();
        $this->get("/employees/{$employee->id}/edit")->assertOk()->assertSee('job_title');

        $this->get('/customers/create')->assertOk()->assertSee('place_of_death');
        $this->post('/customers', [
            'name' => 'Test Customer',
            'phone' => '555-2000',
            'national_id' => 'CUS-NID-1',
            'gender' => 'انثى',
            'birth_date' => '1992-03-01',
            'education_level' => 'جامعي',
            'job' => 'Teacher',
            'state' => 'State',
            'city' => 'City',
            'address' => 'Local address',
            'date_of_death' => '2021-01-10',
            'place_of_death' => 'Local Clinic',
        ])->assertRedirect('/customers');
        $this->assertDatabaseHas('customers', [
            'name' => 'Test Customer',
            'gender' => 'انثى',
            'place_of_death' => 'Local Clinic',
        ]);

        $this->get('/products/create')->assertOk()->assertSee('purchase_price');
        $this->post('/products', [
            'name' => 'Test Product',
            'category' => 'Office',
            'unit' => 'قطعة',
            'purchase_price' => '10.50',
            'price' => '15.00',
            'quantity' => 12,
            'barcode' => 'BAR-100',
            'supplier' => 'Local Supplier',
            'expiry_date' => '2028-01-01',
        ])->assertRedirect('/products');
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'buy_price' => '10.50',
            'quantity' => 12,
            'supplier' => 'Local Supplier',
        ]);
        $product = DB::table('products')->where('name', 'Test Product')->first();
        $this->get("/products/{$product->id}/edit")->assertOk()->assertSee('Local Supplier');
    }

    public function test_viewer_is_read_only_and_system_administration_is_admin_only(): void
    {
        $viewer = $this->user('viewer');
        $this->actingAs($viewer);

        $this->get('/products')->assertOk();
        $this->get('/products/create')->assertForbidden();
        $this->post('/products', [])->assertForbidden();
        $employeeId = DB::table('employees')->insertGetId([
            'employee_no' => 'EMP-VIEWER',
            'name' => 'Viewer Employee',
        ]);
        $this->get("/employees/{$employeeId}/relatives")->assertOk();
        $this->post("/employees/{$employeeId}/relatives", [])->assertForbidden();
        $this->get('/employees/import')->assertForbidden();
        $this->get('/system-settings')->assertForbidden();
        $this->get('/users')->assertForbidden();

        $this->actingAs($this->user('hr'));
        $this->get('/system-settings')->assertForbidden();

        $this->actingAs($this->user('admin'));
        $this->get('/system-settings')->assertOk();
        $this->get('/users')->assertOk();
    }

    public function test_employee_relatives_can_be_managed_with_death_and_bank_fields(): void
    {
        $this->actingAs($this->user('hr'));
        $employeeId = DB::table('employees')->insertGetId([
            'employee_no' => 'EMP-RELATIVE',
            'name' => 'Relative Employee',
        ]);

        $this->post("/employees/{$employeeId}/relatives", [
            'name' => 'Relative Person',
            'relation' => 'ابنة',
            'national_id' => 'REL-NID-1',
            'birth_date' => '2000-01-02',
            'death_date' => '2020-03-04',
            'death_place' => 'Local Hospital',
            'phone' => '5553000',
            'gender' => 'female',
            'is_dependent' => '1',
            'bank_account_no' => '123456',
            'bank_account_name' => 'Relative Person',
            'bank_name' => 'Local Bank',
        ])->assertRedirect("/employees/{$employeeId}/relatives");

        $relativeId = (int) DB::table('employee_relatives')->value('id');
        $this->assertDatabaseHas('employee_relatives', [
            'id' => $relativeId,
            'employee_id' => $employeeId,
            'name' => 'Relative Person',
            'death_place' => 'Local Hospital',
            'bank_account_no' => '123456',
            'is_dependent' => 1,
        ]);

        $this->get("/employees/{$employeeId}/relatives")
            ->assertOk()
            ->assertSee('Local Hospital')
            ->assertSee('Local Bank');
        $this->get("/employees/{$employeeId}/relatives/{$relativeId}/edit")
            ->assertOk()
            ->assertSee('relative-death-date');

        $this->put("/employees/{$employeeId}/relatives/{$relativeId}", [
            'name' => 'Updated Relative',
            'relation' => 'ابنة',
        ])->assertRedirect("/employees/{$employeeId}/relatives");
        $this->assertDatabaseHas('employee_relatives', [
            'id' => $relativeId,
            'name' => 'Updated Relative',
            'is_dependent' => 0,
        ]);

        $this->delete("/employees/{$employeeId}/relatives/{$relativeId}")
            ->assertRedirect("/employees/{$employeeId}/relatives");
        $this->assertDatabaseMissing('employee_relatives', ['id' => $relativeId]);
    }

    public function test_employee_import_appends_valid_rows_and_rolls_back_invalid_files(): void
    {
        $this->actingAs($this->user('hr'));
        DB::table('employees')->insert([
            'employee_no' => 'EMP-EXISTING',
            'name' => 'Existing Employee',
        ]);

        $csv = implode("\n", [
            'employee_no,unused,name,birth_date,national_id,job_title,death_date,death_place,department,city,unused,phone',
            'EMP-IMPORTED,,Imported Employee,1991-04-03,NID-IMPORTED,Clerk,2020-03-04,Local Hospital,HR,City,,5551000',
        ]);

        $this->post('/employees/import', [
            'file' => UploadedFile::fake()->createWithContent('employees.csv', $csv),
        ])->assertRedirect('/employees');

        $this->assertDatabaseHas('employees', ['employee_no' => 'EMP-EXISTING', 'name' => 'Existing Employee']);
        $this->assertDatabaseHas('employees', [
            'employee_no' => 'EMP-IMPORTED',
            'name' => 'Imported Employee',
            'death_place' => 'Local Hospital',
        ]);
        $this->assertSame(
            '2020-03-04',
            \Illuminate\Support\Carbon::parse(DB::table('employees')->where('employee_no', 'EMP-IMPORTED')->value('death_date'))->toDateString()
        );

        $invalidCsv = implode("\n", [
            'employee_no,unused,name,birth_date,national_id,job_title,death_date,death_place,department,city,unused,phone',
            'EMP-ROLLBACK,,Temporary Employee,,,,,,,,,',
            'EMP-EXISTING,,Duplicate Employee,,,,,,,,,',
        ]);

        $this->from('/employees/import')->post('/employees/import', [
            'file' => UploadedFile::fake()->createWithContent('invalid-employees.csv', $invalidCsv),
        ])->assertRedirect('/employees/import')
            ->assertSessionHasErrors('file');

        $this->assertDatabaseMissing('employees', ['employee_no' => 'EMP-ROLLBACK']);
        $this->assertDatabaseCount('employees', 2);
    }

    public function test_dashboard_displays_invoice_totals_and_hides_management_actions_from_viewers(): void
    {
        $this->actingAs($this->user('viewer'));
        $customerId = DB::table('customers')->insertGetId(['name' => 'Dashboard Customer']);
        DB::table('invoices')->insert([
            'customer_id' => $customerId,
            'invoice_date' => now()->toDateString(),
            'total_amount' => 12.50,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('12.50')
            ->assertSee('Dashboard Customer')
            ->assertDontSee('إدارة المستخدمين')
            ->assertDontSee('إضافة عميل')
            ->assertDontSee('إضافة فاتورة');
    }

    public function test_invoice_creation_and_editing_keep_totals_and_stock_consistent(): void
    {
        $this->actingAs($this->user('hr'));
        $customerId = DB::table('customers')->insertGetId(['name' => 'Invoice Customer']);
        $productId = DB::table('products')->insertGetId([
            'name' => 'Invoice Product',
            'price' => 12.50,
            'buy_price' => 7.00,
            'quantity' => 10,
            'unit' => 'قطعة',
        ]);

        $this->get('/invoices/create')->assertOk()->assertSee('products[0][product_id]');
        $this->post('/invoices', [
            'customer_id' => $customerId,
            'invoice_date' => now()->toDateString(),
            'products' => [['product_id' => $productId, 'quantity' => 3]],
        ])->assertRedirect();

        $this->assertDatabaseHas('invoices', ['customer_id' => $customerId, 'total_amount' => '37.50']);
        $this->assertDatabaseHas('invoice_items', [
            'product_id' => $productId,
            'quantity' => 3,
            'price' => '12.50',
            'subtotal' => '37.50',
        ]);
        $this->assertDatabaseHas('products', ['id' => $productId, 'quantity' => 7]);
        $invoiceId = (int) DB::table('invoices')->value('id');

        $this->put("/invoices/{$invoiceId}", [
            'customer_id' => $customerId,
            'invoice_date' => now()->toDateString(),
            'products' => [['product_id' => $productId, 'quantity' => 5]],
        ])->assertRedirect("/invoices/{$invoiceId}");
        $this->assertDatabaseHas('invoices', ['id' => $invoiceId, 'total_amount' => '62.50']);
        $this->assertDatabaseHas('products', ['id' => $productId, 'quantity' => 5]);

        $this->delete("/invoices/{$invoiceId}")->assertRedirect('/invoices');
        $this->assertDatabaseMissing('invoices', ['id' => $invoiceId]);
        $this->assertDatabaseHas('products', ['id' => $productId, 'quantity' => 10]);
    }

    private function user(string $role): User
    {
        return User::create([
            'name' => ucfirst($role).' User',
            'email' => $role.'@example.test',
            'password' => bcrypt('local-password'),
            'role' => $role,
        ]);
    }

    private function createTables(): void
    {
        foreach (['invoice_items', 'invoices', 'products', 'customers', 'employee_relatives', 'employees', 'users', 'companies', 'login_logs'] as $table) {
            Schema::dropIfExists($table);
        }

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('role')->default('hr');
            $table->string('password');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('remember_token')->nullable();
            $table->timestamps();
        });
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_no')->unique();
            $table->string('national_id')->nullable()->unique();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->date('birth_date')->nullable();
            $table->date('death_date')->nullable();
            $table->string('death_place')->nullable();
            $table->enum('marital_status', ['single', 'married'])->default('single');
            $table->string('job_title')->nullable();
            $table->string('department')->nullable();
            $table->decimal('salary', 10, 2)->nullable();
            $table->date('hire_date')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('street')->nullable();
            $table->timestamps();
        });
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('national_id')->nullable()->unique();
            $table->string('gender')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('education_level')->nullable();
            $table->string('job')->nullable();
            $table->date('date_of_death')->nullable();
            $table->string('place_of_death')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });
        Schema::create('employee_relatives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('name');
            $table->string('relation');
            $table->string('national_id')->nullable();
            $table->date('birth_date')->nullable();
            $table->date('death_date')->nullable();
            $table->string('death_place')->nullable();
            $table->string('phone')->nullable();
            $table->string('gender')->nullable();
            $table->boolean('is_dependent')->default(false);
            $table->string('bank_account_no')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->timestamps();
        });
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('buy_price', 10, 2)->nullable();
            $table->integer('quantity');
            $table->string('unit')->default('قطعة');
            $table->string('barcode')->nullable()->unique();
            $table->string('supplier')->nullable();
            $table->date('expiry_date')->nullable();
            $table->timestamps();
        });
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->date('invoice_date');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('address')->nullable();
            $table->string('logo')->nullable();
            $table->string('tax_number')->nullable();
            $table->timestamps();
        });
        Schema::create('login_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->timestamp('login_at')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }
}
