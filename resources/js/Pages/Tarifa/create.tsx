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
            hora_inicio: '07:00',
            hora_fin: '23:00',
            reservas_semanales: 3,
            descuento: 0,
            centro_id: centros.length > 0 ? centros[0].id : '',
        });

    const esMensual = data.periodo === 'mes';
    const multiplicadores: Record<string, number> = {
        mes: 1,
        trimestre: 3,
        semestre: 6,
        año: 12,
    };

    const handle = (e: React.FormEvent) => {
        e.preventDefault();
        clearErrors();

        let tieneErrores = false;

        if (!data.precio) {
            setError('precio', 'El precio es obligatorio.');
            tieneErrores = true;
        } else if (isNaN(Number(data.precio)) || Number(data.precio) <= 0) {
            setError('precio', 'Introduce un precio numérico superior a 0.');
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

        if (Number(data.reservas_semanales) < 0) {
            setError('reservas_semanales', 'Las reservas no pueden ser negativas.');
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
                            <p className="cn-section-title">Crear Nueva Tarifa</p>
                            <p className="cn-section-subtitle">
                                Define los precios y las restricciones de acceso y reservas.
                            </p>
                        </div>

                        <div className="cn-row">
                            <div className="cn-field">
                                <label className="cn-label">Seleccionar Centro</label>
                                <select
                                    name="centro_id"
                                    className="cn-input"
                                    value={data.centro_id}
                                    onChange={(e) => setData('centro_id', e.target.value)}
                                >
                                    <option value="" disabled>Selecciona un centro...</option>
                                    {centros.map((centro) => (
                                        <option key={centro.id} value={centro.id}>{centro.nombre}</option>
                                    ))}
                                </select>
                                {errors.centro_id && <span className="mt-1 text-xs text-red-500">{errors.centro_id}</span>}
                            </div>

                            <div className="cn-field">
                                <label className="cn-label">Nivel de Tarifa</label>
                                <select
                                    name="tipo"
                                    className="cn-input"
                                    value={data.tipo}
                                    onChange={(e) => setData('tipo', e.target.value)}
                                >
                                    <option value="basica">Básica</option>
                                    <option value="estandar">Estándar</option>
                                    <option value="premium">Premium</option>
                                </select>
                            </div>
                        </div>

                        <div className="cn-row">
                            <div className="cn-field">
                                <label className="cn-label">Precio Base Mensual (€)</label>
                                <Input
                                    type="number"
                                    name="precio"
                                    step="0.01"
                                    value={data.precio}
                                    placeholder="0.00"
                                    onChange={(e) => setData('precio', e.target.value)}
                                    className="cn-input"
                                />
                                {errors.precio && <span className="text-xs text-red-500">{errors.precio}</span>}
                            </div>

                            <div className="cn-field">
                                <label className="cn-label">Periodo de Cobro</label>
                                <select
                                    name="periodo"
                                    className="cn-input"
                                    value={data.periodo}
                                    onChange={(e) => {
                                        const val = e.target.value;
                                        setData({
                                            ...data,
                                            periodo: val,
                                            descuento: val === 'mes' ? 0 : data.descuento,
                                        });
                                    }}
                                >
                                    <option value="mes">Mensual</option>
                                    <option value="trimestre">Trimestral</option>
                                    <option value="semestre">Semestral</option>
                                    <option value="año">Anual</option>
                                </select>
                            </div>

                            <div className="cn-field">
                                <label className="cn-label">Descuento %</label>
                                <Input
                                    type="number"
                                    name="descuento"
                                    value={data.descuento}
                                    min="0"
                                    max="100"
                                    disabled={esMensual}
                                    onChange={(e) => setData('descuento', e.target.value)}
                                    className={`cn-input ${esMensual ? 'bg-gray-100 opacity-50' : ''}`}
                                />
                            </div>
                        </div>

                        {!esMensual && data.precio && (
                            <div className="mb-6 rounded-xl border border-blue-200 bg-blue-50 p-4 text-blue-700">
                                <p className="text-sm">
                                    Pago único cada {data.periodo}: <strong>
                                    {(Number(data.precio) * multiplicadores[data.periodo] * (1 - Number(data.descuento) / 100)).toFixed(2)}€
                                    </strong> (Ahorras {data.descuento}%)
                                </p>
                            </div>
                        )}

                        <hr className="cn-divider" />

                        <div className="cn-section-header">
                            <p className="cn-section-subtitle font-bold text-gray-700">Restricciones de Uso</p>
                        </div>

                        <div className="cn-row">
                            <div className="cn-field">
                                <label className="cn-label">Hora de Inicio (Entrada)</label>
                                <Input
                                    type="time"
                                    name="hora_inicio"
                                    value={data.hora_inicio}
                                    onChange={(e) => setData('hora_inicio', e.target.value)}
                                    className="cn-input"
                                />
                                {errors.hora_inicio && <span className="text-xs text-red-500">{errors.hora_inicio}</span>}
                            </div>

                            <div className="cn-field">
                                <label className="cn-label">Hora de Fin (Salida)</label>
                                <Input
                                    type="time"
                                    name="hora_fin"
                                    value={data.hora_fin}
                                    onChange={(e) => setData('hora_fin', e.target.value)}
                                    className="cn-input"
                                />
                                {errors.hora_fin && <span className="text-xs text-red-500">{errors.hora_fin}</span>}
                            </div>

                            <div className="cn-field">
                                <label className="cn-label">Máx. Reservas Semanales</label>
                                <Input
                                    type="number"
                                    name="reservas_semanales"
                                    value={data.reservas_semanales}
                                    min="0"
                                    onChange={(e) => setData('reservas_semanales', e.target.value)}
                                    className="cn-input"
                                    placeholder="Ej: 5"
                                />
                                {errors.reservas_semanales && <span className="text-xs text-red-500">{errors.reservas_semanales}</span>}
                            </div>
                        </div>

                        <div className="cn-actions mt-8">
                            <Button href={route('tarifas.index')} type="button" className="cn-btn-cancel">
                                Cancelar
                            </Button>
                            <Button type="submit" className="cn-btn-save" disabled={processing}>
                                {processing ? 'Creando...' : 'Crear Tarifa'}
                            </Button>
                        </div>
                    </div>
                </div>
            </form>
        </>
    );
}
