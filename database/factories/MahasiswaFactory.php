<?php


namespace Database\Factories;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MahasiswaFactory extends Factory
{
    protected $model = Mahasiswa::class;

    public function definition(): array
    {
        return [
            'nim' => $this->faker->unique()->numerify('########'),
            'nama_mahasiswa' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Create mahasiswa with specific NIM
     */
    public function withNim(string $nim): static
    {
        return $this->state(fn (array $attributes) => [
            'nim' => $nim,
        ]);
    }

    /**
     * Create mahasiswa with specific email
     */
    public function withEmail(string $email): static
    {
        return $this->state(fn (array $attributes) => [
            'email' => $email,
        ]);
    }
}