import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';
import '../../../css/noticia/formulario.css';
import { Input } from '@/components/ui/input';
import Button from '@/components/Layouts/Button';
import React, { useRef, useState } from 'react';

const ICONOS_PREDEFINIDOS = [
    { id: 1, nombre: 'Gym', imagen: 'ic-1.png' },
    { id: 2, nombre: 'Futbol', imagen: 'ic-2.png' },
    { id: 3, nombre: 'Sala de yoga', imagen: 'ic-3.png' },
    { id: 4, nombre: 'Padel', imagen: 'ic-4.png' },
    { id: 5, nombre: 'MMA', imagen: 'ic-5.png' },
    { id: 6, nombre: 'Wc', imagen: 'ic-6.png' },
    { id: 7, nombre: 'Sala de spa', imagen: 'ic-7.png' },
    { id: 8, nombre: 'Artes marciales', imagen: 'ic-8.png' },
    { id: 9, nombre: 'Vestuarios', imagen: 'ic-9.png' },
    { id: 10, nombre: 'Entrenador Personal', imagen: 'ic-10.png' },
    { id: 11, nombre: 'Piscina', imagen: 'ic-11.png' },
];

interface Props {
    centros: Array<{ id: number; nombre: string }>;
}

export default function Create({ centros }: Props) {
    const [mostrarIconos, setMostrarIconos] = useState(false);
    const fileInputRef = useRef<HTMLInputElement>(null);

    const { data, setData, post, processing, errors, setError, clearErrors } =
        useForm({
            nombre: '',
            imagen: null as any,
            centros_ids: [],
            es_activo: true,
        });

    const handleCentroCheckbox = (id: number) => {
        const id_string = id.toString();
        const nuevos_ids = data.centros_ids.includes(id_string)
            ? data.centros_ids.filter((centro_id) => centro_id !== id_string)
            : [...data.centros_ids, id_string];
        setData('centros_ids', nuevos_ids);
    };

    const eliminarImagen = () => {
        setData('imagen', null);
        if (fileInputRef.current) {
            fileInputRef.current.value = '';
        }
    };

    const seleccionarIcono = (imagen: string) => {
        setData('imagen', `instalaciones/${imagen}`);
        setMostrarIconos(false);
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        clearErrors();

        let tieneErrores = false;

        const regexNombre = /^[a-zA-ZÀ-ÿ0-9\s]+$/;
        if (data.nombre && !regexNombre.test(data.nombre)) {
            setError('nombre', 'El título solo puede contener letras.');
            tieneErrores = true;
        }

        const camposObligatorios = [
            { id: 'nombre', valor: data.nombre, nombre: 'Título' },
            { id: 'es_activo', valor: data.es_activo, nombre: 'Es_activo' },
            { id: 'imagen', valor: data.imagen, nombre: 'Imagen o Icono' },
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

        post(route('instalaciones.store'), {
            preserveState: false,
            preserveScroll: false,
            forceFormData: true,
        });
    };

    return (
        <form onSubmit={handleSubmit}>
            <div className="cn-page">
                <div className="cn-wrap">
                    <div className="cn-section-header">
                        <p className="cn-section-title">Crear Instalación</p>
                    </div>

                    <div className="cn-field">
                        <label className="cn-label">Título</label>
                        <Input
                            placeholder="Nombre de la instalacion..."
                            value={data.nombre}
                            onChange={(e) => setData('nombre', e.target.value)}
                        />
                        {errors.nombre && (
                            <span className="text-xs text-red-500">
                                {errors.nombre}
                            </span>
                        )}
                    </div>

                    <hr className="cn-divider" />

                    <div className="cn-field">
                        <label className="cn-label text-lg font-bold">
                            Imagen o Icono
                        </label>

                        <div className="mt-4 flex flex-col gap-4">
                            <Input
                                ref={fileInputRef}
                                type="file"
                                onChange={(e) =>
                                    setData(
                                        'imagen',
                                        e.target.files
                                            ? e.target.files[0]
                                            : null,
                                    )
                                }
                            />

                            <div className="divider text-xs text-gray-400">
                                O BIEN
                            </div>

                            <button
                                type="button"
                                onClick={() => setMostrarIconos(!mostrarIconos)}
                                className={`btn btn-sm ${mostrarIconos ? 'btn-active' : 'btn-outline'}`}
                            >
                                {mostrarIconos
                                    ? 'Cerrar Galería'
                                    : 'Seleccionar un Icono Predefinido'}
                            </button>

                            {mostrarIconos && (
                                <div className="grid grid-cols-5 gap-3 rounded-xl border-2 border-dashed border-gray-200 bg-white p-4">
                                    {ICONOS_PREDEFINIDOS.map((icon) => (
                                        <div
                                            key={icon.id}
                                            onClick={() =>
                                                seleccionarIcono(icon.imagen)
                                            }
                                            className={`group flex cursor-pointer flex-col items-center rounded-xl border p-2 transition-all ${data.imagen === `instalaciones/${icon.imagen}` ? 'border-blue-500 bg-blue-50' : 'border-transparent hover:bg-gray-50'}`}
                                        >
                                            <img
                                                src={`/storage/instalaciones/${icon.imagen}`}
                                                className="h-10 w-10 object-contain transition-transform group-hover:scale-110"
                                            />
                                        </div>
                                    ))}
                                </div>
                            )}

                            {data.imagen && (
                                <div className="flex items-center gap-3 rounded-lg border border-success/20 bg-success/10 p-3">
                                    <span className="text-sm font-medium text-success">
                                        Seleccionado:
                                    </span>
                                    {typeof data.imagen === 'string' ? (
                                        <img
                                            src={`/storage/${data.imagen}`}
                                            className="h-8 w-8"
                                        />
                                    ) : (
                                        <span className="text-xs text-gray-500 italic">
                                            {data.imagen.name}
                                        </span>
                                    )}
                                    <button
                                        type="button"
                                        className="btn ml-auto btn-circle btn-ghost btn-xs"
                                        onClick={eliminarImagen}
                                    >
                                        ✕
                                    </button>
                                </div>
                            )}
                        </div>
                        {errors.imagen && (
                            <span className="text-xs font-bold text-red-500">
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
                                                handleCentroCheckbox(centro.id)
                                            }
                                            className="h-4 w-4 rounded border-gray-300 text-indigo-600"
                                        />
                                        <label
                                            htmlFor={`centro-${centro.id}`}
                                            className="cursor-pointer text-sm text-gray-700"
                                        >
                                            {centro.nombre}
                                        </label>
                                    </div>
                                ))}
                            </div>
                            {errors.centros_ids && (
                                <span className="text-xs text-red-500">
                                    {errors.centros_ids}
                                </span>
                            )}
                        </div>
                    </div>

                    <div className="cn-actions mt-10">
                        <Button
                            href="/instalaciones"
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
                            {processing ? 'Enviando...' : 'Guardar instalacion'}
                        </Button>
                    </div>
                </div>
            </div>
        </form>
    );
}
