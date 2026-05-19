import React from 'react';
import { useForm, Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import '../../../css/noticia/formulario.css';
import { Input } from '@/components/ui/input';
import Button from '@/components/Layouts/Button';

interface Tarifa {
    id: number;
    precio: number;
    tipo: string;
    periodo: string;
    descripcion: string | string[];
    centro: { id: number; nombre: string };
}

interface Props {
    tarifa: Tarifa;
    urlAnterior: string;
}

export default function Edit({ tarifa, from, urlAnterior }: Props) {
    const { data, setData, post, processing, errors, setError, clearErrors } =
        useForm({
            precio: tarifa.precio || '',
            tipo: tarifa.tipo || 'basica',
            periodo: tarifa.periodo || 'mes',
            descripcion: Array.isArray(tarifa.descripcion)
                ? tarifa.descripcion.join(', ')
                : tarifa.descripcion,
            centro_id: tarifa.centro.id,
            _method: 'PUT',
            origen: from,
        });

    const handle = (e: React.FormEvent) => {
        e.preventDefault();
        clearErrors();

        let tieneErrores = false;

        const regexSoloLetras = /^[a-zA-ZÀ-ÿ\s]+$/;

        if (!data.precio || isNaN(Number(data.precio))) {
            setError('precio', 'Introduce un precio válido.');
            tieneErrores = true;
        }

        if (!data.periodo || !regexSoloLetras.test(data.periodo)) {
            setError('periodo', 'El periodo solo puede contener letras.');
            tieneErrores = true;
        }

        if (!data.descripcion || data.descripcion.trim() === '') {
            setError('descripcion', 'La descripción es obligatoria.');
            tieneErrores = true;
        }

        if (tieneErrores) return;

        post(route('tarifas.update', tarifa.id), {
            forceFormData: true,
        });
    };

    return (
        <>
            <Head title={`Editar Tarifa - ${tarifa.tipo}`} />
            <form onSubmit={handle}>
                <div className="cn-page">
                    <div className="cn-wrap">
                        <div className="cn-section-header">
                            <p className="cn-section-title">
                                Actualizar Tarifa
                            </p>
                            <p className="cn-section-subtitle">
                                Editando datos de la tarifa asignada al centro:{' '}
                                <strong>{tarifa.centro.nombre}</strong>
                            </p>
                        </div>

                        <div className="cn-row">
                            <div className="cn-field">
                                <label className="cn-label">
                                    Centro (No editable)
                                </label>
                                <Input
                                    type="text"
                                    value={tarifa.centro.nombre}
                                    readOnly
                                    className="cn-input cursor-not-allowed bg-gray-100 opacity-75"
                                />
                            </div>

                            <div className="cn-field">
                                <label className="cn-label">
                                    Nivel de Tarifa
                                </label>
                                <select
                                    name="tipo"
                                    className="cn-input"
                                    value={data.tipo}
                                    onChange={(e) =>
                                        setData('tipo', e.target.value)
                                    }
                                >
                                    <option value="basica">Básica</option>
                                    <option value="estandar">Estándar</option>
                                    <option value="premium">Premium</option>
                                </select>
                            </div>
                        </div>

                        <div className="cn-row">
                            <div className="cn-field">
                                <label className="cn-label">Precio (€)</label>
                                <Input
                                    type="number"
                                    name="precio"
                                    value={data.precio}
                                    step="0.01"
                                    min="0"
                                    placeholder="0.00"
                                    onChange={(e) =>
                                        setData('precio', e.target.value)
                                    }
                                    className="cn-input"
                                />
                                {errors.precio && (
                                    <span className="mt-1 text-xs text-red-500">
                                        {errors.precio}
                                    </span>
                                )}
                            </div>

                            <div className="cn-field">
                                <label className="cn-label">Periodo</label>
                                <Input
                                    type="text"
                                    name="periodo"
                                    value={data.periodo}
                                    onChange={(e) =>
                                        setData('periodo', e.target.value)
                                    }
                                    className="cn-input"
                                />
                                {errors.periodo && (
                                    <span className="mt-1 text-xs text-red-500">
                                        {errors.periodo}
                                    </span>
                                )}
                            </div>
                        </div>

                        <hr className="cn-divider" />

                        <div className="cn-field">
                            <label className="cn-label">
                                Características (separadas por comas)
                            </label>
                            <textarea
                                name="descripcion"
                                rows={5}
                                className="cn-textarea"
                                value={data.descripcion}
                                onChange={(e) =>
                                    setData('descripcion', e.target.value)
                                }
                                placeholder="Ej: Piscina, Gimnasio, Sauna..."
                            />
                            {errors.descripcion && (
                                <span className="mt-1 text-xs text-red-500">
                                    {errors.descripcion}
                                </span>
                            )}
                        </div>

                        <div className="cn-actions">
                            <Button
                                href={urlAnterior}
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
                                {processing
                                    ? 'Guardando...'
                                    : 'Guardar Cambios'}
                            </Button>
                        </div>
                    </div>
                </div>
            </form>
        </>
    );
}
