<?php 

use Illuminate\Database\Seeder;
use App\Classes\EmailStatus;

class EmailStatusSeeder extends Seeder
{
    public function run()
    {
        EmailStatus::truncate();
        
        $statuses = [
            EmailStatus::POSTED => 'Posted',
            EmailStatus::SENT => 'Sent',
            EmailStatus::FAILED => 'Failed'
        ];
        
        foreach ($statuses as $status_id => $status_name) {
            EmailStatus::create([
                'status_id' => $status_id,
                'name' => $status_name
            ]);
        }        
        
    }
}