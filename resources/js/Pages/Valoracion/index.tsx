import { useState } from 'react';
import { Head, router, Link } from '@inertiajs/react';
import '../../../css/usuario/usuario.css';
import '../../../css/inicio.css';
import Button from '@/components/Layouts/Button';
import '../../../css/button.css';
import { route } from 'ziggy-js';

interface Usuario {
    name: string;
}

interface Valoracion {
    id: number;
    puntuacion: number;
    titulo: string;
    comentario: string;
    usuario: Usuario;
    centro: { id: number; nombre: string };
    created_at: string;
}

interface ErrorValidacion {
    campo: string;
    mensaje: string;
}

interface Props {
    valoraciones: Valoracion[];
}

export default function Index({ valoraciones }: Props) {
    const [resultado, setResultado] = useState<Valoracion[]>([]);
    const [busquedaRealizada, setBusquedaRealizada] = useState(false);
    const [filtroNombre, setFiltroNombre] = useState('');
    const [errores, setErrores] = useState<ErrorValidacion[]>([]);
    const [mensajeSistema, setMensajeSistema] = useState('');

    const handleEliminar = (id: number) => {
        if (confirm(`¿Estás seguro de que quieres eliminar esta valoración?`)) {
            router.delete(route('valoraciones.destroy', id), {
                preserveScroll: true,
            });
        }
    };

    const handleBuscar = async () => {
        if (!filtroNombre.trim()) {
            limpiarFiltros();
            return;
        }

        setErrores([]);

        try {
            const parametros = new URLSearchParams();
            parametros.append('centro', filtroNombre.trim());

            const response = await fetch(
                `/valoraciones/buscar?${parametros.toString()}`,
            );
            const dato_respuesta = await response.json();

            if (dato_respuesta.success) {
                console.log(dato_respuesta);
                setResultado(dato_respuesta.data || []);
                setBusquedaRealizada(true);
                setMensajeSistema(dato_respuesta.message);
            } else {
                setErrores([
                    { campo: 'general', mensaje: dato_respuesta.message },
                ]);
                setResultado([]);
            }
        } catch (error) {
            setErrores([
                {
                    campo: 'general',
                    mensaje: 'Error al conectar con el servidor',
                },
            ]);
        }
    };

    const limpiarFiltros = () => {
        setFiltroNombre('');
        setResultado([]);
        setBusquedaRealizada(false);
        setMensajeSistema('');
        setErrores([]);
    };

    let ValoracionesMostrar = busquedaRealizada ? resultado : valoraciones;

    return (
        <>
            <Head title="Gestión de Valoraciones" />
            <h2 className="title-black">Gestión de Valoraciones</h2>

            {errores.length > 0 && (
                <div className="mx-auto mb-4 alert max-w-[95%] items-start alert-error shadow-lg">
                    <div className="flex flex-col gap-1 text-white">
                        <h3 className="font-bold">Error en la búsqueda:</h3>
                        <ul className="list-inside list-disc text-sm">
                            {errores.map((error, index) => (
                                <li key={index}>{error.mensaje}</li>
                            ))}
                        </ul>
                    </div>
                </div>
            )}

            <div className="filtros">
                <Button onClick={limpiarFiltros} className="limpiar-filtro">
                    Limpiar filtro
                </Button>
            </div>

            <div className="m-10 overflow-x-auto rounded-xl border border-base-300 bg-base-100 shadow-sm">
                <table className="table w-full table-zebra">
                    <thead className="bg-base-200/50">
                        <tr>
                            <th className="w-16 text-center">#</th>
                            <th>Centro</th>
                            <th>Usuario</th>
                            <th>Comentario / Texto</th>
                            <th className="text-center">Puntuación</th>
                            <th className="w-[15%] text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr className="bg-base-200/20">
                            <td></td>
                            <td colSpan={3}>
                                <input
                                    type="text"
                                    placeholder="Buscar por nombre de centro..."
                                    className="input-bordered input input-sm w-full max-w-xs"
                                    value={filtroNombre}
                                    onChange={(e) =>
                                        setFiltroNombre(e.target.value)
                                    }
                                    onKeyDown={(e) =>
                                        e.key === 'Enter' && handleBuscar()
                                    }
                                />
                            </td>
                            <td></td>
                            <td></td>
                        </tr>

                        {ValoracionesMostrar.length === 0 ? (
                            <tr>
                                <td
                                    colSpan={6}
                                    className="py-10 text-center text-base-content/50 italic"
                                >
                                    No se han encontrado valoraciones.
                                </td>
                            </tr>
                        ) : (
                            ValoracionesMostrar.map((val, index) => (
                                <tr
                                    key={val.id}
                                    className="transition-colors hover:bg-base-200/40"
                                >
                                    <th className="text-center font-normal opacity-50">
                                        {index + 1}
                                    </th>
                                    <td className="p-4 font-medium text-gray-800">
                                        <Link
                                            href={route(
                                                'centros.show',
                                                val.centro.id,
                                            )}
                                        >
                                            {val.centro.nombre}
                                        </Link>
                                    </td>
                                    <td>
                                        <span className="font-semibold text-info">
                                            {val.usuario.name}
                                        </span>
                                    </td>
                                    <td className="max-w-xs overflow-hidden text-ellipsis">
                                        <div className="flex flex-col">
                                            <span className="text-xs font-bold uppercase opacity-60">
                                                {val.titulo}
                                            </span>
                                            <span className="line-clamp-2 text-sm">
                                                {val.comentario}
                                            </span>
                                        </div>
                                    </td>
                                    <td className="text-center">
                                        <div className="flex justify-center gap-0.5 text-warning">
                                            {Array.from({ length: 5 }).map(
                                                (_, i) => (
                                                    <span
                                                        key={i}
                                                        className={
                                                            i < val.puntuacion
                                                                ? 'opacity-100'
                                                                : 'opacity-20'
                                                        }
                                                    >
                                                        ★
                                                    </span>
                                                ),
                                            )}
                                        </div>
                                    </td>
                                    <td>
                                        <div className="flex justify-center">
                                            <Button
                                                onClick={() =>
                                                    handleEliminar(val.id)
                                                }
                                                className="btn text-error btn-ghost btn-sm hover:bg-red-50"
                                            >
                                                Borrar
                                            </Button>
                                        </div>
                                    </td>
                                </tr>
                            ))
                        )}
                    </tbody>
                </table>
            </div>
        </>
    );
}
