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
    descuento: number;
    descripcion: string | string[];
    centro: { id: number; nombre: string };
}

interface Props {
    tarifa: Tarifa;
    from: string;
    urlAnterior: string;
}

export default function Edit({ tarifa, from, urlAnterior }: Props) {
    const { data, setData, post, processing, errors, setError, clearErrors } =
        useForm({
            precio: tarifa.precio || '',
            tipo: tarifa.tipo || 'basica',
            periodo: tarifa.periodo || 'mes',
            descuento: tarifa.descuento || 0,
            descripcion: Array.isArray(tarifa.descripcion)
                ? tarifa.descripcion.join(', ')
                : tarifa.descripcion,
            centro_id: tarifa.centro.id,
            _method: 'PUT',
            origen: from,
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

        if (
            !data.precio ||
            isNaN(Number(data.precio)) ||
            Number(data.precio) <= 0
        ) {
            setError('precio', 'Introduce un precio válido superior a 0.');
            tieneErrores = true;
        }

        if (!data.descripcion || data.descripcion.trim() === '') {
            setError('descripcion', 'La descripción es obligatoria.');
            tieneErrores = true;
        }

        if (Number(data.descuento) < 0 || Number(data.descuento) > 100) {
            setError('descuento', 'El descuento debe estar entre 0 y 100.');
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
                                <label className="cn-label">
                                    Precio Base Mensual (€)
                                </label>
                                <Input
                                    type="number"
                                    name="precio"
                                    value={data.precio}
                                    step="0.01"
                                    min="0"
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
                                    Descuento % {esMensual && '(Inactivo)'}
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
                                />
                                {errors.descuento && (
                                    <span className="text-xs text-red-500">
                                        {errors.descuento}
                                    </span>
                                )}
                            </div>
                        </div>

                        {!esMensual && data.precio && (
                            <div className="cn-row">
                                <div
                                    className="cn-field"
                                    style={{ width: '100%' }}
                                >
                                    <div className="rounded border border-blue-200 bg-blue-50 p-3 text-sm text-blue-700">
                                        <p className="mb-1 font-bold">
                                            Cálculo de facturación:
                                        </p>
                                        Subtotal:{' '}
                                        {(
                                            Number(data.precio) *
                                            multiplicadores[data.periodo]
                                        ).toFixed(2)}
                                        € | Con -{data.descuento}% dto:{' '}
                                        <strong>
                                            {(
                                                Number(data.precio) *
                                                multiplicadores[data.periodo] *
                                                (1 - data.descuento / 100)
                                            ).toFixed(2)}
                                            €
                                        </strong>{' '}
                                        por cada {data.periodo}.
                                    </div>
                                </div>
                            </div>
                        )}

                        <hr className="cn-divider" />

                        <div className="cn-field">
                            <label className="cn-label">Características</label>
                            <textarea
                                name="descripcion"
                                rows={5}
                                className="cn-textarea"
                                value={data.descripcion}
                                onChange={(e) =>
                                    setData('descripcion', e.target.value)
                                }
                            />
                            {errors.descripcion && (
                                <span className="text-xs text-red-500">
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
