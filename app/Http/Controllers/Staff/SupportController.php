<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportResponse;

class SupportController extends Controller
{
    /**
     * Show list of support tickets
     */
    public function index()
    {
        $status = request('status');
        $priority = request('priority');

        $query = SupportTicket::with('user', 'responses');

        if ($status) {
            $query->where('status', $status);
        }

        if ($priority) {
            $query->where('priority', $priority);
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('staff.support.index', compact('tickets'));
    }

    /**
     * Show ticket detail
     */
    public function show(SupportTicket $ticket)
    {
        $ticket->load('user', 'responses.user');
        return view('staff.support.show', compact('ticket'));
    }

    /**
     * Add response to ticket
     */
    public function addResponse(SupportTicket $ticket)
    {
        $validated = request()->validate([
            'response_text' => 'required|string|min:10',
        ]);

        SupportResponse::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'response_text' => $validated['response_text'],
            'is_admin_response' => true, // Staff responses are treated as admin responses
        ]);

        // Update ticket status if it's open
        if ($ticket->status === 'open') {
            $ticket->update(['status' => 'in_progress']);
        }

        return back()->with('success', 'Response added successfully');
    }

    /**
     * Update ticket status
     */
    public function updateStatus(SupportTicket $ticket)
    {
        $status = request('status');
        
        if (!in_array($status, ['open', 'in_progress', 'resolved', 'closed'])) {
            return back()->withErrors('Invalid status');
        }

        $ticket->update(['status' => $status]);

        return back()->with('success', 'Ticket status updated successfully');
    }

    /**
     * Update ticket priority
     */
    public function updatePriority(SupportTicket $ticket)
    {
        $priority = request('priority');
        
        if (!in_array($priority, ['low', 'medium', 'high', 'urgent'])) {
            return back()->withErrors('Invalid priority');
        }

        $ticket->update(['priority' => $priority]);

        return back()->with('success', 'Ticket priority updated successfully');
    }
}
