import React, { useState } from 'react';
import { Head, router, usePage } from '@inertiajs/react';
import { ChevronLeft, ChevronRight, Clock, MapPin, Users } from 'lucide-react';
import DatePicker, { registerLocale } from 'react-datepicker';
import 'react-datepicker/dist/react-datepicker.css';
import { es } from 'date-fns/locale/es';
registerLocale('es', es);

interface Actividad {
    id: number;
    nombre: string;
    descripcion?: string;
    imagen?: string;
}

interface Horario {
    id: number;
    dia: string;
    hora_inicio: string;
    hora_fin: string;
}

interface Centro {
    id: number;
    nombre: string;
    direccion?: string;
}

interface Curso {
    id: number;
    nombre: string;
}

interface Sesion {
    id: number;
    fecha: string;
    capacidad: number;
    centro_id: number;
    curso_id?: number;
    actividad: Actividad;
    horario: Horario;
    centro: Centro;
    curso?: Curso;
    reservas_count: number;
}

interface SesionesAgrupadas {
    [key: string]: Sesion[];
}

interface Props {
    sesionesAgrupadas: SesionesAgrupadas;
    centros: Centro[];
    cursos: Curso[];
    centroSeleccionado: number | null;
    cursoSeleccionado: number | null;
    esAdmin: boolean;
}

