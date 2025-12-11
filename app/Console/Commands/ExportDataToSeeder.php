<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ExportDataToSeeder extends Command
{
    protected $signature = 'db:export-seeders {--tables=* : Specific tables to export}';
    protected $description = 'Export database data to seeder files';

    public function handle()
    {
        $this->info('Starting data export to seeders...');

        // Get tables to export
        $tables = $this->option('tables');
        
        if (empty($tables)) {
            // Get all tables except migrations
            $tables = $this->getAllTables();
        }

        foreach ($tables as $table) {
            $this->exportTable($table);
        }

        $this->info("\nAll seeders generated successfully!");
        $this->info("Don't forget to register them in DatabaseSeeder.php");
    }

    protected function getAllTables()
    {
        $tables = DB::select('SHOW TABLES');
        $dbName = DB::getDatabaseName();
        $tableKey = "Tables_in_{$dbName}";

        $allTables = [];
        foreach ($tables as $table) {
            $tableName = $table->$tableKey;
            
            // Skip migrations and other system tables
            if (!in_array($tableName, ['migrations', 'password_reset_tokens', 'sessions', 'cache', 'cache_locks', 'jobs', 'job_batches', 'failed_jobs'])) {
                $allTables[] = $tableName;
            }
        }

        return $allTables;
    }

    protected function exportTable($table)
    {
        $this->info("Exporting table: {$table}");

        $data = DB::table($table)->get();

        if ($data->isEmpty()) {
            $this->warn("  - Table {$table} is empty, skipping...");
            return;
        }

        $className = Str::studly($table) . 'TableSeeder';
        $seederPath = database_path("seeders/{$className}.php");

        $seederContent = $this->generateSeederContent($className, $table, $data);

        File::put($seederPath, $seederContent);

        $this->info("  ✓ Generated: {$className}.php ({$data->count()} records)");
    }

    protected function generateSeederContent($className, $table, $data)
    {
        $records = [];

        foreach ($data as $record) {
            $recordArray = (array) $record;
            $records[] = $this->formatRecord($recordArray);
        }

        $recordsString = implode(",\n            ", $records);

        return <<<PHP
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class {$className} extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('{$table}')->insert([
            {$recordsString}
        ]);
    }
}

PHP;
    }

    protected function formatRecord($record)
    {
        $formatted = [];

        foreach ($record as $key => $value) {
            if (is_null($value)) {
                $formatted[] = "'{$key}' => null";
            } elseif (is_bool($value)) {
                $formatted[] = "'{$key}' => " . ($value ? 'true' : 'false');
            } elseif (is_numeric($value) && !$this->isDateColumn($key)) {
                $formatted[] = "'{$key}' => {$value}";
            } else {
                // Escape single quotes
                $escapedValue = str_replace("'", "\\'", $value);
                $formatted[] = "'{$key}' => '{$escapedValue}'";
            }
        }

        return "[\n                " . implode(",\n                ", $formatted) . "\n            ]";
    }

    protected function isDateColumn($column)
    {
        $dateColumns = ['created_at', 'updated_at', 'deleted_at', 'email_verified_at'];
        return in_array($column, $dateColumns) || 
               Str::endsWith($column, '_at') || 
               Str::endsWith($column, '_date');
    }
}
