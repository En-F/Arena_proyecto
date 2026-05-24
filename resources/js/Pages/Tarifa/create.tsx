import React from 'react';
import { useForm, Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import '../../../css/noticia/formulario.css';
import { Input } from '@/components/ui/input';
import Button from '@/components/Layouts/Button';

interface Centro {
    id: number;
    nombre: string;
}

interface Props {
    centros: Centro[];
}

export default function Create({ centros }: Props) {
    const { data, setData, post, processing, errors, setError, clearErrors } =
        useForm({
            precio: '',
            tipo: 'basica',
            periodo: 'mes',
            descripcion: '',
            descuento: 0,
            centro_id: centros.length > 0 ? centros[0].id : '',
        });

    const esMensual = data.periodo === 'mes';
    const multiplicadores = {
        mes: 1,
        trimestre: 3,
        semestre: 6,
        año: 12,
    };

    const handle = (e: React.FormEvent) => {
        e.preventDefault();
        clearErrors();

        let tieneErrores = false;
        const regexSoloLetras = /^[a-zA-ZÀ-ÿ\s]+$/;

        if (!data.precio) {
            setError('precio', 'El precio es obligatorio.');
            tieneErrores = true;
        } else if (isNaN(Number(data.precio)) || Number(data.precio) <= 0) {
            setError('precio', 'Introduce un precio numérico superior a 0.');
            tieneErrores = true;
        }

        if (!data.descripcion || data.descripcion.trim() === '') {
            setError('descripcion', 'La descripción es obligatoria.');
            tieneErrores = true;
        }

        if (!data.centro_id) {
            setError('centro_id', 'Debes seleccionar un centro.');
            tieneErrores = true;
        }

        if (Number(data.descuento) < 0 || Number(data.descuento) > 100) {
            setError('descuento', 'El descuento debe estar entre 0 y 100.');
            tieneErrores = true;
        }

        if (tieneErrores) return;

        post(route('tarifas.store'), {
            forceFormData: true,
        });
    };

    return (
        <>
            <Head title="Crear Nueva Tarifa" />
            <form onSubmit={handle}>
                <div className="cn-page">
                    <div className="cn-wrap">
                        <div className="cn-section-header">
                            <p className="cn-section-title">
                                Crear Nueva Tarifa
                            </p>
                            <p className="cn-section-subtitle">
                                Define los precios y características de la
                                suscripción para los centros.
                            </p>
                        </div>

                        <div className="cn-row">
                            <div className="cn-field">
                                <label className="cn-label">
                                    Seleccionar Centro
                                </label>
                                <select
                                    name="centro_id"
                                    className="cn-input"
                                    value={data.centro_id}
                                    onChange={(e) =>
                                        setData('centro_id', e.target.value)
                                    }
                                >
                                    <option value="" disabled>
                                        Selecciona un centro...
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
                                <label className="cn-label">
                                    Precio Base Mensual (€)
                                </label>
                                <Input
                                    type="number"
                                    name="precio"
                                    step="0.01"
                                    value={data.precio}
                                    placeholder="0.00"
                                    onChange={(e) =>
                                        setData('precio', e.target.value)
                                    }
                                    className="cn-input"
                                />
                                {errors.precio && (
                                    <span className="text-xs text-red-500">
                                        {errors.precio}
                                    </span>
                                )}
                            </div>

                            {!esMensual && data.precio && (
                                <div className="cn-field flex items-end pb-3">
                                    <div className="rounded border border-blue-200 bg-blue-50 p-3 text-sm text-blue-700 shadow-sm">
                                        <p className="mb-1 font-semibold">
                                            Resumen del Plan:
                                        </p>
                                        <ul className="ml-4 list-disc space-y-1">
                                            <li>
                                                Subtotal (
                                                {multiplicadores[data.periodo]}{' '}
                                                meses):
                                                <strong>
                                                    {' '}
                                                    {(
                                                        Number(data.precio) *
                                                        multiplicadores[
                                                            data.periodo
                                                        ]
                                                    ).toFixed(2)}
                                                    €
                                                </strong>
                                            </li>
                                            <li>
                                                Descuento aplicado:
                                                <strong className="text-green-600">
                                                    {' '}
                                                    -{data.descuento}%
                                                </strong>
                                            </li>
                                            <hr className="my-1 border-blue-200" />
                                            <li className="text-base">
                                                Precio final del periodo:
                                                <strong className="text-blue-900">
                                                    {(
                                                        Number(data.precio) *
                                                        multiplicadores[
                                                            data.periodo
                                                        ] *
                                                        (1 -
                                                            Number(
                                                                data.descuento,
                                                            ) /
                                                                100)
                                                    ).toFixed(2)}
                                                    €
                                                </strong>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            )}

                            <div className="cn-field">
                                <label className="cn-label">
                                    Periodo de Cobro
                                </label>
                                <select
                                    name="periodo"
                                    className="cn-input"
                                    value={data.periodo}
                                    onChange={(e) => {
                                        const val = e.target.value;
                                        setData({
                                            ...data,
                                            periodo: val,
                                            descuento:
                                                val === 'mes'
                                                    ? 0
                                                    : data.descuento,
                                        });
                                    }}
                                >
                                    <option value="mes">Mensual</option>
                                    <option value="trimestre">
                                        Trimestral
                                    </option>
                                    <option value="semestre">Semestral</option>
                                    <option value="año">Anual</option>
                                </select>
                            </div>
                            <div className="cn-field">
                                <label className="cn-label">
                                    Descuento %{' '}
                                    {esMensual && '(Solo para periodos largos)'}
                                </label>
                                <Input
                                    type="number"
                                    name="descuento"
                                    value={data.descuento}
                                    min="0"
                                    max="100"
                                    disabled={esMensual}
                                    onChange={(e) =>
                                        setData('descuento', e.target.value)
                                    }
                                    className={`cn-input ${esMensual ? 'bg-gray-100 opacity-50' : ''}`}
                                    placeholder="0"
                                />
                                {errors.descuento && (
                                    <span className="text-xs text-red-500">
                                        {errors.descuento}
                                    </span>
                                )}
                            </div>
                        </div>
                        <div className="cn-row"></div>

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
                                href={route('tarifas.index')}
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
                                {processing ? 'Creando...' : 'Crear Tarifa'}
                            </Button>
                        </div>
                    </div>
                </div>
            </form>
        </>
    );
}
