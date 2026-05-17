import { Form, Head, usePage } from '@inertiajs/react';
import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
import Heading from '@/components/heading';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { edit } from '@/routes/profile';
import Logout from '../settings/logout';

export default function Profile() {
    const { auth } = usePage().props;

    return (
        <>
            <Head title="Ajustes del perfil" />

            <h1 className="sr-only">Configuración del usuario</h1>

            <div className="space-y-8">
                <Heading
                    variant="small"
                    title="Información del perfil"
                    description="Actualiza tu nombre y dirección de correo electrónico"
                />

                <div className="rounded-lg border border-neutral-200 bg-white p-6 shadow-sm transition-all duration-200 dark:border-neutral-800 dark:bg-neutral-950">
                    <Form
                        {...ProfileController.update.form()}
                        options={{
                            preserveScroll: true,
                        }}
                        className="space-y-6"
                    >
                        {({ processing, errors }) => (
                            <>
                                <div className="space-y-2">
                                    <Label
                                        htmlFor="name"
                                        className="font-semibold text-neutral-700 dark:text-neutral-300"
                                    >
                                        Nombre
                                    </Label>

                                    <Input
                                        id="name"
                                        className="h-10 rounded-md border border-neutral-300 bg-white px-4 py-2 text-sm transition-all duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-50 dark:border-neutral-600 dark:bg-neutral-900 dark:text-neutral-100 dark:focus:ring-blue-950"
                                        defaultValue={auth.user.name}
                                        name="name"
                                        required
                                        autoComplete="name"
                                        placeholder="Nombre completo"
                                    />

                                    <InputError
                                        className="mt-1 text-xs font-medium"
                                        message={errors.name}
                                    />
                                </div>

                                <div className="space-y-2">
                                    <Label
                                        htmlFor="email"
                                        className="font-semibold text-neutral-700 dark:text-neutral-300"
                                    >
                                        Correo electrónico
                                    </Label>

                                    <Input
                                        id="email"
                                        type="email"
                                        className="h-10 rounded-md border border-neutral-300 bg-white px-4 py-2 text-sm transition-all duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-50 dark:border-neutral-600 dark:bg-neutral-900 dark:text-neutral-100 dark:focus:ring-blue-950"
                                        defaultValue={auth.user.email}
                                        name="email"
                                        required
                                        autoComplete="username"
                                        placeholder="Dirección de correo electrónico"
                                    />

                                    <InputError
                                        className="mt-1 text-xs font-medium"
                                        message={errors.email}
                                    />
                                </div>

                                <div className="flex items-center gap-3 border-t border-neutral-200 pt-6 dark:border-neutral-800">
                                    <Button
                                        disabled={processing}
                                        data-test="update-profile-button"
                                        className="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none disabled:cursor-not-allowed disabled:opacity-50 dark:hover:bg-blue-600 dark:focus:ring-offset-neutral-950"
                                    >
                                        {processing
                                            ? 'Guardando...'
                                            : 'Guardar'}
                                    </Button>
                                </div>
                            </>
                        )}
                    </Form>
                </div>

                <Logout />
            </div>
        </>
    );
}

Profile.layout = {
    breadcrumbs: [
        {
            title: 'Ajustes del perfil',
            href: edit(),
        },
    ],
};
