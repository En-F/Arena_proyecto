import React, { useState } from 'react';
import { usePage, Link } from '@inertiajs/react';

export default function ScheduleWeekly() {
    const { auth } = usePage().props as any;
    const is_admin = auth.user?.is_admin || false;
    const is_jefe = auth.user?.is_jefe || false;

    const [currentWeekOffset, setCurrentWeekOffset] = useState(0);
    const [selectedCenter, setSelectedCenter] = useState('centro-sur');
    const [selectedCourse, setSelectedCourse] = useState('principiante');

    const activities = [
        {
            id: 1,
            name: 'FULL BODY',
            time: '07:15 - 08:15',
            instructor: 'Carlos Mendez',
            capacity: 25,
            registered: 22,
            day: 'lunes',
        },
        {
            id: 2,
            name: 'BICICLETA',
            time: '07:15 - 09:15',
            instructor: 'María López',
            capacity: 30,
            registered: 28,
            day: 'martes',
        },
        {
            id: 3,
            name: 'PILATES',
            time: '09:00 - 10:00',
            instructor: 'Ana Torres',
            capacity: 20,
            registered: 17,
            day: 'martes',
        },
        {
            id: 4,
            name: 'PISCINA',
            time: '07:15 - 08:15',
            instructor: 'Juan García',
            capacity: 20,
            registered: 18,
            day: 'miércoles',
        },
        {
            id: 5,
            name: 'GIMANSIO',
            time: '07:15 - 09:15',
            instructor: 'Roberto Silva',
            capacity: 40,
            registered: 35,
            day: 'miércoles',
        },
        {
            id: 6,
            name: 'DANZA',
            time: '18:00 - 19:00',
            instructor: 'Sofía Blanco',
            capacity: 25,
            registered: 23,
            day: 'miércoles',
        },
        {
            id: 7,
            name: 'MOVILIDAD ARTICULAR',
            time: '07:15 - 09:00',
            instructor: 'Rosa Martínez',
            capacity: 15,
            registered: 15,
            day: 'jueves',
        },
        {
            id: 8,
            name: 'FÚTBOL',
            time: '10:15 - 11:15',
            instructor: 'Diego Ruiz',
            capacity: 22,
            registered: 20,
            day: 'jueves',
        },
        {
            id: 9,
            name: 'FULL BODY',
            time: '07:15 - 08:15',
            instructor: 'Carlos Mendez',
            capacity: 25,
            registered: 24,
            day: 'viernes',
        },
        {
            id: 10,
            name: 'BALONCESTO',
            time: '07:15 - 08:15',
            instructor: 'Miguel Fernández',
            capacity: 20,
            registered: 16,
            day: 'viernes',
        },
        {
            id: 11,
            name: 'YOGA',
            time: '08:30 - 09:30',
            instructor: 'Laura Sánchez',
            capacity: 18,
            registered: 12,
            day: 'lunes',
        },
        {
            id: 12,
            name: 'PISCINA',
            time: '07:15 - 08:15',
            instructor: 'Juan García',
            capacity: 20,
            registered: 19,
            day: 'lunes',
        },
    ];

    const days = [
        { key: 'lunes', name: 'Lunes', date: '20 Nov' },
        { key: 'martes', name: 'Martes', date: '21 Nov' },
        { key: 'miércoles', name: 'Miércoles', date: '22 Nov' },
        { key: 'jueves', name: 'Jueves', date: '23 Nov' },
        { key: 'viernes', name: 'Viernes', date: '24 Nov' },
    ];

    const previousWeek = () => setCurrentWeekOffset((prev) => prev - 1);
    const nextWeek = () => setCurrentWeekOffset((prev) => prev + 1);

    const getWeekLabel = () => {
        const startDate = new Date(2024, 10, 20 + currentWeekOffset * 7);
        const weekStart = startDate.getDate();
        const monthName = startDate
            .toLocaleString('es-ES', { month: 'short' })
            .replace('.', '');
        return `Semana ${weekStart} - ${weekStart + 4} ${monthName.charAt(0).toUpperCase() + monthName.slice(1)}`;
    };

    const getDayActivities = (dayKey) => {
        return activities.filter((a) => a.day === dayKey);
    };

    const handleReserve = (activityId) => {
        console.log(
            `Reservado: Actividad ${activityId}, Centro: ${selectedCenter}, Curso: ${selectedCourse}`,
        );
    };

    return (
        <div className="min-h-screen bg-white p-8">
            <div className="mx-auto max-w-7xl">
                <div className="mb-8 text-center">
                    <h1
                        className="mb-2 text-5xl font-bold text-black"
                        style={{ fontFamily: 'Georgia, serif' }}
                    >
                        Horario
                    </h1>
                    <p className="text-lg text-gray-600">
                        Visualiza todas las actividades de la semana y reserva
                        tu lugar
                    </p>
                </div>

                <div className="mb-8 flex flex-wrap items-end justify-center gap-6">
                    <div className="flex flex-col gap-2">
                        <label className="text-xs font-semibold tracking-wider text-gray-500 uppercase">
                            Centro
                        </label>
                        <select
                            value={selectedCenter}
                            onChange={(e) => setSelectedCenter(e.target.value)}
                            className="w-56 cursor-pointer rounded-lg border-2 border-gray-300 bg-white px-4 py-3 text-base font-medium text-gray-900 transition-all hover:border-gray-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none"
                        >
                            <option value="centro-sur">
                                Centro Sur - Plaza Mayor
                            </option>
                            <option value="centro-norte">
                                Centro Norte - Avenida Principal
                            </option>
                            <option value="centro-este">
                                Centro Este - Zona Industrial
                            </option>
                            <option value="centro-oeste">
                                Centro Oeste - Centro Histórico
                            </option>
                        </select>
                    </div>

                    <div className="flex flex-col gap-2">
                        <label className="text-xs font-semibold tracking-wider text-gray-500 uppercase">
                            Curso
                        </label>
                        <select
                            value={selectedCourse}
                            onChange={(e) => setSelectedCourse(e.target.value)}
                            className="w-56 cursor-pointer rounded-lg border-2 border-gray-300 bg-white px-4 py-3 text-base font-medium text-gray-900 transition-all hover:border-gray-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none"
                        >
                            <option value="principiante">
                                Nivel Principiante
                            </option>
                            <option value="intermedio">Nivel Intermedio</option>
                            <option value="avanzado">Nivel Avanzado</option>
                        </select>
                    </div>

                    {(is_admin || is_jefe) && (
                        <Link
                            href={route('horarios.create')}
                            className="inline-flex h-[52px] items-center justify-center rounded-lg bg-green-600 px-5 text-base font-bold text-white shadow-sm transition-all hover:bg-green-700 active:scale-95"
                        >
                            + Crear Actividad
                        </Link>
                    )}
                </div>

                <div className="mb-8 flex items-center justify-center gap-8">
                    <button
                        onClick={previousWeek}
                        className="cursor-pointer p-2 text-2xl text-gray-500 transition-colors hover:text-gray-900"
                    >
                        ❮
                    </button>
                    <div className="w-56 text-center text-lg font-semibold text-gray-900">
                        {getWeekLabel()}
                    </div>
                    <button
                        onClick={nextWeek}
                        className="cursor-pointer p-2 text-2xl text-gray-500 transition-colors hover:text-gray-900"
                    >
                        ❯
                    </button>
                </div>

                <div className="grid grid-cols-5 gap-6 gap-y-8">
                    {days.map((day, index) => {
                        const startDate = new Date(
                            2024,
                            10,
                            20 + currentWeekOffset * 7,
                        );
                        const currentDate = startDate.getDate() + index;
                        const monthName = startDate
                            .toLocaleString('es-ES', { month: 'short' })
                            .replace('.', '');
                        const dayActivities = getDayActivities(day.key);

                        return (
                            <div
                                key={day.key}
                                className="rounded-xl border-2 border-gray-300 bg-gray-50 p-6"
                            >
                                <div className="mb-4 border-b-2 border-gray-300 pb-4 text-center">
                                    <div className="text-lg font-bold text-gray-900">
                                        {day.name}
                                    </div>
                                    <div className="mt-1 text-sm text-gray-600">
                                        {currentDate} {monthName}
                                    </div>
                                </div>

                                <div className="space-y-4">
                                    {dayActivities.length > 0 ? (
                                        dayActivities.map((activity) => {
                                            const spotsLeft =
                                                activity.capacity -
                                                activity.registered;
                                            const isFull = spotsLeft === 0;

                                            return (
                                                <div
                                                    key={activity.id}
                                                    className="group relative overflow-hidden rounded-lg border-2 border-gray-300 bg-white p-4 transition-all duration-300 hover:border-gray-400 hover:shadow-md"
                                                >
                                                    <div className="absolute top-0 right-0 left-0 h-1 bg-gradient-to-r from-blue-500 to-purple-500" />

                                                    <div className="pt-2">
                                                        <div className="mb-2 font-bold text-gray-900">
                                                            {activity.name}
                                                        </div>

                                                        <div className="mb-1 flex items-center gap-2 text-sm text-gray-600">
                                                            <span>🕐</span>
                                                            <span>
                                                                {activity.time}
                                                            </span>
                                                        </div>

                                                        <div className="mb-1 flex items-center gap-2 text-sm text-gray-600">
                                                            <span>👤</span>
                                                            <span>
                                                                {
                                                                    activity.instructor
                                                                }
                                                            </span>
                                                        </div>

                                                        <div className="mb-3 flex items-center gap-2 text-sm text-gray-600">
                                                            <span>👥</span>
                                                            <span>
                                                                {
                                                                    activity.registered
                                                                }
                                                                /
                                                                {
                                                                    activity.capacity
                                                                }
                                                            </span>
                                                        </div>

                                                        <div className="mb-3">
                                                            <span
                                                                className={`inline-block rounded-md px-3 py-1 text-xs font-bold ${
                                                                    isFull
                                                                        ? 'bg-red-100 text-red-900'
                                                                        : 'bg-green-100 text-green-900'
                                                                }`}
                                                            >
                                                                {isFull
                                                                    ? 'LLENO'
                                                                    : `${spotsLeft} disponibles`}
                                                            </span>
                                                        </div>

                                                        <button
                                                            onClick={() =>
                                                                handleReserve(
                                                                    activity.id,
                                                                )
                                                            }
                                                            disabled={isFull}
                                                            className={`w-full rounded-lg py-2 text-sm font-bold transition-all duration-200 ${
                                                                isFull
                                                                    ? 'cursor-not-allowed bg-gray-300 text-gray-600'
                                                                    : 'bg-blue-600 text-white hover:bg-blue-700 active:scale-95'
                                                            }`}
                                                        >
                                                            {isFull
                                                                ? 'Sin disponibilidad'
                                                                : 'Reservar'}
                                                        </button>
                                                    </div>
                                                </div>
                                            );
                                        })
                                    ) : (
                                        <div className="py-8 text-center text-gray-500">
                                            Sin actividades
                                        </div>
                                    )}
                                </div>
                            </div>
                        );
                    })}
                </div>
            </div>
        </div>
    );
}
