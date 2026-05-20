import { Form, Head, usePage } from '@inertiajs/react';
import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login } from '@/routes';
import { store as registerStore } from '@/routes/register';
import '../../../css/login.css';

export default function Register({ centros, tarifas }) {
    return (
        <>
            <Head title="Inscripción de Socios" />

            <div className="login-page">
                <div className="login-card" style={{ maxWidth: '900px' }}>
                    {' '}
                    <div className="login-card__image-col">
                        <img
                            src="/storage/otros/inscripcion.jpg"
                            alt="RegistroFoto"
                            className="login-card__image"
                        />
                    </div>
                    <div className="login-card__form-col">
                        <Form {...registerStore.form()} className="login-form">
                            {({ processing, errors, data, setData }) => (
                                <div className="login-form__contenedor">
                                    <Label className="login-form__titulo-principal">
                                        Formulario de Inscripción
                                    </Label>

                                    <div className="grid grid-cols-2 gap-4">
                                        <div className="input-field-wrapper">
                                            <Label htmlFor="dni">
                                                DNI / NIE
                                            </Label>
                                            <Input
                                                id="dni"
                                                name="dni"
                                                value={data.dni}
                                                onChange={(e) =>
                                                    setData(
                                                        'dni',
                                                        e.target.value,
                                                    )
                                                }
                                                required
                                                placeholder="12345678X"
                                            />
                                            <InputError message={errors.dni} />
                                        </div>

                                        <div className="input-field-wrapper">
                                            <Label htmlFor="telefono">
                                                Teléfono
                                            </Label>
                                            <Input
                                                id="telefono"
                                                type="tel"
                                                name="telefono"
                                                value={data.telefono}
                                                onChange={(e) =>
                                                    setData(
                                                        'telefono',
                                                        e.target.value,
                                                    )
                                                }
                                                required
                                                placeholder="600 000 000"
                                            />
                                            <InputError
                                                message={errors.telefono}
                                            />
                                        </div>
                                    </div>

                                    <div className="input-field-wrapper">
                                        <Label htmlFor="email">Email</Label>
                                        <Input
                                            id="email"
                                            type="email"
                                            name="email"
                                            value={data.email}
                                            onChange={(e) =>
                                                setData('email', e.target.value)
                                            }
                                            required
                                            placeholder="correo@ejemplo.com"
                                        />
                                        <InputError message={errors.email} />
                                    </div>

                                    <div className="grid grid-cols-2 gap-4">
                                        <div className="input-field-wrapper">
                                            <Label htmlFor="centro">
                                                Centro Deportivo
                                            </Label>
                                            <select
                                                id="centro"
                                                className="login-form__input select-custom" // Añade estilo en tu CSS
                                                value={data.centro_id}
                                                onChange={(e) =>
                                                    setData(
                                                        'centro_id',
                                                        e.target.value,
                                                    )
                                                }
                                                required
                                            >
                                                <option value="">
                                                    Selecciona centro
                                                </option>
                                                {centros?.map((c) => (
                                                    <option
                                                        key={c.id}
                                                        value={c.id}
                                                    >
                                                        {c.nombre}
                                                    </option>
                                                ))}
                                            </select>
                                            <InputError
                                                message={errors.centro_id}
                                            />
                                        </div>

                                        <div className="input-field-wrapper">
                                            <Label htmlFor="tarifa">
                                                Tarifa
                                            </Label>
                                            <select
                                                id="tarifa"
                                                className="login-form__input select-custom"
                                                value={data.tarifa_id}
                                                onChange={(e) =>
                                                    setData(
                                                        'tarifa_id',
                                                        e.target.value,
                                                    )
                                                }
                                                required
                                            >
                                                <option value="">
                                                    Selecciona tarifa
                                                </option>
                                                {tarifas?.map((t) => (
                                                    <option
                                                        key={t.id}
                                                        value={t.id}
                                                    >
                                                        {t.nombre} - {t.precio}€
                                                    </option>
                                                ))}
                                            </select>
                                            <InputError
                                                message={errors.tarifa_id}
                                            />
                                        </div>
                                    </div>

                                    <div className="input-field-wrapper">
                                        <Label htmlFor="password">
                                            Contraseña
                                        </Label>
                                        <Input
                                            id="password"
                                            type="password"
                                            name="password"
                                            value={data.password}
                                            onChange={(e) =>
                                                setData(
                                                    'password',
                                                    e.target.value,
                                                )
                                            }
                                            required
                                            placeholder="Mínimo 8 caracteres"
                                        />
                                        <InputError message={errors.password} />
                                    </div>

                                    <Button
                                        type="submit"
                                        className="login-form__submit-btn"
                                        disabled={processing}
                                    >
                                        {processing && <Spinner />}
                                        Finalizar Inscripción
                                    </Button>

                                    <TextLink
                                        href={login()}
                                        className="mt-4 text-center"
                                    >
                                        ¿Ya eres socio?{' '}
                                        <strong>Inicia sesión</strong>
                                    </TextLink>
                                </div>
                            )}
                        </Form>
                    </div>
                </div>
            </div>
        </>
    );
}
