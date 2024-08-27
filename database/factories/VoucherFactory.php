<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voucher>
 */
class VoucherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $triggerEvent = $this->faker->randomElement(['registration', 'purchase', 'referral', null]);

    // Tạo mô tả dựa trên loại sự kiện
        switch ($triggerEvent) {
            case 'registration':
                $description = 'Voucher dành cho người dùng mới khi đăng ký tài khoản.';
                break;
            case 'purchase':
                $description = 'Voucher giảm giá dành cho khách hàng thân thiết khi mua hàng.';
                break;
            case 'referral':
                $description = 'Voucher tặng cho người dùng khi giới thiệu bạn bè.';
                break;
            default:
                $description = 'Voucher khuyến mãi đặc biệt.';
                break;
        }

        $discountType = $this->faker->randomElement(['percent', 'amount']);

        $discountValue = $discountType === 'percent'
            ? $this->faker->numberBetween(5, 50) // Nếu là phần trăm, giá trị từ 5% đến 50%
            : $this->faker->numberBetween(10000, 1000000);

        return [
            'code' => $this->faker->unique()->bothify('VOUCHER-####'),
            'discount_type' => $discountType,
            'discount_value' => $discountValue,
            'discount_max' => $discountType === 'percent' 
                ? $this->faker->numberBetween(50000, 1000000) 
                : null, 
            'quantity' => $this->faker->numberBetween(10, 100),
            'user_count' => $this->faker->numberBetween(1, 50),
            'is_active' => $this->faker->boolean(80),
            'trigger_event' => $triggerEvent,
            'description' => $description,
            'day_start' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'day_end' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
        ];
    }
}
