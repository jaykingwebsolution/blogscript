<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ManualPayment;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;

class ManualPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $payments = ManualPayment::with(['user', 'plan', 'reviewer'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total' => ManualPayment::count(),
            'pending' => ManualPayment::pending()->count(),
            'approved' => ManualPayment::approved()->count(),
            'rejected' => ManualPayment::rejected()->count(),
        ];

        return view('admin.manual-payments.index', compact('payments', 'stats'));
    }

    public function show(ManualPayment $manualPayment)
    {
        $manualPayment->load(['user', 'plan', 'reviewer']);
        
        return view('admin.manual-payments.show', compact('manualPayment'));
    }

    public function approve(ManualPayment $manualPayment, Request $request)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        if (!$manualPayment->isPending()) {
            return back()->with('error', 'This payment has already been reviewed.');
        }

        $manualPayment->approve(auth()->id(), $request->admin_notes);

        return redirect()->route('admin.manual-payments.index')
            ->with('success', 'Payment approved successfully! User has been granted access.');
    }

    public function reject(ManualPayment $manualPayment, Request $request)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:1000'
        ]);

        if (!$manualPayment->isPending()) {
            return back()->with('error', 'This payment has already been reviewed.');
        }

        $manualPayment->reject(auth()->id(), $request->admin_notes);

        return redirect()->route('admin.manual-payments.index')
            ->with('success', 'Payment rejected successfully. User has been notified.');
    }

    public function bulkApprove(Request $request)
    {
        $request->validate([
            'payment_ids' => 'required|array',
            'payment_ids.*' => 'exists:manual_payments,id'
        ]);

        $approvedCount = 0;
        foreach ($request->payment_ids as $paymentId) {
            $payment = ManualPayment::find($paymentId);
            if ($payment && $payment->isPending()) {
                $payment->approve(auth()->id(), 'Bulk approved');
                $approvedCount++;
            }
        }

        return back()->with('success', "Approved {$approvedCount} payment(s) successfully.");
    }

    public function settings()
    {
        $bankDetails = [
            'account_name' => SiteSetting::get('bank_account_name', ''),
            'account_number' => SiteSetting::get('bank_account_number', ''),
            'bank_name' => SiteSetting::get('bank_name', ''),
            'instructions' => SiteSetting::get('payment_instructions', '')
        ];

        return view('admin.manual-payments.settings', compact('bankDetails'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'bank_account_name' => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:20',
            'bank_name' => 'required|string|max:255',
            'payment_instructions' => 'nullable|string|max:1000'
        ]);

        SiteSetting::set('bank_account_name', $request->bank_account_name);
        SiteSetting::set('bank_account_number', $request->bank_account_number);
        SiteSetting::set('bank_name', $request->bank_name);
        SiteSetting::set('payment_instructions', $request->payment_instructions);

        return back()->with('success', 'Bank details updated successfully.');
    }

    public function downloadProof(ManualPayment $manualPayment)
    {
        if (!$manualPayment->payment_proof || !Storage::disk('public')->exists($manualPayment->payment_proof)) {
            return back()->with('error', 'Payment proof not found.');
        }

        return Storage::disk('public')->download($manualPayment->payment_proof);
    }
}
