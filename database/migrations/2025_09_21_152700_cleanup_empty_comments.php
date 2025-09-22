<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Build dynamic COALESCE expressions based on which columns exist
        $nameParts = [];
        if (Schema::hasColumn('comments', 'name')) {
            $nameParts[] = "NULLIF(name, '')";
        }
        if (Schema::hasColumn('comments', 'nama')) {
            $nameParts[] = "NULLIF(nama, '')";
        }
        $nameExpr = empty($nameParts) ? 'NULL' : ('COALESCE(' . implode(', ', $nameParts) . ')');

        $bodyParts = [];
        if (Schema::hasColumn('comments', 'content')) {
            $bodyParts[] = "NULLIF(content, '')";
        }
        if (Schema::hasColumn('comments', 'komentar')) {
            $bodyParts[] = "NULLIF(komentar, '')";
        }
        if (Schema::hasColumn('comments', 'isi')) {
            $bodyParts[] = "NULLIF(isi, '')";
        }
        $bodyExpr = empty($bodyParts) ? 'NULL' : ('COALESCE(' . implode(', ', $bodyParts) . ')');

        $sql = "DELETE FROM comments WHERE $nameExpr IS NULL OR $bodyExpr IS NULL";
        DB::statement($sql);
    }

    public function down(): void
    {
        // irreversible cleanup
    }
};
