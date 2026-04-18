<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTripIdToBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('trip_id')->nullable()->after('bus_id')->constrained('trips')->onDelete('cascade');
        });

        // Populate existing bookings with their trip IDs
        $bookings = DB::table('bookings')->get();
        foreach ($bookings as $booking) {
            $trip = DB::table('trips')
                ->where('bus_id', $booking->bus_id)
                ->where('date', $booking->date)
                ->where('time', $booking->time)
                ->first();

            if ($trip) {
                DB::table('bookings')
                    ->where('id', $booking->id)
                    ->update(['trip_id' => $trip->id]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['trip_id']);
            $table->dropColumn('trip_id');
        });
    }
}
