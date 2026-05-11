import { Form, Head } from '@inertiajs/react';
import InputError from '@/components/input-error';
import PasswordInput from '@/components/password-input';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login } from '@/routes';
import { store } from '@/routes/register';

export default function Register() {
    return (
        <>
            <Head title="Únete al equipo" />

            <div className="mx-auto w-full max-w-md space-y-8 rounded-3xl border border-blue-100 bg-white p-8 shadow-2xl shadow-blue-200/50">
                <div className="flex flex-col space-y-2 pb-2 text-center">
                    <h1 className="text-4xl font-black tracking-tighter uppercase italic">
                        Registrarse
                    </h1>
                    <p className="text-sm font-medium tracking-widest text-slate-500 uppercase">
                        Prepárate para la acción
                    </p>
                </div>

                <Form
                    {...store.form()}
                    resetOnSuccess={['password', 'password_confirmation']}
                    disableWhileProcessing
                    className="flex flex-col gap-6"
                >
                    {({ processing, errors }) => (
                        <>
                            <div className="grid gap-5">
                                <div className="grid gap-2">
                                    <Label
                                        htmlFor="name"
                                        className="ml-1 text-xs font-bold text-blue-900 uppercase"
                                    >
                                        Nombre de Atleta
                                    </Label>
                                    <Input
                                        id="name"
                                        className="h-12 rounded-xl border-slate-200 transition-all focus:border-blue-500 focus:ring-blue-500/20"
                                        type="text"
                                        required
                                        autoFocus
                                        tabIndex={1}
                                        autoComplete="name"
                                        name="name"
                                        placeholder="Tu nombre completo"
                                    />
                                    <InputError
                                        message={errors.name}
                                        className="mt-1 text-xs font-bold text-red-500"
                                    />
                                </div>

                                <div className="grid gap-2">
                                    <Label
                                        htmlFor="email"
                                        className="ml-1 text-xs font-bold text-blue-900 uppercase"
                                    >
                                        Correo electrónico
                                    </Label>
                                    <Input
                                        id="email"
                                        className="h-12 rounded-xl border-slate-200 transition-all focus:border-blue-500 focus:ring-blue-500/20"
                                        type="email"
                                        required
                                        tabIndex={2}
                                        autoComplete="email"
                                        name="email"
                                        placeholder="atleta@correo.com"
                                    />
                                    <InputError
                                        message={errors.email}
                                        className="mt-1 text-xs font-bold text-red-500"
                                    />
                                </div>

                                <div className="grid gap-2">
                                    <Label
                                        htmlFor="password"
                                        className="ml-1 text-xs font-bold text-blue-900 uppercase"
                                    >
                                        Contraseña
                                    </Label>
                                    <PasswordInput
                                        id="password"
                                        className="h-12 rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500/20"
                                        required
                                        tabIndex={4}
                                        autoComplete="new-password"
                                        name="password"
                                        placeholder="Crea una clave fuerte"
                                    />
                                    <InputError
                                        message={errors.password}
                                        className="mt-1 text-xs font-bold text-red-500"
                                    />
                                </div>

                                <div className="grid gap-2">
                                    <Label
                                        htmlFor="password_confirmation"
                                        className="ml-1 text-xs font-bold text-blue-900 uppercase"
                                    >
                                        Confirmar Contraseña
                                    </Label>
                                    <PasswordInput
                                        id="password_confirmation"
                                        className="h-12 rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500/20"
                                        required
                                        tabIndex={5}
                                        autoComplete="new-password"
                                        name="password_confirmation"
                                        placeholder="Repite tu clave"
                                    />
                                    <InputError
                                        message={errors.password_confirmation}
                                        className="mt-1 text-xs font-bold text-red-500"
                                    />
                                </div>

                                <Button
                                    type="submit"
                                    className="mt-4 h-14 w-full rounded-xl bg-blue-600 font-black tracking-wider text-white uppercase italic shadow-lg shadow-blue-200 transition-all duration-200 hover:bg-blue-700 active:scale-95"
                                    tabIndex={6}
                                    data-test="register-user-button"
                                    disabled={processing}
                                >
                                    {processing ? (
                                        <Spinner className="mr-2 h-5 w-5 text-white" />
                                    ) : null}
                                    ¡Empezar ahora!
                                </Button>
                            </div>

                            <div className="mt-6 rounded-2xl border border-blue-100 bg-blue-50 p-4 text-center text-sm font-medium text-slate-500">
                                ¿Ya formas parte del equipo?{' '}
                                <TextLink
                                    href={login()}
                                    tabIndex={7}
                                    className="text-blue-600 decoration-2 underline-offset-4 hover:text-blue-800"
                                >
                                    Inicia sesión
                                </TextLink>
                            </div>
                        </>
                    )}
                </Form>
            </div>
        </>
    );
}
