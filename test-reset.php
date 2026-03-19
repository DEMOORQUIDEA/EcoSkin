<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Password;

$email = 'xdchuy04@gmail.com'; // Use the email from .env as a test
$user = User::where('email', $email)->first();

if (!$user) {
    echo "User not found with email $email\n";
    exit;
}

try {
    $status = Password::broker()->sendResetLink(['email' => $email]);
    echo "Status: " . $status . "\n";
    if ($status == Password::RESET_LINK_SENT) {
        echo "Reset link sent successfully via Password broker\n";
    } else {
        echo "Failed to send reset link via Password broker\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
