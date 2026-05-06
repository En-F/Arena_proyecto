import { usePage } from '@inertiajs/react';

export function usePermissions() {
    const { auth } = usePage().props;

    const user = auth?.user;

    return {
        isAdmin: user?.is_admin ?? false,
        isJefe: user?.is_jefe ?? false,
        user: user,
        isAuth: !!user,
    };
}
