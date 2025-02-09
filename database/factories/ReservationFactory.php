<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use App\Models\Reservation;
use App\Models\User;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = User::where('role_id', 3)->pluck('id')->toArray();
        $consultantId = User::where('role_id', 2)->pluck('id')->toArray();

        $reservationDate = $this->faker->dateTimeBetween('now','+30 days')->format('Y-m-d');
        $startTime = $this->faker->numberBetween(9, 15);
        $endTime = $startTime + 1;

        return [
            'user_id' => $this->faker->randomElement($userId),
            'consultant_id' => $this->faker->randomElement($consultantId),
            'reservation_date' => $reservationDate,
            'start_time' => sprintf('%02d:00', $startTime),
            'end_time' => sprintf('%02d:00', $endTime),
            'reservation_status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed']),
            'total_amount' => 500000
        ];
    }
}
