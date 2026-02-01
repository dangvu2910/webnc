<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\SupportResponse;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    /**
     * Show all support tickets for the logged-in user
     */
    public function index()
    {
        $tickets = SupportTicket::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('user.support.index', compact('tickets'));
    }

    /**
     * Show the form to create a new support ticket
     */
    public function create()
    {
        return view('user.support.create');
    }

    /**
     * Store a new support ticket
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'category' => 'nullable|string|max:100',
            'priority' => 'nullable|in:low,medium,high,urgent',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'open';
        $validated['priority'] = $validated['priority'] ?? 'medium';

        $ticket = SupportTicket::create($validated);

        return redirect()->route('support.show', $ticket->id)
            ->with('success', 'Tạo yêu cầu hỗ trợ thành công!');
    }

    /**
     * Show a single support ticket with responses
     */
    public function show(SupportTicket $ticket)
    {
        // Check if user owns this ticket or is admin
        if (auth()->id() !== $ticket->user_id && !auth()->user()->is_admin) {
            abort(403);
        }

        $responses = $ticket->responses()->orderBy('created_at', 'asc')->get();
        return view('user.support.show', compact('ticket', 'responses'));
    }

    /**
     * Add a response to a support ticket
     */
    public function addResponse(Request $request, SupportTicket $ticket)
    {
        // Check if user owns this ticket or is admin
        if (auth()->id() !== $ticket->user_id && !auth()->user()->is_admin) {
            abort(403);
        }

        $validated = $request->validate([
            'response_text' => 'required|string|min:5',
        ]);

        $response = new SupportResponse([
            'response_text' => $validated['response_text'],
            'user_id' => auth()->id(),
            'is_admin_response' => auth()->user()->is_admin,
        ]);

        $ticket->responses()->save($response);

        // If user responds, mark ticket as in_progress (if it was open)
        if (!auth()->user()->is_admin && $ticket->status === 'open') {
            $ticket->update(['status' => 'in_progress']);
        }

        return redirect()->route('support.show', $ticket->id)
            ->with('success', 'Thêm phản hồi thành công!');
    }

    /**
     * Close a support ticket
     */
    public function close(SupportTicket $ticket)
    {
        if (auth()->id() !== $ticket->user_id && !auth()->user()->is_admin) {
            abort(403);
        }

        $ticket->update(['status' => 'closed']);

        return redirect()->route('support.show', $ticket->id)
            ->with('success', 'Đóng yêu cầu hỗ trợ thành công!');
    }
}
