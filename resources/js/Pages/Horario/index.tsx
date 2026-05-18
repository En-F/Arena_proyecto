import React, { useState } from 'react';
import { Head, useForm } from '@inertiajs/react';
import Button from '@/components/Layouts/Button';

interface Horario {
    id: number;
    dia: string;
    hora_inicio: string;
    hora_fin: string;
    estado: boolean;
}

interface Actividad {
    id: number;
    nombre: string;
    curso_id: number;
}

interface Curso {
    id: number;
    nombre: string;
    actividades: Actividad[];
}

interface Centro {
    id: number;
    nombre: string;
    cursos: Curso[];
}

interface Sesion {
    id: number;
    centro_id: number;
    curso_id: number;
    actividad_id: string;
    horario_id: number;
    fecha: string;
    cantidad: number;
}

interface Props {
    horarios: Horario[];
    centros: Centro[];
    sesiones: Sesion[];
}

export default function AdminHorarioIndex({
    horarios,
    centros = [],
    sesiones = [],
}: Props) {
    const [activeTab, setActiveTab] = useState('ver');

    const formHorario = useForm({
        dia: '',
        hora_inicio: '',
        hora_fin: '',
    });

    const formSesion = useForm({
        centro_id: '',
        curso_id: '',
        actividad_id: '',
        fecha: '',
        horario_id: '',
        instructor: '',
        cantidad: 0,
    });

    const centroSeleccionado = centros.find(
        (c) => String(c.id) === formSesion.data.centro_id,
    );
    const cursosDisponibles = centroSeleccionado?.cursos || [];

    const cursoSeleccionado = cursosDisponibles.find(
        (cur) => String(cur.id) === formSesion.data.curso_id,
    );
    const actividadesDisponibles = cursoSeleccionado?.actividades || [];

    const obtenerNombreDia = (fechaStr: string) => {
        if (!fechaStr) return '';
        const dias = [
            'domingo',
            'lunes',
            'martes',
            'miercoles',
            'jueves',
            'viernes',
            'sabado',
        ];

        const [year, month, day] = fechaStr.split('-').map(Number);
        const fecha = new Date(year, month - 1, day);
        return dias[fecha.getDay()];
    };

    const diaDeLaFechaSelected = obtenerNombreDia(formSesion.data.fecha);

    const horariosDisponiblesParaEseDia = horarios.filter(
        (h) => h.dia.toLowerCase() === diaDeLaFechaSelected,
    );

    const handleDeleteHorario = (id: number) => {
        if (
            confirm(
                '¿Estás seguro de que deseas eliminar este bloque de horario? Esta acción no se puede deshacer.',
            )
        ) {
            formHorario.delete(route('horarios.destroy', id), {});
        }
    };

    const handleHorarioSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        formHorario.clearErrors();

        let tieneErrores = false;
        if (!formHorario.data.dia) {
            formHorario.setError('dia', 'El día es obligatorio.');
            tieneErrores = true;
        }
        if (!formHorario.data.hora_inicio) {
            formHorario.setError(
                'hora_inicio',
                'La hora de inicio es obligatoria.',
            );
            tieneErrores = true;
        }
        if (!formHorario.data.hora_fin) {
            formHorario.setError('hora_fin', 'La hora de fin es obligatoria.');
            tieneErrores = true;
        }

        if (formHorario.data.hora_inicio && formHorario.data.hora_fin) {
            if (formHorario.data.hora_fin <= formHorario.data.hora_inicio) {
                formHorario.setError(
                    'hora_fin',
                    'La hora de fin debe ser posterior a la hora de inicio.',
                );
                tieneErrores = true;
            }
        }

        if (tieneErrores) return;
        formHorario.post(route('horarios.store'), {
            onSuccess: () => {
                formHorario.reset();
                setActiveTab('ver');
            },
        });
    };

    const handleSesionSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        formSesion.clearErrors();

        let tieneErrores = false;
        if (!formSesion.data.centro_id) {
            formSesion.setError('centro_id', 'El centro es obligatorio.');
            tieneErrores = true;
        }
        if (!formSesion.data.curso_id) {
            formSesion.setError('curso_id', 'El curso es obligatorio.');
            tieneErrores = true;
        }
        if (!formSesion.data.actividad_id) {
            formSesion.setError('actividad_id', 'La actividad es obligatoria.');
            tieneErrores = true;
        }
        if (!formSesion.data.horario_id) {
            formSesion.setError('horario_id', 'El horario es obligatorio.');
            tieneErrores = true;
        }

        if (!formSesion.data.cantidad || formSesion.data.cantidad <= 0) {
            formSesion.setError('cantidad', 'La cantidad debe ser al menos 1.');
            tieneErrores = true;
        }

        if (tieneErrores) return;

        formSesion.post(route('sesiones.store'), {
            onSuccess: () => {
                formSesion.reset();
                setActiveTab('ver_sesiones');
            },
        });
    };

    return (
        <div className="min-h-screen bg-gray-50 py-12">
            <Head title="Gestión de Horarios y Sesiones" />

            <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div className="overflow-hidden border border-gray-200 bg-white p-6 shadow-xl sm:rounded-lg">
                    <div className="mb-8 flex flex-col items-center justify-between gap-4 md:flex-row">
                        <h1 className="text-3xl font-extrabold text-gray-900">
                            Panel de Control: Horarios
                        </h1>
                        <div className="flex flex-wrap rounded-lg bg-gray-200 p-1">
                            <Button
                                onClick={() => setActiveTab('ver')}
                                className={`rounded-md px-4 py-2 text-sm font-medium transition-all ${activeTab === 'ver' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'}`}
                            >
                                Bloques de Horario
                            </Button>
                            <Button
                                onClick={() => setActiveTab('ver_sesiones')}
                                className={`rounded-md px-4 py-2 text-sm font-medium transition-all ${activeTab === 'ver_sesiones' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'}`}
                            >
                                Sesiones Activas
                            </Button>
                            <Button
                                onClick={() => setActiveTab('crear')}
                                className={`rounded-md px-4 py-2 text-sm font-medium transition-all ${activeTab === 'crear' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'}`}
                            >
                                + Horario
                            </Button>
                            <Button
                                onClick={() => setActiveTab('crear_sesion')}
                                className={`rounded-md px-4 py-2 text-sm font-medium transition-all ${activeTab === 'crear_sesion' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'}`}
                            >
                                + Sesión
                            </Button>
                            <Button
                                onClick={() => setActiveTab('reservas')}
                                className={`rounded-md px-4 py-2 text-sm font-medium transition-all ${activeTab === 'reservas' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'}`}
                            >
                                Reservas
                            </Button>
                        </div>
                    </div>

                    <hr className="mb-8" />

                    {activeTab === 'ver' && (
                        <div>
                            <h2 className="mb-6 text-xl font-bold text-gray-800">
                                Horarios
                            </h2>
                            <div className="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                                {horarios.map((horario) => (
                                    <div
                                        key={horario.id}
                                        className="relative rounded-xl border-2 border-gray-100 bg-white p-5 shadow-sm transition-all hover:border-gray-200"
                                    >
                                        <div className="flex items-center justify-between">
                                            <span className="rounded-md bg-blue-50 px-2.5 py-1 text-xs font-black tracking-wider text-blue-700 uppercase">
                                                {horario.dia}
                                            </span>
                                            {horario.estado ? (
                                                <span className="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-0.5 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset">
                                                    <span className="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                                    Activo
                                                </span>
                                            ) : (
                                                <span className="inline-flex items-center gap-1 rounded-full bg-red-50 px-2 py-0.5 text-xs font-medium text-red-700 ring-1 ring-red-600/20 ring-inset">
                                                    <span className="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                                    Inactivo
                                                </span>
                                            )}
                                        </div>

                                        <div className="mt-4 text-sm font-semibold text-gray-700">
                                            🕒{' '}
                                            {horario.hora_inicio
                                                .split(':')
                                                .slice(0, 2)
                                                .join(':')}{' '}
                                            -{' '}
                                            {horario.hora_fin
                                                .split(':')
                                                .slice(0, 2)
                                                .join(':')}
                                        </div>

                                        <div className="minimum-h-[32px] mt-4 flex justify-end border-t border-gray-100 pt-3">
                                            {!horario.estado && (
                                                <Button
                                                    onClick={() =>
                                                        handleDeleteHorario(
                                                            horario.id,
                                                        )
                                                    }
                                                    disabled={
                                                        formHorario.processing
                                                    }
                                                    className="inline-flex items-center gap-1 text-xs font-bold text-red-600 transition-colors hover:text-red-800 disabled:opacity-50"
                                                >
                                                    Eliminar
                                                </Button>
                                            )}
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    )}

                    {activeTab === 'ver_sesiones' && (
                        <div>
                            <h2 className="mb-6 text-xl font-bold text-gray-800">
                                Reservas Planificadas
                            </h2>
                            <div className="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                                {sesiones.map((sesion) => (
                                    <div
                                        key={sesion.id}
                                        className="rounded-xl border-2 border-purple-100 bg-white p-5 shadow-sm"
                                    >
                                        <div className="mb-2 flex items-center justify-between">
                                            <span className="rounded-md bg-purple-50 px-2.5 py-1 text-xs font-black tracking-wider text-purple-700 uppercase">
                                                {sesion.dia}
                                            </span>
                                            <span className="text-xs font-semibold text-gray-500">
                                                🕒 {sesion.hora}
                                            </span>
                                        </div>
                                        <h3 className="mt-2 text-xl font-bold text-gray-900">
                                            {sesion.actividad}
                                        </h3>
                                    </div>
                                ))}
                            </div>
                        </div>
                    )}

                    {activeTab === 'crear' && (
                        <div className="mx-auto max-w-md rounded-2xl border border-gray-200 bg-gray-50 p-8">
                            <h2 className="mb-2 text-xl font-bold text-gray-900">
                                Crear Bloque Horario
                            </h2>
                            <form
                                onSubmit={handleHorarioSubmit}
                                className="space-y-5"
                            >
                                <div>
                                    <label className="mb-1 block text-sm font-semibold text-gray-700">
                                        Día de la Semana
                                    </label>
                                    <select
                                        value={formHorario.data.dia}
                                        onChange={(e) =>
                                            formHorario.setData(
                                                'dia',
                                                e.target.value,
                                            )
                                        }
                                        className="w-full rounded-lg border-gray-300 p-3 shadow-sm focus:border-blue-500"
                                    >
                                        <option value="">
                                            Selecciona un día
                                        </option>
                                        <option value="lunes">Lunes</option>
                                        <option value="martes">Martes</option>
                                        <option value="miercoles">
                                            Miércoles
                                        </option>
                                        <option value="jueves">Jueves</option>
                                        <option value="viernes">Viernes</option>
                                    </select>
                                    {formHorario.errors.dia && (
                                        <p className="mt-1 text-xs font-medium text-red-600">
                                            {formHorario.errors.dia}
                                        </p>
                                    )}
                                </div>
                                <div className="grid grid-cols-2 gap-4">
                                    <div>
                                        <label className="mb-1 block text-sm font-semibold text-gray-700">
                                            Hora Inicio
                                        </label>
                                        <input
                                            type="time"
                                            value={formHorario.data.hora_inicio}
                                            onChange={(e) =>
                                                formHorario.setData(
                                                    'hora_inicio',
                                                    e.target.value,
                                                )
                                            }
                                            className="w-full rounded-lg border-gray-300 p-3 shadow-sm"
                                        />
                                        {formHorario.errors.hora_inicio && (
                                            <p className="mt-1 text-xs font-medium text-red-600">
                                                {formHorario.errors.hora_inicio}
                                            </p>
                                        )}
                                    </div>
                                    <div>
                                        <label className="mb-1 block text-sm font-semibold text-gray-700">
                                            Hora Fin
                                        </label>
                                        <input
                                            type="time"
                                            value={formHorario.data.hora_fin}
                                            onChange={(e) =>
                                                formHorario.setData(
                                                    'hora_fin',
                                                    e.target.value,
                                                )
                                            }
                                            className="w-full rounded-lg border-gray-300 p-3 shadow-sm"
                                        />
                                        {formHorario.errors.hora_fin && (
                                            <p className="mt-1 text-xs font-medium text-red-600">
                                                {formHorario.errors.hora_fin}
                                            </p>
                                        )}
                                    </div>
                                </div>
                                <div className="flex justify-end gap-4 border-t border-gray-200 pt-4">
                                    <Button
                                        type="submit"
                                        className="rounded-lg bg-blue-600 px-6 py-2 font-bold text-white hover:bg-blue-700"
                                    >
                                        Guardar Horario
                                    </Button>
                                </div>
                            </form>
                        </div>
                    )}

                    {activeTab === 'crear_sesion' && (
                        <div className="mx-auto max-w-md rounded-2xl border border-gray-200 bg-gray-50 p-8">
                            <h2 className="mb-2 text-xl font-bold text-gray-900">
                                Asignar Nueva Sesión
                            </h2>
                            <p className="mb-6 text-sm text-gray-500">
                                Crear Sesión para que los usuarios puedan
                                reservar.
                            </p>

                            <form
                                onSubmit={handleSesionSubmit}
                                className="space-y-5"
                            >
                                <div>
                                    <label className="mb-1 block text-sm font-semibold text-gray-700">
                                        Centro Deportivo
                                    </label>
                                    <select
                                        value={formSesion.data.centro_id}
                                        onChange={(e) => {
                                            formSesion.setData((oldData) => ({
                                                ...oldData,
                                                centro_id: e.target.value,
                                                curso_id: '',
                                                actividad_id: '',
                                            }));
                                        }}
                                        className="w-full rounded-lg border-gray-300 p-3 shadow-sm focus:border-purple-500"
                                    >
                                        <option value="">
                                            Selecciona un centro
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
                                </div>

                                <div>
                                    <label className="mb-1 block text-sm font-semibold text-gray-700">
                                        Curso
                                    </label>
                                    <select
                                        value={formSesion.data.curso_id}
                                        disabled={!formSesion.data.centro_id}
                                        onChange={(e) => {
                                            formSesion.setData((oldData) => ({
                                                ...oldData,
                                                curso_id: e.target.value,
                                                actividad_id: '',
                                            }));
                                        }}
                                        className={`w-full rounded-lg p-3 shadow-sm focus:border-purple-500 ${!formSesion.data.centro_id ? 'cursor-not-allowed border-gray-300 bg-gray-200' : 'border-gray-300'}`}
                                    >
                                        <option value="">
                                            {!formSesion.data.centro_id
                                                ? 'Primero selecciona un centro'
                                                : 'Selecciona un curso'}
                                        </option>
                                        {cursosDisponibles.map((curso) => (
                                            <option
                                                key={curso.id}
                                                value={curso.id}
                                            >
                                                {curso.nombre}
                                            </option>
                                        ))}
                                    </select>
                                </div>

                                <div>
                                    <label className="mb-1 block text-sm font-semibold text-gray-700">
                                        Actividad
                                    </label>
                                    <select
                                        value={formSesion.data.actividad_id}
                                        disabled={!formSesion.data.curso_id}
                                        onChange={(e) =>
                                            formSesion.setData(
                                                'actividad_id',
                                                e.target.value,
                                            )
                                        }
                                        className={`w-full rounded-lg p-3 shadow-sm focus:border-purple-500 ${!formSesion.data.curso_id ? 'cursor-not-allowed border-gray-300 bg-gray-200' : 'border-gray-300'}`}
                                    >
                                        <option value="">
                                            {!formSesion.data.curso_id
                                                ? 'Primero selecciona un curso'
                                                : 'Selecciona una actividad'}
                                        </option>
                                        {actividadesDisponibles.map((act) => (
                                            <option key={act.id} value={act.id}>
                                                {act.nombre}
                                            </option>
                                        ))}
                                    </select>
                                </div>
                                <div>
                                    <label className="mb-1 block text-sm font-semibold text-gray-700">
                                        Fecha de la Sesión
                                    </label>
                                    <input
                                        type="date"
                                        value={formSesion.data.fecha}
                                        onChange={(e) =>
                                            formSesion.setData(
                                                'fecha',
                                                e.target.value,
                                            )
                                        }
                                        className="w-full rounded-lg border-gray-300 p-3 shadow-sm focus:border-purple-500"
                                    />
                                    {formSesion.errors.fecha && (
                                        <p className="mt-1 text-xs text-red-500">
                                            {formSesion.errors.fecha}
                                        </p>
                                    )}
                                </div>

                                <div>
                                    <label className="mb-1 block text-sm font-semibold text-gray-700">
                                        Bloque de Horario Disponible
                                    </label>
                                    <select
                                        value={formSesion.data.horario_id}
                                        disabled={!formSesion.data.fecha}
                                        onChange={(e) =>
                                            formSesion.setData(
                                                'horario_id',
                                                e.target.value,
                                            )
                                        }
                                        className={`w-full rounded-lg p-3 shadow-sm focus:border-purple-500 ${
                                            !formSesion.data.fecha
                                                ? 'cursor-not-allowed border-gray-300 bg-gray-200'
                                                : 'border-gray-300 bg-white'
                                        }`}
                                    >
                                        <option value="">
                                            {!formSesion.data.fecha
                                                ? 'Primero selecciona una fecha'
                                                : 'Selecciona un bloque para este día'}
                                        </option>

                                        {horariosDisponiblesParaEseDia.map(
                                            (hora) => (
                                                <option
                                                    key={hora.id}
                                                    value={hora.id}
                                                >
                                                    {hora.dia.toUpperCase()} (
                                                    {hora.hora_inicio.slice(
                                                        0,
                                                        5,
                                                    )}{' '}
                                                    -{' '}
                                                    {hora.hora_fin.slice(0, 5)})
                                                </option>
                                            ),
                                        )}
                                    </select>
                                    {formSesion.errors.horario_id && (
                                        <p className="mt-1 text-xs text-red-500">
                                            {formSesion.errors.horario_id}
                                        </p>
                                    )}
                                </div>
                                <div>
                                    <label className="mb-1 block text-sm font-semibold text-gray-700">
                                        Cantidad
                                    </label>
                                    <input
                                        type="number"
                                        min="1"
                                        value={formSesion.data.cantidad}
                                        onChange={(e) =>
                                            formSesion.setData(
                                                'cantidad',
                                                parseInt(e.target.value) || 0,
                                            )
                                        }
                                        className={`w-full rounded-lg border-gray-300 p-3 shadow-sm focus:border-purple-500 ${formSesion.errors.cantidad ? 'border-red-500' : ''}`}
                                    />
                                    {formSesion.errors.cantidad && (
                                        <span className="mt-1 block text-xs text-red-500">
                                            {formSesion.errors.cantidad}
                                        </span>
                                    )}
                                </div>

                                <div className="flex justify-end gap-4 border-t border-gray-200 pt-4">
                                    <Button
                                        type="button"
                                        onClick={() =>
                                            setActiveTab('ver_sesiones')
                                        }
                                        className="text-sm font-medium text-gray-600 hover:text-gray-900"
                                    >
                                        Cancelar
                                    </Button>
                                    <Button
                                        type="submit"
                                        disabled={formSesion.processing}
                                        className="rounded-lg bg-blue-600 px-6 py-2 font-bold text-white hover:bg-blue-400 disabled:opacity-50"
                                    >
                                        {formSesion.processing
                                            ? 'Enviando...'
                                            : 'Crear Sesión'}
                                    </Button>
                                </div>
                            </form>
                        </div>
                    )}

                    {activeTab === 'reservas' && (
                        <div className="overflow-x-auto">
                            <p className="text-sm text-gray-500">
                                Mostrando el listado de reservas activas...
                            </p>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}
