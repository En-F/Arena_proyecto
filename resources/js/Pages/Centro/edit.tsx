import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';
import '../../../css/noticia/formulario.css';
import { Input } from '@/components/ui/input';
import Button from '@/components/Layouts/Button';

interface Centro {
    nombre: string;
    telefono: string;
    email: string;
    direccion: string;
    imagen: null;
    descripcion: string;
    es_activo: true;
    latitud: string;
    longitud: string;
}

interface Props {
    centro: Centro;
}

export default function CreateCentro({ centro }: Props) {
    const { data, setData, post, processing, errors, setError, clearErrors } =
        useForm({
            nombre: centro.nombre,
            telefono: centro.telefono,
            email: centro.email,
            direccion: centro.direccion,
            imagen: null,
            descripcion: centro.descripcion,
            es_activo: true,
            latitud: centro.latitud,
            longitud: centro.longitud,
            _method: 'PUT',
        });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        clearErrors();

        let tieneErrores = false;
        const emailLimpio = data.email ? data.email.trim() : '';

        const regexNombre = /^[a-zA-ZÀ-ÿ0-9\s\+]+$/;
        const regexEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        const regexTelefono = /^[0-9\s]+$/;

        if (data.nombre && !regexNombre.test(data.nombre)) {
            setError(
                'nombre',
                'El nombre solo puede contener letras y números.',
            );
            tieneErrores = true;
        }

        if (data.telefono && !regexTelefono.test(data.telefono)) {
            setError(
                'telefono',
                'El teléfono solo puede contener números, espacios.',
            );
            tieneErrores = true;
        }

        if (emailLimpio && !regexEmail.test(emailLimpio)) {
            setError(
                'email',
                'El formato del correo electrónico no es válido.',
            );
            tieneErrores = true;
        }

        const camposObligatorios = [
            { id: 'nombre', valor: data.nombre, nombre: 'Nombre' },
            { id: 'telefono', valor: data.telefono, nombre: 'Teléfono' },
            { id: 'email', valor: emailLimpio, nombre: 'Email' },
            { id: 'direccion', valor: data.direccion, nombre: 'Dirección' },
            {
                id: 'descripcion',
                valor: data.descripcion,
                nombre: 'Descripción',
            },
        ];

        camposObligatorios.forEach((campo) => {
            if (
                campo.valor === null ||
                campo.valor === undefined ||
                campo.valor.toString().trim() === ''
            ) {
                setError(
                    campo.id as any,
                    `El campo ${campo.nombre} es obligatorio.`,
                );
                tieneErrores = true;
            }
        });

        if (tieneErrores) return;

        setData('email', emailLimpio);

        post(route('centros.update', centro.id), {
            forceFormData: true,
            preserveScroll: true,
        });
    };

    return (
        <form onSubmit={handleSubmit}>
            <div className="cn-page">
                <div className="cn-wrap">
                    <div className="cn-section-header">
                        <h2 className="cn-section-title">
                            Registrar Nuevo Centro
                        </h2>
                        <p className="cn-section-subtitle">
                            Ingresa los datos del centro para que los usuarios
                            puedan localizarlo.
                        </p>
                    </div>

                    <div className="cn-field">
                        <label className="cn-label">Nombre del Centro</label>
                        <Input
                            name="nombre"
                            value={data.nombre}
                            onChange={(e) => setData('nombre', e.target.value)}
                            placeholder="Ej: Centro Deportivo Sanlúcar"
                            className="cn-input"
                        />
                        {errors.nombre && (
                            <span className="text-xs text-red-500">
                                {errors.nombre}
                            </span>
                        )}
                    </div>

                    <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div className="cn-field">
                            <label className="cn-label">Teléfono</label>
                            <Input
                                name="telefono"
                                value={data.telefono}
                                onChange={(e) =>
                                    setData('telefono', e.target.value)
                                }
                                placeholder="600 000 000"
                            />
                            {errors.telefono && (
                                <span className="text-xs text-red-500">
                                    {errors.telefono}
                                </span>
                            )}
                        </div>

                        <div className="cn-field">
                            <label className="cn-label">
                                Email de contacto
                            </label>
                            <Input
                                type="text"
                                name="email"
                                value={data.email}
                                onChange={(e) =>
                                    setData('email', e.target.value)
                                }
                                placeholder="centro@ejemplo.com"
                            />
                            {errors.email && (
                                <span className="text-xs text-red-500">
                                    {errors.email}
                                </span>
                            )}
                        </div>
                    </div>

                    <div className="cn-field">
                        <label className="cn-label">Dirección física</label>
                        <Input
                            name="direccion"
                            value={data.direccion}
                            onChange={(e) =>
                                setData('direccion', e.target.value)
                            }
                            placeholder="Calle, Número, Ciudad..."
                        />
                        {errors.direccion && (
                            <span className="text-xs text-red-500">
                                {errors.direccion}
                            </span>
                        )}
                    </div>

                    <div className="cn-field">
                        <label className="cn-label">Descripción</label>
                        <textarea
                            rows={4}
                            className="cn-textarea"
                            value={data.descripcion}
                            onChange={(e) =>
                                setData('descripcion', e.target.value)
                            }
                            placeholder="Describe los servicios del centro..."
                        />
                        {errors.descripcion && (
                            <span className="text-xs text-red-500">
                                {errors.descripcion}
                            </span>
                        )}
                    </div>

                    <hr className="cn-divider" />

                    <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div className="cn-field">
                            <label className="cn-label">
                                Imagen de portada
                            </label>
                            <Input
                                type="file"
                                onChange={(e) =>
                                    setData('imagen', e.target.files[0])
                                }
                            />
                            {errors.imagen && (
                                <span className="text-xs text-red-500">
                                    {errors.imagen}
                                </span>
                            )}
                        </div>

                        <div className="cn-field">
                            <label className="cn-label">
                                Estado de publicación
                            </label>
                            <div className="mt-2 flex gap-4">
                                <label className="flex cursor-pointer items-center gap-2">
                                    <input
                                        type="radio"
                                        checked={data.es_activo === true}
                                        onChange={() =>
                                            setData('es_activo', true)
                                        }
                                    />
                                    <span>Motrar</span>
                                </label>
                                <label className="flex cursor-pointer items-center gap-2">
                                    <input
                                        type="radio"
                                        checked={data.es_activo === false}
                                        onChange={() =>
                                            setData('es_activo', false)
                                        }
                                    />
                                    <span>Ocultar</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <hr className="cn-divider" />

                    <div className="cn-section-header">
                        <p className="text-sm font-bold">
                            Ubicación exacta (GPS)
                        </p>
                    </div>
                    <div className="grid grid-cols-2 gap-4">
                        <div className="cn-field">
                            <label className="cn-label">Latitud</label>
                            <Input
                                type="number"
                                step="any"
                                value={data.latitud}
                                onChange={(e) =>
                                    setData('latitud', e.target.value)
                                }
                                placeholder="36.77..."
                            />
                        </div>
                        <div className="cn-field">
                            <label className="cn-label">Longitud</label>
                            <Input
                                type="number"
                                step="any"
                                value={data.longitud}
                                onChange={(e) =>
                                    setData('longitud', e.target.value)
                                }
                                placeholder="-6.35..."
                            />
                        </div>
                    </div>

                    <div className="cn-actions mt-10">
                        <Button
                            href={route('centros.show', centro.id)}
                            className="cn-btn-cancel"
                            type="button"
                        >
                            Cancelar
                        </Button>
                        <Button
                            type="submit"
                            className="cn-btn-save"
                            disabled={processing}
                        >
                            {processing ? 'Guardando...' : 'Guardar Centro'}
                        </Button>
                    </div>
                </div>
            </div>
        </form>
    );
}
