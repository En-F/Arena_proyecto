// CrearNoticia.jsx
import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';
import '../../../css/noticia/formulario.css';
import { Input } from '@/components/ui/input';
import Button from '@/components/Layouts/Button';

interface Actividad {
    id: number;
    nombre: string;
    nivel: string;
    descripcion: string;
    imagen: string;
    tipo_id: string;
    cursos_ids: string[];
    es_activo: boolean;
    cursos?: Array<{ id: number; nombre: string }>;
}

interface Props {
    cursos: Array<{ id: number; nombre: string }>;
    tipos: Array<{ id: number; tipo: string }>;
    actividad: Actividad;
}

export default function Edit({ tipos, actividad, cursos }: Props) {
    const { data, setData, post, processing, errors, setError, clearErrors } =
        useForm({
            nombre: actividad.nombre || '',
            nivel: actividad.nivel || '',
            descripcion: actividad.descripcion || '',
            imagen: null,
            cursos_ids: actividad.cursos
                ? actividad.cursos.map((curso) => curso.id.toString())
                : [],
            tipo_id: actividad.tipo_id || '',
            _method: 'PUT',
        });
    console.log(data);

    const handleCursoCheckbox = (id: number) => {
        const id_string = id.toString();
        const nuevos_ids = data.cursos_ids.includes(id_string)
            ? data.cursos_ids.filter((curso_id) => curso_id !== id_string)
            : [...data.cursos_ids, id_string];
        setData('cursos_ids', nuevos_ids);
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

        if (!data.nivel || data.nivel.trim() === '') {
            setError('nivel', 'El campo nivel es obligatorio.');
            tieneErrores = true;
        }

        if (!data.descripcion || data.descripcion.trim() === '') {
            setError('descripcion', 'El campo descripcion es obligatorio.');
            tieneErrores = true;
        }

        if (!data.tipo_id) {
            setError('tipo_id', 'El campo Centro es obligatorio.');
            tieneErrores = true;
        }

        if (!data.cursos_ids) {
            setError('cursos_ids', 'El campo curso es obligatorio.');
            tieneErrores = true;
        }

        if (tieneErrores) return;

        post(route('actividades.update', actividad.id), {
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
                                Editar la actividad {actividad.nombre}
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
                                placeholder="Escribe el nombre de la actividad..."
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
                            <label className="cn-label mb-2 font-bold">
                                Nivel
                            </label>

                            <div className="flex gap-4">
                                <div className="flex items-center gap-2">
                                    <Input
                                        type="radio"
                                        name="nivel"
                                        value="facil"
                                        checked={data.nivel === 'facil'}
                                        onChange={() =>
                                            setData('nivel', 'facil')
                                        }
                                    />
                                    <label className="cn-label">Fácil</label>
                                </div>
                                <div className="flex items-center gap-2">
                                    <Input
                                        type="radio"
                                        name="nivel"
                                        value="intermedio"
                                        checked={data.nivel === 'intermedio'}
                                        onChange={() =>
                                            setData('nivel', 'intermedio')
                                        }
                                    />
                                    <label className="cn-label">
                                        Intermedio
                                    </label>
                                </div>
                                <div className="flex items-center gap-2">
                                    <Input
                                        type="radio"
                                        name="nivel"
                                        value="dificil"
                                        checked={data.nivel === 'dificil'}
                                        onChange={() =>
                                            setData('nivel', 'dificil')
                                        }
                                    />
                                    <label className="cn-label">Difícil</label>
                                </div>
                            </div>
                            {errors.nivel && (
                                <span className="mt-1 text-xs text-red-500">
                                    {errors.nivel}
                                </span>
                            )}
                        </div>

                        <div className="cn-field">
                            <label className="cn-label">Descripción</label>
                            <textarea
                                name="descripcion"
                                placeholder="Escribe la descripción de la actividad..."
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
                                <label className="cn-label">Tipo</label>
                                <select
                                    name="tipo_id"
                                    className="cn-input"
                                    value={data.tipo_id}
                                    onChange={(e) =>
                                        setData('tipo_id', e.target.value)
                                    }
                                >
                                    <option value="">Seleccionar tipo</option>
                                    {tipos.map((tipo) => (
                                        <option key={tipo.id} value={tipo.id}>
                                            {tipo.tipo}
                                        </option>
                                    ))}
                                </select>
                                {errors.tipo_id && (
                                    <span className="mt-1 text-xs text-red-500">
                                        {errors.tipo_id}
                                    </span>
                                )}
                            </div>
                            <div className="cn-field">
                                <label className="cn-label mb-2 font-bold">
                                    Cursos asignados
                                </label>
                                <div className="grid grid-cols-2 gap-3 rounded-md border bg-white p-3">
                                    {cursos.map((curso) => (
                                        <div
                                            key={curso.id}
                                            className="flex items-center gap-2"
                                        >
                                            <input
                                                type="checkbox"
                                                id={`curso-${curso.id}`}
                                                checked={data.cursos_ids.includes(
                                                    curso.id.toString(),
                                                )}
                                                onChange={() =>
                                                    handleCursoCheckbox(
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
                                {errors.cursos_ids && (
                                    <span className="mt-1 text-xs text-red-500">
                                        {errors.cursos_ids}
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
