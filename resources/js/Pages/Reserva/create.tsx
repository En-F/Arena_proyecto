import { useForm } from '@inertiajs/react';

interface Tarifa {
    id: number;
    tipo: string;
}

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

interface Props {
    sesion: Sesion;
    tarifa: Tarifa;
    reservas_actuales: number;
    limite_reservas: number;
}

export default function Create({
    sesion,
    tarifa,
    reservas_actuales,
    limite_reservas,
}: Props) {
    const { post, processing } = useForm();

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('proceso.reserva.store', sesion.id));
    };

    const cuposAgotados = reservas_actuales >= limite_reservas;

    return (
        <div className="pt-15">
            <div className="mx-auto max-w-md rounded-xl bg-white p-6 shadow-md">
                <h2 className="mb-4 text-xl font-bold">Confirmar Reserva</h2>

                <div className="mb-6 space-y-2">
                    <p>
                        <strong>Actividad:</strong> {sesion.actividad.nombre}
                    </p>
                    <p>
                        <strong>Centro:</strong> {sesion.centro.nombre}
                    </p>
                    <p>
                        <strong>Hora:</strong> {sesion.horario.hora_inicio}
                    </p>
                    <p className="text-sm text-gray-500 italic">
                        Reservando con tarifa: {tarifa.tipo}
                    </p>

                    <div className="mt-4 border-t pt-4">
                        <p className="text-sm text-gray-700">
                            Llevas <strong>{reservas_actuales}</strong> de{' '}
                            <strong>{limite_reservas}</strong> reservas esta
                            semana.
                        </p>

                        {cuposAgotados && (
                            <div className="mt-2 rounded-lg bg-red-100 p-3 text-sm text-red-700">
                                <strong>Cupos insuficientes.</strong> Has
                                alcanzado tu límite semanal.
                            </div>
                        )}
                    </div>
                </div>

                <button
                    onClick={submit}
                    disabled={processing || cuposAgotados}
                    className={`w-full rounded-lg py-2 text-white transition-colors ${
                        cuposAgotados
                            ? 'cursor-not-allowed bg-gray-400'
                            : 'bg-blue-600 hover:bg-blue-700 disabled:opacity-50'
                    }`}
                >
                    {cuposAgotados
                        ? 'Sin cupos disponibles'
                        : processing
                          ? 'Confirmando...'
                          : 'Confirmar y Reservar'}
                </button>
            </div>
        </div>
    );
}