export default function Index({
    sesionesAgrupadas,
    centros,
    cursos,
    centroSeleccionado,
    cursoSeleccionado,
}: Props) {
    const [fechaReferencia, setFechaReferencia] = useState(new Date());
    const { auth } = usePage().props as any;
    const is_admin = auth.user?.is_admin || false;
    const is_jefe = auth.user?.is_jefe || false;

    const obtenerDiasSemana = (ref: Date) => {
        const dias = [];
        const actual = new Date(ref);

        const diaSemana = actual.getDay();
        const difereciaDia =
            actual.getDate() - diaSemana + (diaSemana === 0 ? -6 : 1);
        actual.setDate(difereciaDia);

        for (let i = 0; i < 5; i++) {
            const dia = new Date(actual);
            dia.setDate(actual.getDate() + i);

            const año = dia.getFullYear();
            const mes = String(dia.getMonth() + 1).padStart(2, '0');
            const diaMes = String(dia.getDate()).padStart(2, '0');
            const fechaSql = `${año}-${mes}-${diaMes}`;

            dias.push({
                nombre: dia.toLocaleDateString('es-ES', { weekday: 'long' }),
                numero: dia.getDate(),
                mes: dia.toLocaleDateString('es-ES', { month: 'short' }),
                fechaSql: fechaSql,
            });
        }
        return dias;
    };

    const diasSemana = obtenerDiasSemana(fechaReferencia);

    const irSemanaSiguiente = () => {
        const nuevaFecha = new Date(fechaReferencia);
        nuevaFecha.setDate(fechaReferencia.getDate() + 7);
        setFechaReferencia(nuevaFecha);
    };

    const irSemanaAnterior = () => {
        const nuevaFecha = new Date(fechaReferencia);
        nuevaFecha.setDate(fechaReferencia.getDate() - 7);
        setFechaReferencia(nuevaFecha);
    };

    const handleCentroChange = (e) => {
        const id = e.target.value;
        router.get(
            route('reservas.index'),
            { centro_id: id },
            { preserveState: true },
        );
    };

    const handleCursoChange = (e) => {
        const id = e.target.value;
        router.get(
            route('reservas.index'),
            {
                centro_id: centroSeleccionado,
                curso_id: id,
            },
            { preserveState: true },
        );
    };

    return (
        <div className="min-h-screen bg-gray-50 p-4 md:p-8">
            <Head title="Reservas de Sesiones" />

            <div className="mx-auto mb-10 max-w-7xl">
                <h1 className="mb-6 text-center text-3xl font-black tracking-tighter text-gray-900 uppercase">
                    Horario de Actividades
                </h1>

                <div className="flex flex-wrap justify-center gap-4 rounded-2xl p-4">
                    <div className="flex flex-col">
                        <label className="text-black-400 ml-1 text-[17px] font-bold uppercase">
                            Centro Deportivo
                        </label>
                        <select
                            value={centroSeleccionado || ''}
                            onChange={handleCentroChange}
                            className="rounded-xl border-none bg-gray-50 p-3 text-sm font-medium focus:ring-2 focus:ring-blue-500"
                        >
                            {centros.map((c) => (
                                <option key={c.id} value={c.id}>
                                    {c.nombre}
                                </option>
                            ))}
                        </select>
                    </div>

                    <div className="flex flex-col">
                        <label className="text-black-400 ml-1 text-[17px] font-bold uppercase">
                            Curso / Nivel
                        </label>
                        <select
                            value={cursoSeleccionado || ''}
                            onChange={handleCursoChange}
                            className="rounded-xl border-none bg-gray-50 p-3 text-sm text-[17px] font-medium focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="">Todos los cursos</option>
                            {cursos.map((cur) => (
                                <option key={cur.id} value={cur.id}>
                                    {cur.nombre}
                                </option>
                            ))}
                        </select>
                    </div>
                </div>
            </div>

            <div className="mx-auto mb-6 flex max-w-7xl items-center justify-between rounded-2xl bg-blue-600 p-4 text-white shadow-lg">
                <button
                    onClick={irSemanaAnterior}
                    className="rounded-full p-2 transition hover:bg-blue-500"
                >
                    <ChevronLeft size={28} />
                </button>

                <div className="text-center">
                    <p className="text-xl font-bold uppercase opacity-80">
                        Semana actual — {fechaReferencia.getFullYear()}
                    </p>

                    <h2 className="text-lg font-black">
                        {diasSemana[0].numero} {diasSemana[0].mes} —{' '}
                        {diasSemana[4].numero} {diasSemana[4].mes}
                    </h2>
                </div>

                <button
                    onClick={irSemanaSiguiente}
                    className="rounded-full p-2 transition hover:bg-blue-500"
                >
                    <ChevronRight size={28} />
                </button>
            </div>

            <div className="mx-auto grid max-w-7xl grid-cols-1 gap-6 md:grid-cols-5">
                {diasSemana.map((dia) => (
                    <div key={dia.fechaSql} className="space-y-4">
                        <div className="rounded-xl border-b-4 border-blue-400 bg-white p-3 text-center shadow-sm">
                            <h3 className="text-sm font-black text-gray-800 uppercase">
                                {dia.nombre}
                            </h3>
                            <p className="text-xs font-bold text-gray-400">
                                {dia.numero} {dia.mes}
                            </p>
                        </div>

                        <div className="flex flex-col gap-4">
                            {sesionesAgrupadas[dia.fechaSql]?.length > 0 ? (
                                sesionesAgrupadas[dia.fechaSql].map(
                                    (sesion) => {
                                        const disponibles =
                                            sesion.capacidad -
                                            sesion.reservas_count;
                                        const estaLleno = disponibles <= 0;

                                        return (
                                            <div
                                                key={sesion.id}
                                                className="group rounded-3xl border border-gray-100 bg-white p-5 shadow-sm transition-all hover:shadow-xl"
                                            >
                                                <div className="mb-3 flex items-start justify-between">
                                                    <h4 className="text-lg leading-tight font-black text-gray-800 uppercase transition-colors group-hover:text-blue-600">
                                                        {
                                                            sesion.actividad
                                                                .nombre
                                                        }
                                                    </h4>
                                                </div>

                                                <div className="mb-4 inline-block rounded-md bg-blue-50 px-2 py-1 text-[10px] font-bold text-blue-700">
                                                    CURSO:{' '}
                                                    {sesion.curso?.nombre ||
                                                        'Abierto'}
                                                </div>

                                                <div className="mb-5 space-y-2">
                                                    <div className="flex items-center gap-2 text-xs font-medium text-gray-500">
                                                        <Clock
                                                            size={14}
                                                            className="text-blue-400"
                                                        />
                                                        {sesion.horario.hora_inicio.slice(
                                                            0,
                                                            5,
                                                        )}{' '}
                                                        -{' '}
                                                        {sesion.horario.hora_fin.slice(
                                                            0,
                                                            5,
                                                        )}
                                                    </div>
                                                    <div className="flex items-center gap-2 text-xs font-medium text-gray-500">
                                                        <MapPin
                                                            size={14}
                                                            className="text-blue-400"
                                                        />
                                                        {sesion.centro.nombre}
                                                    </div>
                                                    <div className="flex items-center gap-2 text-xs font-medium text-gray-500">
                                                        <Users
                                                            size={14}
                                                            className="text-blue-400"
                                                        />
                                                        {sesion.reservas_count}{' '}
                                                        / {sesion.capacidad}{' '}
                                                        inscritos
                                                    </div>
                                                </div>

                                                <div
                                                    className={`mb-3 rounded-xl py-1.5 text-center text-[10px] font-black ${
                                                        estaLleno
                                                            ? 'bg-red-50 text-red-500'
                                                            : 'bg-green-50 text-green-600'
                                                    }`}
                                                >
                                                    {estaLleno
                                                        ? 'CUPOS AGOTADOS'
                                                        : `${disponibles} PLAZAS LIBRES`}
                                                </div>

                                                <button
                                                    disabled={estaLleno}
                                                    className={`w-full rounded-2xl py-3 text-xs font-bold tracking-widest uppercase transition-all ${
                                                        estaLleno
                                                            ? 'cursor-not-allowed bg-gray-100 text-gray-400'
                                                            : 'bg-gray-900 text-white hover:bg-blue-600 hover:shadow-lg active:scale-95'
                                                    }`}
                                                >
                                                    {estaLleno
                                                        ? 'Sin plazas'
                                                        : 'Reservar ahora'}
                                                </button>

                                                {(is_admin || is_jefe) && (
                                                    <>
                                                        <button
                                                            onClick={() =>
                                                                router.get(
                                                                    route(
                                                                        'sesiones.edit',
                                                                        sesion.id,
                                                                    ),
                                                                )
                                                            }
                                                            className="mt-2 w-full rounded-2xl border-2 border-dashed border-gray-300 py-2 text-xs font-bold text-gray-500 uppercase transition-all hover:border-blue-500 hover:bg-blue-50 hover:text-blue-600"
                                                        >
                                                            Editar Sesión
                                                        </button>

                                                        <button
                                                            onClick={() => {
                                                                if (
                                                                    confirm(
                                                                        '¿Estás seguro de eliminar esta sesión?',
                                                                    )
                                                                ) {
                                                                    router.delete(
                                                                        route(
                                                                            'sesiones.destroy',
                                                                            sesion.id,
                                                                        ),
                                                                    );
                                                                }
                                                            }}
                                                            disabled={
                                                                sesion.reservas_count >
                                                                0
                                                            }
                                                            className={`mt-2 w-full rounded-2xl border-2 py-2 text-xs font-bold uppercase transition-all ${
                                                                sesion.reservas_count >
                                                                0
                                                                    ? 'cursor-not-allowed border-gray-200 bg-gray-50 text-gray-300'
                                                                    : 'border-transparent bg-red-50 text-red-600 hover:bg-red-600 hover:text-white'
                                                            }`}
                                                        >
                                                            {sesion.reservas_count >
                                                            0
                                                                ? 'No se puede borrar (con inscritos)'
                                                                : 'Eliminar Sesión'}
                                                        </button>
                                                    </>
                                                )}
                                            </div>
                                        );
                                    },
                                )
                            ) : (
                                <div className="rounded-3xl border-2 border-dashed border-gray-200 py-10 text-center">
                                    <p className="text-xs font-bold text-gray-300 uppercase">
                                        No hay clases
                                    </p>
                                </div>
                            )}
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
}
