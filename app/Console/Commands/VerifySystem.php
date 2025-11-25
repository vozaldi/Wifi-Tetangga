<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class VerifySystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verify:system';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify core system logic';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting System Verification...');

        // 1. Setup Data
        $company = \App\Models\Company::create(['name' => 'Test Company', 'slug' => 'test-company']);
        $branch = \App\Models\Branch::create(['company_id' => $company->id, 'name' => 'Test Branch']);
        $client = \App\Models\Client::create(['company_id' => $company->id, 'branch_id' => $branch->id, 'name' => 'Test Client']);
        $product = \App\Models\Product::create(['company_id' => $company->id, 'name' => 'Test Product']);
        $variant = \App\Models\ProductVariant::create([
            'product_id' => $product->id,
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'name' => 'Variant A',
            'price' => 10000
        ]);
        $paymentMethod = \App\Models\PaymentMethod::firstOrCreate(['name' => 'Cash']);

        $this->info('✅ Setup Data Created');

        // 2. Test Invoice Logic
        $invoice = \App\Models\Invoice::create([
            'client_id' => $client->id,
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'invoice_number' => 'INV-TEST-001',
            'invoice_date' => now(),
            'due_date' => now()->addDays(7),
            'total_amount' => 0
        ]);

        $item = \App\Models\InvoiceItem::create([
            'invoice_id' => $invoice->id,
            'product_variant_id' => $variant->id,
            'description' => 'Item 1',
            'qty' => 2,
            'price' => 10000,
            'total' => 20000
        ]);

        $invoice->refresh();
        if ($invoice->total_amount == 20000) {
            $this->info('✅ Invoice Total Calculation (Observer): PASSED');
        } else {
            $this->error('❌ Invoice Total Calculation: FAILED (Expected 20000, got ' . $invoice->total_amount . ')');
        }

        // 3. Test Payment Logic
        \App\Models\Payment::create([
            'invoice_id' => $invoice->id,
            'payment_method_id' => $paymentMethod->id,
            'amount' => 10000,
            'payment_date' => now()
        ]);

        $invoice->refresh();
        if ($invoice->status === 'partial') {
            $this->info('✅ Payment Partial Status (Observer): PASSED');
        } else {
            $this->error('❌ Payment Partial Status: FAILED (Expected partial, got ' . $invoice->status . ')');
        }

        \App\Models\Payment::create([
            'invoice_id' => $invoice->id,
            'payment_method_id' => $paymentMethod->id,
            'amount' => 10000,
            'payment_date' => now()
        ]);

        $invoice->refresh();
        if ($invoice->status === 'paid') {
            $this->info('✅ Payment Paid Status (Observer): PASSED');
        } else {
            $this->error('❌ Payment Paid Status: FAILED (Expected paid, got ' . $invoice->status . ')');
        }

        // Cleanup
        $company->delete(); // Cascades should handle the rest
        $this->info('✅ Cleanup Completed');
    }
}
