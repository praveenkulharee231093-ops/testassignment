<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ExportUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Exporting users to CSV.");
        $users = User::all();
        $csvFileName = 'users_' . date('Ymd_His') . '.csv';
        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['ID', 'Name', 'Email', 'Role']);
        foreach ($users as $user) {
            fputcsv($handle, [$user->id, $user->name, $user->email, $user->role]);
        }
        fclose($handle);
        return response()->stream(
            function () use ($handle) {
                fclose($handle);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$csvFileName\"",
            ]
        );
    }
}
