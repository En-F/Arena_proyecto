// CrearNoticia.jsx
import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';
import '../../../css/noticia/formulario.css';
import { Input } from '@/components/ui/input';
import Button from '@/components/Layouts/Button';

interface Props {
    centros: Array<{ id: number; nombre: string }>;
    fecha_actual: string;
}

export default function CrearNoticia({ centros, fecha_actual }: Props) {
    const { data, setData, post, processing, errors, setError, clearErrors } =
        useForm({
            titulo: '',
            contenido: '',
            imagen: null,
            fecha: fecha_actual,
            centro_id: '',
            usuario_id: '',
        });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        clearErrors();

        let tieneErrores = false;

        const regexSoloLetrasYNumeros = /^[a-zA-Z0-9À-ÿ\s]+$/;

        if (data.titulo && !regexSoloLetrasYNumeros.test(data.titulo)) {
            setError(
                'titulo',
                'El título solo puede contener letras y números (sin símbolos).',
            );
            tieneErrores = true;
        }

        const camposObligatorios = [
            { id: 'titulo', valor: data.titulo, nombre: 'Título' },
            { id: 'contenido', valor: data.contenido, nombre: 'Contenido' },
            { id: 'centro_id', valor: data.centro_id, nombre: 'Centro' },
            { id: 'fecha', valor: data.fecha, nombre: 'Fecha' },
        ];

        camposObligatorios.forEach((campo) => {
            if (!campo.valor || campo.valor.toString().trim() === '') {
                setError(
                    campo.id as any,
                    `El campo ${campo.nombre} es obligatorio.`,
                );
                tieneErrores = true;
            }
        });

        if (tieneErrores) return;

        post(route('noticias.store'), { forceFormData: true });
    };

    return (
        <>
            <form onSubmit={handleSubmit}>
                <div className="cn-page">
                    <div className="cn-wrap">
                        <div className="cn-section-header">
                            <p className="cn-section-title">Crear noticia</p>
                            <p className="cn-section-subtitle">
                                Esta información se mostrará públicamente. Sé
                                cuidadoso con lo que publicas.
                            </p>
                        </div>

                        <div className="cn-field">
                            <label className="cn-label">Título</label>
                            <Input
                                name="titulo"
                                placeholder="Escribe el titular de la noticia"
                                value={data.titulo}
                                onChange={(e) =>
                                    setData('titulo', e.target.value)
                                }
                                className="cn-input"
                            />
                            {errors.titulo && (
                                <span className="mt-1 text-xs text-red-500">
                                    {errors.titulo}
                                </span>
                            )}
                        </div>

                        <div className="cn-field">
                            <label className="cn-label">Contenido</label>
                            <textarea
                                name="contenido"
                                placeholder="Escribe el cuerpo completo de la noticia..."
                                rows={7}
                                className="cn-textarea"
                                value={data.contenido}
                                onChange={(e) =>
                                    setData('contenido', e.target.value)
                                }
                            />
                            {errors.contenido && (
                                <span className="mt-1 text-xs text-red-500">
                                    {errors.contenido}
                                </span>
                            )}
                        </div>

                        <hr className="cn-divider" />

                        <div className="cn-field">
                            <label className="cn-label">
                                Imagen de portada
                            </label>
                            <Input
                                className="cn-input"
                                name="imagen"
                                type="file"
                                onChange={(e) =>
                                    setData('imagen', e.target.files[0])
                                }
                            />
                            {errors.imagen && (
                                <span className="mt-1 text-xs text-red-500">
                                    {errors.imagen}
                                </span>
                            )}
                        </div>

                        <hr className="cn-divider" />

                        <div className="cn-row">
                            <div className="cn-field">
                                <label className="cn-label">Centro</label>
                                <select
                                    name="centro_id"
                                    className="cn-input"
                                    value={data.centro_id}
                                    onChange={(e) =>
                                        setData('centro_id', e.target.value)
                                    }
                                >
                                    <option value="">
                                        Seleccionar centros
                                    </option>
                                    {centros.map((centro) => (
                                        <option
                                            key={centro.id}
                                            value={centro.id}
                                        >
                                            {centro.nombre}
                                        </option>
                                    ))}
                                </select>
                                {errors.centro_id && (
                                    <span className="mt-1 text-xs text-red-500">
                                        {errors.centro_id}
                                    </span>
                                )}
                            </div>
                            <div className="cn-field">
                                <label className="cn-label">
                                    Fecha de publicación
                                </label>
                                <Input
                                    type="date"
                                    name="fecha"
                                    value={data.fecha}
                                    onChange={(e) =>
                                        setData('fecha', e.target.value)
                                    }
                                    className="cn-input"
                                />
                                {errors.fecha && (
                                    <span className="mt-1 text-xs text-red-500">
                                        {errors.fecha}
                                    </span>
                                )}
                            </div>
                        </div>
                        <div className="cn-section-header"></div>

                        <div className="cn-actions">
                            <Button
                                href="/inicio"
                                type="button"
                                className="cn-btn-cancel"
                            >
                                Cancelar
                            </Button>
                            <Button
                                type="submit"
                                className="cn-btn-save"
                                disabled={processing}
                            >
                                {processing ? 'Enviando...' : 'Guardar noticia'}
                            </Button>
                        </div>
                    </div>
                </div>
            </form>
        </>
    );
}
