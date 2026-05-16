import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';
import '../../../css/noticia/formulario.css';
import { Input } from '@/components/ui/input';
import Button from '@/components/Layouts/Button';

interface Curso {
    id: number;
    nombre: string;
    descripcion: string;
    imagen: string;
    centros_ids: string[];
    es_activo: boolean;
    centros?: Array<{ id: number; nombre: string }>;
}

interface Props {
    centros: Array<{ id: number; nombre: string }>;
    curso: Curso;
}

export default function Edit({ curso, centros }: Props) {
    const { data, setData, post, processing, errors, setError, clearErrors } =
        useForm({
            nombre: curso.nombre || '',
            descripcion: curso.descripcion || '',
            imagen: null,
            centros_ids: curso.centros
                ? curso.centros.map((centro) => centro.id.toString())
                : [],
            _method: 'PUT',
        });
    console.log('Curso completo:', curso);

    const handleCentroCheckbox = (id) => {
        const id_string = id.toString();
        const nuevos_ids = data.centros_ids.includes(id_string)
            ? data.centros_ids.filter((centro_id) => centro_id !== id_string)
            : [...data.centros_ids, id_string];
        setData('centros_ids', nuevos_ids);
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        clearErrors();

        let tieneErrores = false;

        const regexSoloLetras = /^[a-zA-ZÀ-ÿ\s]+$/;

        if (data.nombre && !regexSoloLetras.test(data.nombre)) {
            setError(
                'nombre',
                'El título solo puede contener letras y números (sin símbolos).',
            );
            tieneErrores = true;
        }

        if (!data.descripcion || data.descripcion.trim() === '') {
            setError('descripcion', 'El campo descripcion es obligatorio.');
            tieneErrores = true;
        }

        if (!data.centros_ids) {
            setError('centros_ids', 'El campo curso es obligatorio.');
            tieneErrores = true;
        }

        if (tieneErrores) return;

        post(route('cursos.update', curso.id), {
            forceFormData: true,
        });
    };

    return (
        <>
            <form onSubmit={handleSubmit}>
                <div className="cn-page">
                    <div className="cn-wrap">
                        <div className="cn-section-header">
                            <p className="cn-section-title">
                                Editar el curso {curso.nombre}
                            </p>
                            <p className="cn-section-subtitle">
                                Esta información se mostrará públicamente. Sé
                                cuidadoso con lo que publicas.
                            </p>
                        </div>

                        <div className="cn-field">
                            <label className="cn-label">Título</label>
                            <Input
                                name="nombre"
                                placeholder="Escribe el nombre de la curso..."
                                value={data.nombre}
                                onChange={(e) =>
                                    setData('nombre', e.target.value)
                                }
                                className="cn-input"
                            />
                            {errors.nombre && (
                                <span className="mt-1 text-xs text-red-500">
                                    {errors.nombre}
                                </span>
                            )}
                        </div>

                        <div className="cn-field">
                            <label className="cn-label">Descripción</label>
                            <textarea
                                name="descripcion"
                                placeholder="Escribe la descripción de la curso..."
                                rows={7}
                                className="cn-textarea"
                                value={data.descripcion || ''}
                                onChange={(e) =>
                                    setData('descripcion', e.target.value)
                                }
                            />
                            {errors.descripcion && (
                                <span className="mt-1 text-xs text-red-500">
                                    {errors.descripcion}
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
                                <label className="cn-label mb-2 font-bold">
                                    Centros asignados
                                </label>
                                <div className="grid grid-cols-2 gap-3 rounded-md border bg-white p-3">
                                    {centros.map((centro) => (
                                        <div
                                            key={centro.id}
                                            className="flex items-center gap-2"
                                        >
                                            <input
                                                type="checkbox"
                                                id={`centro-${centro.id}`}
                                                checked={data.centros_ids.includes(
                                                    centro.id.toString(),
                                                )}
                                                onChange={() =>
                                                    handleCentroCheckbox(
                                                        centro.id,
                                                    )
                                                }
                                                className="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                            />
                                            <label
                                                htmlFor={`centro-${centro.id}`}
                                                className="centror-pointer text-sm text-gray-700"
                                            >
                                                {centro.nombre}
                                            </label>
                                        </div>
                                    ))}
                                </div>
                                {errors.centros_ids && (
                                    <span className="mt-1 text-xs text-red-500">
                                        {errors.centros_ids}
                                    </span>
                                )}
                            </div>
                        </div>
                        <div className="cn-section-header"></div>

                        <div className="cn-actions">
                            <Button
                                href={route('cursos.show', curso.id)}
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
                                {processing ? 'Enviando...' : 'Guardar curso'}
                            </Button>
                        </div>
                    </div>
                </div>
            </form>
        </>
    );
}
