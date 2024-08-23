<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Order $order): Response
    {
        return $user->id == $order->user_id || $user->role == 1
                ? Response::allow()
                : Response::deny('Bạn không có quyền xem đơn hàng của người khác');;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): Response
    {
        return $user->id == $order->user_id || $user->role == 1
                ? Response::allow()
                : Response::deny('Bạn không có quyền xem đơn hàng của người khác');;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Order $order): Response
    {
        return $user->id == $order->user_id
                    ? Response::allow()
                    : Response::deny('Bạn không có quyền sửa đơn hàng của người khác');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order): Response
    {
        return $user->id == $order->user_id || $user->role == 1
                ? Response::allow()
                : Response::deny('Bạn không có quyền xóa đơn hàng của người khác');;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Order $order): bool
    {
        return $user->id == $order->user_id || $user->role == 1;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Order $order): Response
    {
        return $user->id === $order->user_id || $user->role == 1
                ? Response::allow()
                : Response::deny("Bạn không có quyền xóa nếu không phải của mình hoặc không phải admin");
    }

    public function detail(User $user, Order $order): Response
    {
        return ($user->id == $order->user_id)
            ? Response::allow()
            : Response::deny('Bạn không có quyền xem đơn hàng của người khác');
    }

    public function printOrderApi(User $user, Order $order): bool
    {
        return $user->id == $order->user_id;
    }
}
