<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $chats = Chat::where('sender_id', $user->id)
                     ->orWhere('receiver_id', $user->id)
                     ->orderBy('created_at', 'desc')
                     ->get();
        return view('chats.index', compact('chats'));
    }

    public function create()
    {
        $user = Auth::user();
        $validContacts = $this->getValidContacts($user);
        return view('chats.create', compact('validContacts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000'
        ]);

        $user = Auth::user();
        $receiver = User::findOrFail($request->receiver_id);

        if (!$this->canChatWith($user, $receiver)) {
            return redirect()->back()->with('error', 'You are not allowed to chat with this user.');
        }

        Chat::create([
            'sender_id' => $user->id,
            'receiver_id' => $receiver->id,
            'message' => $request->message
        ]);

        return redirect()->route('chats.index')->with('success', 'Message sent successfully.');
    }

    public function show(Chat $chat)
    {
        $user = Auth::user();
        if ($chat->sender_id !== $user->id && $chat->receiver_id !== $user->id) {
            return redirect()->route('chats.index')->with('error', 'You do not have permission to view this chat.');
        }
        $chat->load('messages');
        return view('chats.show', compact('chat'));
    }

    public function edit(Chat $chat)
    {
        $user = auth()->user();
        if ($chat->sender_id !== $user->id) {
            return redirect()->route('chats.index')->with('error', 'You can only edit your own messages.');
        }
        return view('chats.edit', compact('chat'));
    }

    public function update(Request $request, Chat $chat)
    {
        $user = auth()->user();
        if ($chat->sender_id !== $user->id) {
            return redirect()->route('chats.index')->with('error', 'You can only update your own messages.');
        }
        $chat->update(['message' => $request->message]);
        return redirect()->route('chats.index')->with('success', 'Message updated successfully.');
    }

    public function destroy(Chat $chat)
    {
        $user = auth()->user();
        if ($chat->sender_id !== $user->id) {
            return redirect()->route('chats.index')->with('error', 'You can only delete your own messages.');
        }
        $chat->delete();
        return redirect()->route('chats.index')->with('success', 'Message deleted successfully.');
    }

    private function getValidContacts(User $user)
    {
        $query = User::where('id', '!=', $user->id);

        switch ($user->role) {
            case 'admin':
                // Admin can chat with everyone
                return $query->get();
            
            case 'supplier':
                // Supplier can chat with manufacturers and admin
                return $query->whereIn('role', ['manufacturer', 'admin'])->get();
            
            case 'manufacturer':
                // Manufacturer can chat with suppliers, retailers, and admin
                return $query->whereIn('role', ['supplier', 'retailer', 'admin'])->get();
            
            case 'retailer':
                // Retailer can chat with manufacturers, consumers, and admin
                return $query->whereIn('role', ['manufacturer', 'consumer', 'admin'])->get();
            
            case 'consumer':
                // Consumer can chat with retailers and admin
                return $query->whereIn('role', ['retailer', 'admin'])->get();
            
            case 'analyst':
                // Analyst can only chat with admin
                return $query->where('role', 'admin')->get();
            
            default:
                return collect();
        }
    }

    private function canChatWith(User $sender, User $receiver)
    {
        $validContacts = $this->getValidContacts($sender);
        return $validContacts->contains($receiver);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'order_id' => 'required|exists:orders,id',
            'message' => 'required|string'
        ]);

        $chat = Chat::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'order_id' => $request->order_id,
            'message' => $request->message,
            'timestamp' => now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Message sent successfully',
            'data' => $chat
        ]);
    }

    public function getOrderChats($orderId)
    {
        $chats = Chat::with(['sender', 'receiver'])
            ->where('order_id', $orderId)
            ->orderBy('timestamp', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $chats
        ]);
    }

    public function getUnreadMessages()
    {
        $unreadMessages = Chat::with(['sender', 'order'])
            ->where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $unreadMessages
        ]);
    }

    public function markAsRead($chatId)
    {
        $chat = Chat::findOrFail($chatId);
        
        if ($chat->receiver_id === Auth::id()) {
            $chat->update(['read_at' => now()]);
            return response()->json([
                'status' => 'success',
                'message' => 'Message marked as read'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized'
        ], 403);
    }

    public function storeMessage(Request $request, Chat $chat)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $chat->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return redirect()->route('chats.show', $chat);
    }
} 