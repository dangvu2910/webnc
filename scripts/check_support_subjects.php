<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\SupportTicket;

echo "Checking Support Ticket Subjects...\n\n";

$tickets = SupportTicket::all(['id', 'subject']);

foreach ($tickets as $ticket) {
    $hasSpaces = strpos($ticket->subject, ' ') !== false;
    $status = $hasSpaces ? '✓ OK' : '✗ NO SPACES';
    
    echo "ID: {$ticket->id} | {$status} | Subject: [{$ticket->subject}]\n";
}

echo "\n--- Done ---\n";
