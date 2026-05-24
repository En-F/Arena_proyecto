import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';
import '../../../css/noticia/formulario.css';
import { Input } from '@/components/ui/input';
import Button from '@/components/Layouts/Button';
import React from 'react';
import DatePicker, { registerLocale } from 'react-datepicker';
import 'react-datepicker/dist/react-datepicker.css';
import '../../../css/horario.css';
import { es } from 'date-fns/locale/es';

interface Actividad {
    id: number;
    nombre: string;
    curso_id?: number;
    cursos?: any[];
}
interface Curso {
    id: number;
    nombre: string;
    centro_id?: number;
    centros?: any[];
}
interface Centro {
    id: number;
    nombre: string;
}
interface Horario {
    id: number;
    dia: string;
    hora_inicio: string;
    hora_fin: string;
}

interface Sesion {
    id: number;
    centro_id: number;
    curso_id: number;
    actividad_id: number;
    horario_id: number;
    fecha: string;
    capacidad: number;
    centro?: Centro;
    curso?: Curso;
    actividad?: Actividad;
    horario?: Horario;
}

interface Props {
    sesion: Sesion;
    centros: Centro[];
    cursos: Curso[];
    actividades: Actividad[];
    horarios: Horario[];
}

export default function Edit({
    sesion,
    centros,
    cursos,
    actividades,
    horarios,
}: Props) {
    const { data, setData, post, processing, errors, setError, clearErrors } =
        useForm({
            centro_id: sesion.centro_id || sesion.centro?.id || '',
            curso_id: sesion.curso_id || sesion.curso?.id || '',
            actividad_id: sesion.actividad_id || sesion.actividad?.id || '',
            horario_id: sesion.horario_id || sesion.horario?.id || '',
            fecha: sesion.fecha || '',
            capacidad: sesion.capacidad || 1,
            _method: 'PUT',
        });

    const cursosDisponibles = cursos.filter((c: any) => {
        if (c.centro_id) return Number(c.centro_id) === Number(data.centro_id);
        return c.centros?.some(
            (centro: any) => Number(centro.id) === Number(data.centro_id),
        );
    });

    const actividadesDisponibles = actividades.filter((a: any) => {
        if (a.curso_id) return Number(a.curso_id) === Number(data.curso_id);
        return a.cursos?.some(
            (curso: any) => Number(curso.id) === Number(data.curso_id),
        );
    });

    const diasSemana = [
        'domingo',
        'lunes',
        'martes',
        'miercoles',
        'jueves',
        'viernes',
        'sabado',
    ];
    const nombreDia = data.fecha
        ? diasSemana[new Date(data.fecha + 'T00:00:00').getDay()]
        : null;
    const horariosFiltrados = horarios.filter(
        (h) => h.dia.toLowerCase() === nombreDia,
    );

    const handle = (e: React.FormEvent) => {
        e.preventDefault();
        clearErrors();
        const ahora = new Date();
        const hoyStr = ahora.toISOString().split('T')[0];
        const horaActualStr =
            ahora.getHours().toString().padStart(2, '0') +
            ':' +
            ahora.getMinutes().toString().padStart(2, '0');

        let tieneErrores = false;

        if (!data.centro_id) {
            setError('centro_id', 'El centro es obligatorio.');
            tieneErrores = true;
        }
        if (!data.curso_id) {
            setError('curso_id', 'El curso es obligatorio.');
            tieneErrores = true;
        }
        if (!data.actividad_id) {
            setError('actividad_id', 'La actividad es obligatoria.');
            tieneErrores = true;
        }
        if (!data.fecha) {
            setError('fecha', 'La fecha es obligatoria.');
            tieneErrores = true;
        } else {
            if (data.fecha < sesion.fecha) {
                setError(
                    'fecha',
                    `La nueva fecha no puede ser anterior a la original (${sesion.fecha}).`,
                );
                tieneErrores = true;
            }
            if (data.fecha < hoyStr) {
                setError('fecha', 'No puedes mover una sesión al pasado.');
                tieneErrores = true;
            }
        }

        if (!data.horario_id) {
            setError('horario_id', 'El horario es obligatorio.');
            tieneErrores = true;
        } else {
            const horarioSeleccionado = horarios.find(
                (h) => Number(h.id) === Number(data.horario_id),
            );
            const horarioOriginal = horarios.find(
                (h) => Number(h.id) === Number(sesion.horario_id),
            );

            if (horarioSeleccionado) {
                if (
                    data.fecha === hoyStr &&
                    horarioSeleccionado.hora_inicio < horaActualStr
                ) {
                    setError(
                        'horario_id',
                        'Este bloque horario ya ha pasado para el día de hoy.',
                    );
                    tieneErrores = true;
                }

                if (data.fecha === sesion.fecha && horarioOriginal) {
                    if (
                        horarioSeleccionado.hora_inicio <
                        horarioOriginal.hora_inicio
                    ) {
                        setError(
                            'horario_id',
                            `En el mismo día, no puedes adelantar la hora de la sesión (Mínimo: ${horarioOriginal.hora_inicio.slice(0, 5)}).`,
                        );
                        tieneErrores = true;
                    }
                }
            }
        }
        if (Number(data.capacidad) < Number(sesion.capacidad)) {
            setError(
                'capacidad',
                `No puedes reducir la capacidad. El mínimo permitido es ${sesion.capacidad} (capacidad actual).`,
            );
            tieneErrores = true;
        }

        if (tieneErrores) return;

        post(route('sesiones.update', sesion.id), { forceFormData: true });
    };

    return (
        <form onSubmit={handle}>
            <div className="cn-page">
                <div className="cn-wrap">
                    <div className="cn-section-header">
                        <p className="cn-section-title">
                            Actualizar Sesión Deportiva
                        </p>
                        <p className="cn-section-subtitle">
                            Modifica los detalles de la sesión. Asegúrate de que
                            los horarios y capacidades sean correctos.
                        </p>
                    </div>

                    <div className="cn-field">
                        <label className="cn-label">Centro Deportivo</label>
                        <select
                            className="cn-input"
                            value={data.centro_id}
                            onChange={(e) =>
                                setData((prev) => ({
                                    ...prev,
                                    centro_id: Number(e.target.value),
                                    curso_id: '',
                                    actividad_id: '',
                                }))
                            }
                        >
                            <option value="">Seleccionar centro</option>
                            {centros.map((c) => (
                                <option key={c.id} value={c.id}>
                                    {c.nombre}
                                </option>
                            ))}
                        </select>
                        {errors.centro_id && (
                            <span className="mt-1 text-xs text-red-500">
                                {errors.centro_id}
                            </span>
                        )}
                    </div>

                    <div className="cn-row">
                        <div className="cn-field">
                            <label className="cn-label">Curso</label>
                            <select
                                className="cn-input"
                                value={data.curso_id}
                                disabled={!data.centro_id}
                                onChange={(e) =>
                                    setData((prev) => ({
                                        ...prev,
                                        curso_id: Number(e.target.value),
                                        actividad_id: '',
                                    }))
                                }
                            >
                                <option value="">Seleccionar curso</option>
                                {cursosDisponibles.map((cur) => (
                                    <option key={cur.id} value={cur.id}>
                                        {cur.nombre}
                                    </option>
                                ))}
                            </select>
                            {errors.curso_id && (
                                <span className="mt-1 text-xs text-red-500">
                                    {errors.curso_id}
                                </span>
                            )}
                        </div>

                        <div className="cn-field">
                            <label className="cn-label">Actividad</label>
                            <select
                                className="cn-input"
                                value={data.actividad_id}
                                disabled={!data.curso_id}
                                onChange={(e) =>
                                    setData(
                                        'actividad_id',
                                        Number(e.target.value),
                                    )
                                }
                            >
                                <option value="">Seleccionar actividad</option>
                                {actividadesDisponibles.map((act) => (
                                    <option key={act.id} value={act.id}>
                                        {act.nombre}
                                    </option>
                                ))}
                            </select>
                            {errors.actividad_id && (
                                <span className="mt-1 text-xs text-red-500">
                                    {errors.actividad_id}
                                </span>
                            )}
                        </div>
                    </div>

                    <hr className="cn-divider" />

                    <div className="cn-row">
                        <div className="cn-field">
                            <label className="cn-label">
                                Fecha de la sesión
                            </label>
                            <DatePicker
                                selected={
                                    data.fecha ? new Date(data.fecha) : null
                                }
                                onChange={(date: Date) => {
                                    const y = date.getFullYear();
                                    const m = String(
                                        date.getMonth() + 1,
                                    ).padStart(2, '0');
                                    const d = String(date.getDate()).padStart(
                                        2,
                                        '0',
                                    );
                                    setData('fecha', `${y}-${m}-${d}`);
                                }}
                                locale="es"
                                dateFormat="dd/MM/yyyy"
                                minDate={new Date(sesion.fecha)}
                                className={`cn-input w-full ${errors.fecha ? 'border-red-600 ring-1 ring-red-600' : ''}`}
                            />
                            {errors.fecha && (
                                <p className="mt-1 text-xs font-medium text-red-600">
                                    {errors.fecha}
                                </p>
                            )}
                        </div>

                        <div className="cn-field">
                            <label className="cn-label">Bloque Horario</label>
                            <select
                                value={data.horario_id}
                                onChange={(e) =>
                                    setData('horario_id', e.target.value)
                                }
                                className={`cn-input w-full ${errors.horario_id ? 'border-red-600 ring-1 ring-red-600' : ''}`}
                            >
                                <option value="">Selecciona horario</option>
                                {horariosFiltrados.map((h) => (
                                    <option key={h.id} value={h.id}>
                                        {h.dia.toUpperCase()} (
                                        {h.hora_inicio.slice(0, 5)} -{' '}
                                        {h.hora_fin.slice(0, 5)})
                                    </option>
                                ))}
                            </select>
                            {errors.horario_id && (
                                <p className="mt-1 text-xs font-medium text-red-600">
                                    {errors.horario_id}
                                </p>
                            )}
                        </div>
                    </div>

                    <div className="cn-field">
                        <label className="cn-label">Capacidad de plazas</label>
                        <Input
                            type="number"
                            className="cn-input"
                            value={data.capacidad}
                            onChange={(e) =>
                                setData('capacidad', Number(e.target.value))
                            }
                        />
                        {errors.capacidad && (
                            <span className="mt-1 text-xs text-red-500">
                                {errors.capacidad}
                            </span>
                        )}
                    </div>

                    <div className="cn-actions">
                        <Button
                            href={route('reservas.index')}
                            type="button"
                            className="cn-btn-cancel"
                        >
                            Cancelar
                        </Button>
                        <Button type="submit" className="cn-btn-save">
                            {processing ? 'Actualizando...' : 'Guardar Cambios'}
                        </Button>
                    </div>
                </div>
            </div>
        </form>
    );
}
