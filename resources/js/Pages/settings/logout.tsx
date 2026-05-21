import { router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import Heading from '@/components/heading';

export default function Logout() {
    

    return (
        <div className="space-y-6 pt-10">
        <Heading
            variant="small"
            title="Sesión"
            description="Finaliza tu sesión actual y sal de la aplicación."
        />

        <div className="flex">
            <Button
                variant="destructive" 
                onClick={() => router.post('/logout')}
                className="cursor-pointer"
            >
                Cerrar sesión
            </Button>
        </div>
    </div>
    );
}