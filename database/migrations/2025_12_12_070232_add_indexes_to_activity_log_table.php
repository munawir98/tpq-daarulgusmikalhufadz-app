<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('activity_log', function (Blueprint $table) {
            $table->index('created_at', 'activity_log_created_at_index');
            $table->index('event', 'activity_log_event_index');
            $table->index('causer_id', 'activity_log_causer_id_index');
            $table->index('subject_type', 'activity_log_subject_type_index');
        });
    }

    public function down()
    {
        Schema::table('activity_log', function (Blueprint $table) {
            $table->dropIndex('activity_log_created_at_index');
            $table->dropIndex('activity_log_event_index');
            $table->dropIndex('activity_log_causer_id_index');
            $table->dropIndex('activity_log_subject_type_index');
        });
    }
};
