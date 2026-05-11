import { Form, Head } from '@inertiajs/react';
import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { register } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';
import '../../../css/login.css';

export default function Login({ status, canResetPassword, canRegister }) {
    return (
        <>
            <Head title="Acceso Socios" />

            <div className="login-page">
                <div className="login-card">
                    <div className="login-card__image-col">
                        <img
                            src="/storage/otros/inscripcion.jpg"
                            alt="loginFoto"
                            className="login-card__image"
                        />
                    </div>

                    <div className="login-card__form-col">
                        <Form
                            {...store.form()}
                            resetOnSuccess={['password']}
                            className="login-form"
                        >
                            {({ processing, errors }) => (
                                <div className="login-form__contenedor">
                                    <Label className="login-form__titulo-principal">
                                        Acceso socios
                                    </Label>

                                    <div className="input-field-wrapper">
                                        <div className="input-header-row">
                                            <Label htmlFor="email">Email</Label>
                                            <TextLink
                                                href={register()}
                                                className="input-helper-link"
                                            >
                                                ¿No estás registrado?{' '}
                                                <strong>Crea tu cuenta</strong>
                                            </TextLink>
                                        </div>
                                        <Input
                                            id="email"
                                            type="email"
                                            name="email"
                                            required
                                            autoFocus
                                            placeholder="Correo electrónico"
                                            className="login-form__input"
                                        />
                                        <InputError message={errors.email} />
                                    </div>

                                    <div className="input-field-wrapper">
                                        <div className="input-header-row">
                                            <Label htmlFor="password">
                                                Contraseña
                                            </Label>
                                            <TextLink
                                                href={request()}
                                                className="input-helper-link"
                                            >
                                                ¿Olvidaste tu contraseña?
                                            </TextLink>
                                        </div>
                                        <Input
                                            id="password"
                                            type="password"
                                            name="password"
                                            required
                                            placeholder="Contraseña"
                                            className="login-form__input"
                                        />
                                        <InputError message={errors.password} />
                                    </div>

                                    <div className="login-form__remember">
                                        <input
                                            type="checkbox"
                                            id="remember"
                                            name="remember"
                                        />
                                        <Label
                                            htmlFor="remember"
                                            className="checkbox-label"
                                        >
                                            Recordar Contraseña
                                        </Label>
                                    </div>

                                    <Button
                                        type="submit"
                                        className="login-form__submit-btn"
                                        disabled={processing}
                                    >
                                        {processing && <Spinner />}
                                        Iniciar sesión
                                    </Button>
                                </div>
                            )}
                        </Form>
                    </div>
                </div>
            </div>
        </>
    );
}
