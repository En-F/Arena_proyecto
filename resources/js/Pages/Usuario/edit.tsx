import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';
import '../../../css/noticia/formulario.css';
import { Input } from '@/components/ui/input';
import Button from '@/components/Layouts/Button';

interface Usuario {
    id: number;
    name: string;
    email: string;
    dni?: boolean;
    telefono?: string;
}
interface Props {
    usuario: Usuario;
}

export default function Edit({ usuario }: Props) {
    const { data, setData, post, processing, errors, setError, clearErrors } =
        useForm({
            name: usuario.name || '',
            email: usuario.email || '',
            dni: usuario.dni || '',
            telefono: usuario.telefono || '',
            _method: 'PUT',
        });

    const handle = (e: React.FormEvent) => {
        e.preventDefault();
        clearErrors();

        let tieneErrores = false;

        const regexSoloLetrasYNumeros = /^[a-zA-Z0-9À-ÿ\s]+$/;

        if (data.name && !regexSoloLetrasYNumeros.test(data.name)) {
            setError(
                'name',
                'El título solo puede contener letras y números (sin símbolos).',
            );
            tieneErrores = true;
        }

        if (!data.email || data.email.trim() === '') {
            setError('email', 'El campo email es obligatorio.');
            tieneErrores = true;
        }

        if (!data.dni || data.dni.trim() === '') {
            setError('dni', 'El campo dni es obligatorio.');
            tieneErrores = true;
        }

        if (tieneErrores) return;

        post(route('usuarios.update', usuario.id), { forceFormData: true });
    };

    return (
        <>
            <form onSubmit={handle}>
                <div className="cn-page">
                    <div className="cn-wrap">
                        <div className="cn-section-header">
                            <p className="cn-section-title">
                                Actualizar los datos de un usuario
                            </p>
                            <p className="cn-section-subtitle">
                                Esta información se mostrará públicamente. Sé
                                cuidadoso con lo que publicas.
                            </p>
                        </div>

                        <div className="cn-field">
                            <label className="cn-label">Nombre</label>
                            <Input
                                name="name"
                                placeholder="Escribe el nombre de un usuario"
                                value={data.name}
                                onChange={(e) =>
                                    setData('name', e.target.value)
                                }
                                className="cn-input"
                            />
                            {errors.name && (
                                <span className="mt-1 text-xs text-red-500">
                                    {errors.name}
                                </span>
                            )}
                        </div>

                        <div className="cn-field">
                            <label className="cn-label">Email</label>
                            <Input
                                name="email"
                                placeholder="Escribe el email de un usuario"
                                value={data.email}
                                onChange={(e) =>
                                    setData('email', e.target.value)
                                }
                                className="cn-input"
                            />
                            {errors.email && (
                                <span className="mt-1 text-xs text-red-500">
                                    {errors.email}
                                </span>
                            )}
                        </div>
                        <hr className="cn-divider" />
                        <div className="cn-field">
                            <label className="cn-label">DNI</label>
                            <Input
                                name="dni"
                                placeholder="Escribe el dni de un usuario"
                                value={data.dni}
                                onChange={(e) => setData('dni', e.target.value)}
                                className="cn-input"
                            />
                            {errors.dni && (
                                <span className="mt-1 text-xs text-red-500">
                                    {errors.dni}
                                </span>
                            )}
                        </div>

                        <div className="cn-field">
                            <label className="cn-label">Telefono</label>
                            <Input
                                name="telefono"
                                placeholder="Escribe el nombre de un usuario"
                                value={data.telefono}
                                onChange={(e) =>
                                    setData('telefono', e.target.value)
                                }
                                className="cn-input"
                            />
                            {errors.telefono && (
                                <span className="mt-1 text-xs text-red-500">
                                    {errors.telefono}
                                </span>
                            )}
                        </div>

                        <div className="cn-section-header"></div>

                        <div className="cn-actions">
                            <Button
                                href="/usuarios"
                                type="button"
                                className="cn-btn-cancel"
                            >
                                Cancelar
                            </Button>
                            <Button type="submit" className="cn-btn-save">
                                {processing ? 'Enviando...' : 'Guardar usuario'}
                            </Button>
                        </div>
                    </div>
                </div>
            </form>
        </>
    );
}
