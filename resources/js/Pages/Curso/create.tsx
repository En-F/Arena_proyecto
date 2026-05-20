import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';
import '../../../css/noticia/formulario.css';
import { Input } from '@/components/ui/input';
import Button from '@/components/Layouts/Button';

interface Props {
    tipos: Array<{ id: number; tipo: string }>;
    centros: Array<{ id: number; nombre: string }>;
}

export default function create({ centros, tipos }: Props) {
    const { data, setData, post, processing, errors, setError, clearErrors } =
        useForm({
            nombre: '',
            descripcion: '',
            imagen: null,
            centros_ids: [],
            es_activo: true,
        });

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

        const regexSoloLetrasYNumeros = /^[a-zA-ZÀ-ÿ\s]+$/;

        if (data.nombre && !regexSoloLetrasYNumeros.test(data.nombre)) {
            setError('nombre', 'El título solo puede contener letras.');
            tieneErrores = true;
        }

        const camposObligatorios = [
            { id: 'nombre', valor: data.nombre, nombre: 'Título' },
            {
                id: 'descripcion',
                valor: data.descripcion,
                nombre: 'Descripción',
            },
            {
                id: 'centros_ids',
                valor: data.centros_ids.length > 0 ? 'ok' : '',
                nombre: 'cursos',
            },
            { id: 'es_activo', valor: data.es_activo, nombre: 'Es_activo' },
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

        post(route('cursos.store'), { forceFormData: true });
    };

    return (
        <>
            <form onSubmit={handleSubmit}>
                <div className="cn-page">
                    <div className="cn-wrap">
                        <div className="cn-section-header">
                            <p className="cn-section-title">Crear Curso</p>
                            <p className="cn-section-subtitle">
                                Esta información se mostrará públicamente. Sé
                                cuidadoso con lo que publicas.
                            </p>
                        </div>

                        <div className="cn-field">
                            <label className="cn-label">Título</label>
                            <Input
                                name="nombre"
                                placeholder="Escribe el nombre del curso..."
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
                                placeholder="Escribe la descripción del..."
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
                                    {centros.map((curso) => (
                                        <div
                                            key={curso.id}
                                            className="flex items-center gap-2"
                                        >
                                            <input
                                                type="checkbox"
                                                id={`curso-${curso.id}`}
                                                onChange={() =>
                                                    handleCentroCheckbox(
                                                        curso.id,
                                                    )
                                                }
                                                className="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                            />
                                            <label
                                                htmlFor={`curso-${curso.id}`}
                                                className="cursor-pointer text-sm text-gray-700"
                                            >
                                                {curso.nombre}
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
                        <div className="cn-field">
                            <label className="cn-label mb-2 font-bold">
                                Publicación
                            </label>

                            <div className="flex gap-4">
                                <div className="flex items-center gap-2">
                                    <Input
                                        id="mostrar"
                                        type="radio"
                                        name="es_activo"
                                        value="true"
                                        checked={data.es_activo === true}
                                        onChange={() =>
                                            setData('es_activo', true)
                                        }
                                        className="h-4 w-4"
                                    />
                                    <label className="cn-label cursor-pointer">
                                        Mostrar
                                    </label>
                                </div>

                                <div className="flex items-center gap-2">
                                    <Input
                                        id="ocultar"
                                        type="radio"
                                        name="es_activo"
                                        value="false"
                                        checked={data.es_activo === false}
                                        onChange={() =>
                                            setData('es_activo', false)
                                        }
                                        className="h-4 w-4"
                                    />
                                    <label className="cn-label cursor-pointer">
                                        Ocultar
                                    </label>
                                </div>
                            </div>

                            {errors.es_activo && (
                                <span className="mt-1 text-xs text-red-500">
                                    {errors.es_activo}
                                </span>
                            )}
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
                                {processing ? 'Enviando...' : 'Guardar curso'}
                            </Button>
                        </div>
                    </div>
                </div>
            </form>
        </>
    );
}
