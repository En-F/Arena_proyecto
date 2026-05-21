import { useState } from 'react';
import { Head, router } from '@inertiajs/react';
import '../../../css/usuario/usuario.css';
import '../../../css/inicio.css';
import Button from '@/components/Layouts/Button';
import '../../../css/button.css';
import { Link } from '@inertiajs/react';
import { route } from 'ziggy-js';

interface Usuario {
    name: string;
}

interface Inscripcion {
    id: number;
    usuario: Usuario;
}

interface Tarifa {
    id: number;
    precio: string;
    tipo: string;
    centro: { id: number; nombre: string };
    inscripciones: Inscripcion[];
}

interface ErrorValidacion {
    campo: string;
    mensaje: string;
}

interface Props {
    tarifas: Tarifa[];
}

export default function Index({ tarifas }: Props) {
    const [resultado, setResultado] = useState<Tarifa[]>([]);
    const [busquedaRealizada, setBusquedaRealizada] = useState(false);
    const [filtroNombre, setFiltroNombre] = useState('');
    const [errores, setErrores] = useState<ErrorValidacion[]>([]);
    const [mensajeSistema, setMensajeSistema] = useState('');

    const handleEliminar = (id: number) => {
        if (confirm(`¿Estás seguro de que quieres eliminar esta tarifa?`)) {
            router.delete(route('tarifas.destroy', id), {
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
                `/tarifas/buscar?${parametros.toString()}`,
            );
            const dato_respuesta = await response.json();

            if (dato_respuesta.success) {
                setResultado(dato_respuesta.data || []);
                setBusquedaRealizada(true);
                setMensajeSistema(dato_respuesta.message);
                setErrores([]);
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
            setResultado([]);
        }
    };

    const limpiarFiltros = () => {
        setFiltroNombre('');
        setResultado([]);
        setBusquedaRealizada(false);
        setMensajeSistema('');
        setErrores([]);
    };

    let TarifasMostrar = busquedaRealizada ? resultado : tarifas;

    return (
        <>
            <Head title="Gestión de Tarifas" />
            <h2 className="title-black">Gestión de Tarifas y Usuarios</h2>

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

            {mensajeSistema && errores.length === 0 && (
                <div className="mr-10 mb-4 ml-10 alert alert-success text-white">
                    <span>{mensajeSistema}</span>
                </div>
            )}

            <div className="filtros">
                <Button
                    href={route('tarifas.create')}
                    className="crear-instalacion"
                >
                    Crear Tarifa
                </Button>
                |
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
                            <th>Tipo / Descripción</th>
                            <th className="text-center">Precio</th>
                            <th className="text-center">Alumnos Inscritos</th>
                            <th className="w-[20%] text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr className="bg-base-200/20">
                            <td></td>
                            <td colSpan={2}>
                                <input
                                    type="text"
                                    placeholder="Buscar por centro o tipo..."
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
                            <td></td>
                        </tr>

                        {TarifasMostrar.length === 0 ? (
                            <tr>
                                <td
                                    colSpan={6}
                                    className="py-10 text-center text-base-content/50 italic"
                                >
                                    No se han encontrado tarifas disponibles.
                                </td>
                            </tr>
                        ) : (
                            TarifasMostrar.map((tarifa, index) => (
                                <tr
                                    key={tarifa.id}
                                    className="transition-colors hover:bg-base-200/40"
                                >
                                    <th className="text-center font-normal opacity-50">
                                        {index + 1}
                                    </th>
                                    <td className="p-4 font-medium text-gray-800">
                                        <Link
                                            href={route(
                                                'centros.show',
                                                tarifa.centro.id,
                                            )}
                                        >
                                            {tarifa.centro.nombre}
                                        </Link>
                                    </td>
                                    <td>
                                        <span className="badge badge-ghost font-semibold uppercase">
                                            {tarifa.tipo}
                                        </span>
                                    </td>
                                    <td className="text-center font-bold text-success">
                                        {parseFloat(tarifa.precio).toFixed(2)}€
                                    </td>
                                    <td className="text-center">
                                        <div className="flex flex-col items-center gap-1">
                                            {tarifa.inscripciones.length > 0 ? (
                                                tarifa.inscripciones.map(
                                                    (ins, i) => (
                                                        <span
                                                            key={i}
                                                            className="text-s rounded-full bg-info/10 px-3 py-1 font-medium text-info"
                                                        >
                                                            {ins.usuario.name}
                                                        </span>
                                                    ),
                                                )
                                            ) : (
                                                <span className="text-xs opacity-40">
                                                    Sin usuarios
                                                </span>
                                            )}
                                        </div>
                                    </td>
                                    <td>
                                        <div className="flex justify-center gap-2">
                                            <Button
                                                href={route('tarifas.edit', {
                                                    tarifa: tarifa.id,
                                                    from: 'index',
                                                })}
                                                className="btn text-info btn-ghost btn-sm hover:bg-info/10"
                                            >
                                                Editar
                                            </Button>
                                            <Button
                                                onClick={() =>
                                                    handleEliminar(tarifa.id)
                                                }
                                                className="btn text-error btn-ghost btn-sm hover:bg-error/10"
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
