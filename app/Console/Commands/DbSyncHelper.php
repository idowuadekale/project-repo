<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;

trait DbSyncHelper
{
    protected function dumpDatabase(string $connection, string $mode = 'full'): string
    {
        $db = DB::connection($connection);
        $file = storage_path('app/db_sync_dump.sql');
        $sql = "SET FOREIGN_KEY_CHECKS=0;\n\n";

        $tablesRaw = $db->select('SHOW TABLES');

        foreach ($tablesRaw as $tableObj) {
            $table = array_values((array) $tableObj)[0];
            $rows = $db->table($table)->get();

            if ($mode === 'full') {
                $createRaw = $db->select("SHOW CREATE TABLE `{$table}`");
                $createSql = array_values((array) $createRaw[0])[1];
                $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
                $sql .= $createSql.";\n\n";

                if ($rows->isEmpty()) {
                    continue;
                }

                $columns = implode('`, `', array_keys((array) $rows->first()));
                $sql .= "INSERT INTO `{$table}` (`{$columns}`) VALUES\n";

                $values = $rows->map(function ($row) {
                    $escaped = array_map(fn ($val) => $val === null ? 'NULL' : "'".addslashes((string) $val)."'", (array) $row);

                    return '('.implode(', ', $escaped).')';
                })->implode(",\n");

                $sql .= $values.";\n\n";
            } elseif ($mode === 'merge') {
                if ($rows->isEmpty()) {
                    continue;
                }

                $columns = array_keys((array) $rows->first());
                $colList = implode('`, `', $columns);
                $updateCols = array_map(
                    fn ($col) => "`{$col}` = VALUES(`{$col}`)",
                    $columns
                );
                $updateSql = implode(', ', $updateCols);

                $sql .= "INSERT INTO `{$table}` (`{$colList}`) VALUES\n";

                $values = $rows->map(function ($row) {
                    $escaped = array_map(fn ($val) => $val === null ? 'NULL' : "'".addslashes((string) $val)."'", (array) $row);

                    return '('.implode(', ', $escaped).')';
                })->implode(",\n");

                $sql .= $values."\nON DUPLICATE KEY UPDATE {$updateSql};\n\n";
            }
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
        file_put_contents($file, $sql);

        return $file;
    }

    protected function importDatabase(string $connection, string $file): void
    {
        $sql = file_get_contents($file);
        DB::connection($connection)->unprepared($sql);
    }
}
