<?php

namespace App\Http\Controllers\Admin\Distribution;

use App\Http\Controllers\Controller;
use App\Models\DistributionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistributionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Access denied. Admin privileges required.');
            }
            return $next($request);
        });
    }

    /**
     * Display the specified distribution request.
     */
    public function show(DistributionRequest $distributionRequest)
    {
        // Ensure the user has paid for distribution
        if (!$distributionRequest->user->distribution_paid) {
            abort(404, 'Distribution request not found.');
        }

        $distributionRequest->load('user');
        return view('admin.distribution_dashboard.requests.show', compact('distributionRequest'));
    }

    /**
     * Approve the specified distribution request.
     */
    public function approve(Request $request, DistributionRequest $distributionRequest)
    {
        // Ensure the user has paid for distribution
        if (!$distributionRequest->user->distribution_paid) {
            abort(404, 'Distribution request not found.');
        }

        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $distributionRequest->update([
            'status' => 'approved',
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.distribution.requests.show', $distributionRequest)
            ->with('success', 'Distribution request has been approved.');
    }

    /**
     * Decline the specified distribution request.
     */
    public function decline(Request $request, DistributionRequest $distributionRequest)
    {
        // Ensure the user has paid for distribution
        if (!$distributionRequest->user->distribution_paid) {
            abort(404, 'Distribution request not found.');
        }

        $request->validate([
            'notes' => 'required|string|max:1000',
        ]);

        $distributionRequest->update([
            'status' => 'declined',
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.distribution.requests.show', $distributionRequest)
            ->with('success', 'Distribution request has been declined.');
    }

    /**
     * Update the status of a distribution request via AJAX.
     */
    public function updateStatus(Request $request, DistributionRequest $distributionRequest)
    {
        // Ensure the user has paid for distribution
        if (!$distributionRequest->user->distribution_paid) {
            abort(404, 'Distribution request not found.');
        }

        $request->validate([
            'status' => 'required|in:pending,approved,declined',
            'notes' => 'nullable|string|max:1000',
        ]);

        $distributionRequest->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status' => $distributionRequest->status,
            'status_color' => $distributionRequest->status_color,
        ]);
    }

    /**
     * Remove the specified distribution request.
     */
    public function destroy(DistributionRequest $distributionRequest)
    {
        // Ensure the user has paid for distribution
        if (!$distributionRequest->user->distribution_paid) {
            abort(404, 'Distribution request not found.');
        }

        // Delete associated files if they exist
        if ($distributionRequest->cover_image) {
            \Storage::disk('public')->delete($distributionRequest->cover_image);
        }
        
        if ($distributionRequest->audio_file) {
            \Storage::disk('public')->delete($distributionRequest->audio_file);
        }

        $distributionRequest->delete();

        return redirect()->route('admin.distribution.requests.index')
            ->with('success', 'Distribution request has been deleted.');
    }
}