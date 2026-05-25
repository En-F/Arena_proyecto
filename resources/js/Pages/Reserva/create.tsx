import { useForm } from '@inertiajs/react';

interface Tarifa {
    id: number,
    tipo: string
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
    sesion: Sesion
    tarifa : Tarifa
}

export default function Create({ sesion, tarifa } : Props) {
    const { post, processing } = useForm();

    const submit = (e) => {
        e.preventDefault();
        post(route('proceso.reserva.store', sesion.id));
    };

    return (
        <div className='pt-15'>
            <div className="p-6 max-w-md mx-auto bg-white rounded-xl shadow-md">
                <h2 className="text-xl font-bold mb-4">Confirmar Reserva</h2>

                <div className="space-y-2 mb-6">
                    <p><strong>Actividad:</strong> {sesion.actividad.nombre}</p>
                    <p><strong>Centro:</strong> {sesion.centro.nombre}</p>
                    <p><strong>Hora:</strong> {sesion.horario.hora_inicio}</p>
                    <p className="text-sm text-gray-500 italic">Reservando con tarifa: {tarifa.tipo}</p>
                </div>

                <button
                    onClick={submit}
                    disabled={processing}
                    className="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 disabled:opacity-50"
                >
                    {processing ? 'Confirmando...' : 'Confirmar y Reservar'}
                </button>
            </div>
        </div>
    );
}
