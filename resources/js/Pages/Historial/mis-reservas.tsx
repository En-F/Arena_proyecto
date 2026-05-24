import React from 'react';
import { Head, router, Link } from '@inertiajs/react';
import { Calendar, MapPin, Clock, Trash2, ChevronLeft } from 'lucide-react';

interface Reserva {
    id: number;
    estado: string;
    sesion: {
        fecha: string;
        actividad: { nombre: string };
        centro: { nombre: string };
        horario: { hora_inicio: string };
    };
}

interface Props {
    reservas: Reserva[];
    usuario: string;
}

export default function MisReservas({ reservas = [], usuario }: Props) {
    const handleCancelar = (id: number) => {
        if (confirm('¿Estás seguro de que deseas cancelar esta reserva?')) {
            router.delete(route('reservas.destroy', id));
        }
    };

    return (
        <div className="min-h-screen bg-gray-50 px-4 py-12">
            <Head title={`Reservas de ${usuario}`} />

            <div className="mx-auto max-w-3xl">
                <header className="mb-10">
                    <p className="text-xs font-black tracking-widest text-blue-500 uppercase">
                        Historial Personal
                    </p>
                    <h1 className="text-4xl font-black tracking-tight text-gray-900 uppercase">
                        Mis Clases <span className="text-blue-600">.</span>
                    </h1>
                    <p className="mt-2 text-sm font-medium text-gray-500">
                        Gestiona tus inscripciones para {usuario}
                    </p>
                </header>

                <div className="space-y-4">
                    {reservas.length > 0 ? (
                        reservas.map((reserva) => (
                            <div
                                key={reserva.id}
                                className="group flex flex-col items-center justify-between gap-6 rounded-3xl border border-gray-100 bg-white p-6 shadow-sm transition-all hover:shadow-md md:flex-row"
                            >
                                <div className="space-y-3 text-center md:text-left">
                                    <div className="inline-block rounded-lg bg-blue-50 px-3 py-1 text-[10px] font-black text-blue-600 uppercase">
                                        Confirmada
                                    </div>
                                    <h3 className="text-2xl leading-none font-black text-gray-800 uppercase">
                                        {reserva.sesion.actividad.nombre}
                                    </h3>

                                    <div className="flex flex-wrap justify-center gap-4 text-xs font-bold text-gray-400 uppercase md:justify-start">
                                        <div className="flex items-center gap-1.5">
                                            <Calendar
                                                size={14}
                                                className="text-blue-400"
                                            />
                                            {new Date(
                                                reserva.sesion.fecha.replace(
                                                    /-/g,
                                                    '/',
                                                ),
                                            ).toLocaleDateString('es-ES', {
                                                weekday: 'short',
                                                day: 'numeric',
                                                month: 'short',
                                            })}
                                        </div>
                                        <div className="flex items-center gap-1.5">
                                            <Clock
                                                size={14}
                                                className="text-blue-400"
                                            />
                                            {reserva.sesion.horario.hora_inicio.slice(
                                                0,
                                                5,
                                            )}
                                        </div>
                                        <div className="flex items-center gap-1.5">
                                            <MapPin
                                                size={14}
                                                className="text-blue-400"
                                            />
                                            {reserva.sesion.centro.nombre}
                                        </div>
                                    </div>
                                </div>

                                <button
                                    onClick={() => handleCancelar(reserva.id)}
                                    className="flex w-full items-center justify-center gap-2 rounded-2xl bg-red-50 px-6 py-4 text-xs font-black text-red-600 uppercase transition-all hover:bg-red-600 hover:text-white active:scale-95 md:w-auto"
                                >
                                    <Trash2 size={16} />
                                    Cancelar
                                </button>
                            </div>
                        ))
                    ) : (
                        <div className="rounded-3xl border-2 border-dashed border-gray-200 bg-white py-20 text-center">
                            <div className="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-50 text-gray-300">
                                <Calendar size={32} />
                            </div>
                            <p className="text-sm font-black tracking-widest text-gray-400 uppercase">
                                No tienes clases reservadas
                            </p>
                            <Link
                                href="/"
                                className="mt-6 inline-block text-xs font-black text-blue-600 uppercase underline decoration-2 underline-offset-4"
                            >
                                Ver clases disponibles
                            </Link>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}
