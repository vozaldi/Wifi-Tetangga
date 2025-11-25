<?php

namespace App\Observers;

use App\Models\Payment;

class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        $this->updateInvoiceStatus($payment->invoice);
    }

    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment): void
    {
        $this->updateInvoiceStatus($payment->invoice);
    }

    /**
     * Handle the Payment "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        $this->updateInvoiceStatus($payment->invoice);
    }

    /**
     * Handle the Payment "restored" event.
     */
    public function restored(Payment $payment): void
    {
        $this->updateInvoiceStatus($payment->invoice);
    }

    /**
     * Handle the Payment "force deleted" event.
     */
    public function forceDeleted(Payment $payment): void
    {
        $this->updateInvoiceStatus($payment->invoice);
    }

    protected function updateInvoiceStatus(\App\Models\Invoice $invoice)
    {
        $totalPaid = $invoice->payments()->sum('amount');
        $totalAmount = $invoice->total_amount;

        if ($totalPaid >= $totalAmount) {
            $invoice->status = 'paid';
            $invoice->paid_date = now();
        } elseif ($totalPaid > 0) {
            $invoice->status = 'partial';
            $invoice->paid_date = null;
        } else {
            $invoice->status = 'unpaid';
            $invoice->paid_date = null;
        }

        $invoice->save();
    }
}
