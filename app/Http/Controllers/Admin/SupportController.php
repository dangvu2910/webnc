<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    /**
     * Show all support tickets (admin)
     */
    public function index(Request $request)
    {
        $query = SupportTicket::with('user');

        if ($request->get('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->get('priority')) {
            $query->where('priority', $request->get('priority'));
        }

        if ($request->get('search')) {
            $search = $request->get('search');
            $query->where('subject', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('email', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                });
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.support.index', compact('tickets'));
    }

    /**
     * Show a single support ticket (admin)
     */
    public function show(SupportTicket $ticket)
    {
        $responses = $ticket->responses()->orderBy('created_at', 'asc')->get();
        return view('admin.support.show', compact('ticket', 'responses'));
    }

    /**
     * Update ticket status
     */
    public function updateStatus(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);

        $ticket->update($validated);

        return redirect()->route('admin.support.show', $ticket->id)
            ->with('success', 'Cập nhật trạng thái thành công!');
    }

    /**
     * Update ticket priority
     */
    public function updatePriority(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        $ticket->update($validated);

        return redirect()->route('admin.support.show', $ticket->id)
            ->with('success', 'Cập nhật độ ưu tiên thành công!');
    }

    /**
     * Delete a support ticket (admin only)
     */
    public function destroy(SupportTicket $ticket)
    {
        $ticket->delete();

        return redirect()->route('admin.support.index')
            ->with('success', 'Xóa yêu cầu hỗ trợ thành công!');
    }
}
