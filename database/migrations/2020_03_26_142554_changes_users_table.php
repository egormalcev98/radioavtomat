<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('user_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('name');
            $table->timestamps();
			$table->softDeletes(); 
        });
		
		Schema::create('structural_units', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('name');
            $table->timestamps();
			$table->softDeletes(); 
        });
		
        Schema::table('users', function (Blueprint $table) {
			$table->unsignedBigInteger('user_status_id')->default(1)->after('password');
			$table->unsignedBigInteger('structural_unit_id')->nullable()->after('user_status_id');
			$table->string('surname')->nullable()->after('id');
            $table->string('middle_name')->nullable()->after('name');
			$table->string('personal_phone_number')->nullable()->after('email');
			$table->string('work_phone_number')->nullable()->after('personal_phone_number');
			$table->string('additional')->nullable()->after('work_phone_number')->comment('Добавочный');
			$table->timestamp('birthday_at')->nullable()->after('additional')->comment('День рождения');
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_statuses');
		
        Schema::dropIfExists('structural_units');
		
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumns([
				'user_status_id', 
				'structural_unit_id', 
				'deleted_at', 
				'surname', 
				'middle_name',
				'personal_phone_number',
				'work_phone_number',
				'additional',
				'birthday_at',
			]);
        });
    }
}
