import { useState } from 'react';
import '../../../css/usuario/usuario.css';
import '../../../css/inicio.css';
import Button from '@/components/Layouts/Button';
import '../../../css/button.css';
import { Head } from '@inertiajs/react';

interface CentroConEstado {
    id: number;
    nombre: string;
    estado: string;
    activo: boolean;
}
interface Instalacion {
    id: number;
    nombre: string;
    imagen: string;
    es_activo: boolean;
    centros: CentroConEstado[];
}

interface ErrorValidacion {
    campo: string;
    mensaje: string;
}

interface Props {
    instalaciones: Instalacion[];
}

export default function Show({ instalaciones }: Props) {
    const [resultado, setResultado] = useState([]);
    const [filtroNombre, setFiltroNombre] = useState('');
    const [errores, setErrores] = useState<ErrorValidacion[]>([]);
    const [mensajeSistema, setMensajeSistema] = useState('');
    const [busquedaRealizada, setBusquedaRealizada] = useState(false);

    const handleEliminar = (id: number) => {
        if (
            confirm(`¿Estás seguro de que quieres eliminar esta instalacion ?`)
        ) {
            router.delete(route('instalaciones.destroy', id), {
                preserveScroll: true,
            });
        }
    };

    const validarFiltros = (nombre: string): ErrorValidacion[] => {
        const erroresValidacion: ErrorValidacion[] = [];

        if (nombre && nombre.length > 70) {
            erroresValidacion.push({
                campo: 'nombre',
                mensaje: 'El nombre no puede exceder 50 caracteres',
            });
        }

        return erroresValidacion;
    };

    const handleBuscar = async () => {
        const erroresValidacion = validarFiltros(filtroNombre);

        if (erroresValidacion.length > 0) {
            setErrores(erroresValidacion);
            setResultado([]);
            setMensajeSistema('');
            return;
        }

        if (!filtroNombre.trim()) {
            return;
        }

        setErrores([]);

        try {
            const parametros = new URLSearchParams();
            parametros.append('nombre', filtroNombre.trim());

            const response = await fetch(
                `/instalaciones/buscar?${parametros.toString()}`,
            );

            if (!response.ok) {
                if (response.status === 403) {
                    setErrores([
                        {
                            campo: 'general',
                            mensaje:
                                'No tienes permisos para buscar instalaciones',
                        },
                    ]);
                } else {
                    throw new Error(`Error: ${response.status}`);
                }
                setResultado([]);
                return;
            }

            const dato_respuesta = await response.json();

            if (dato_respuesta.success) {
                setMensajeSistema(dato_respuesta.message);
                setResultado(dato_respuesta.data || []);
                setErrores([]);
                setBusquedaRealizada(true);
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

    let InstalacionesMostrar = busquedaRealizada ? resultado : instalaciones;

    const limpiarFiltros = () => {
        setFiltroNombre('');
        setBusquedaRealizada(false);
        setErrores([]);
        setMensajeSistema('');
        setResultado([]);
    };

    return (
        <>
            <Head title="Gestión de Instalaciones" />
            <h2 className="title-black">Gestión de Instalaciones</h2>

            {errores.length > 0 && (
                <div className="mx-auto mb-4 alert max-w-[95%] items-start alert-error shadow-lg">
                    <div className="flex flex-col gap-1">
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
                <div className="mr-10 mb-4 ml-10 alert alert-success">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        className="h-6 w-6 shrink-0 stroke-current"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            strokeWidth="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                    <span>{mensajeSistema}</span>
                </div>
            )}

            <div className="filtros">
                <Button
                    href={route('instalaciones.create')}
                    className="crear-instalacion"
                >
                    Crear Instalacion
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
                            <th>Nombre</th>
                            <th className="text-center">Imagen</th>
                            <th className="text-center">
                                Centros y Disponibilidad
                            </th>
                            <th className="w-[20%] text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr className="bg-base-200/20">
                            <td></td>
                            <td>
                                <input
                                    type="text"
                                    placeholder="Filtrar por nombre..."
                                    className="input-bordered input input-sm w-full max-w-xs"
                                    value={filtroNombre}
                                    onChange={(e) =>
                                        setFiltroNombre(e.target.value)
                                    }
                                    onKeyDown={(e) => {
                                        if (e.key === 'Enter') {
                                            handleBuscar();
                                        }
                                    }}
                                />
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        {InstalacionesMostrar.length === 0 ? (
                            <tr>
                                <td
                                    colSpan={4}
                                    className="py-10 text-center text-base-content/50 italic"
                                >
                                    No se han encontrado instalaciones con el
                                    nombre "{filtroNombre}"
                                </td>
                            </tr>
                        ) : (
                            InstalacionesMostrar.map((instalacion, index) => (
                                <tr
                                    key={instalacion.id}
                                    className="transition-colors hover:bg-base-200/40"
                                >
                                    <th className="text-center font-normal opacity-50">
                                        {index + 1}
                                    </th>

                                    <td className="font-medium text-base-content">
                                        {instalacion.nombre}
                                    </td>

                                    <td className="flex justify-center">
                                        <div className="avatar">
                                            <div className="mask h-12 w-12 bg-base-200 mask-squircle p-2">
                                                <img
                                                    src={`/storage/${instalacion.imagen}?v=${Date.now()}`}
                                                    alt={instalacion.nombre}
                                                    className="object-contain"
                                                />
                                            </div>
                                        </div>
                                    </td>
                                    <td className="text-center">
                                        <div className="mx-auto flex max-w-xs flex-col gap-1.5">
                                            {instalacion.centros.map(
                                                (centro) => (
                                                    <div
                                                        key={centro.id}
                                                        className="flex items-center justify-between border-b border-base-200 pb-1 text-sm last:border-0"
                                                    >
                                                        <span className="font-medium">
                                                            {centro.nombre}
                                                        </span>
                                                        {centro.activo ? (
                                                            <span className="rounded-full bg-success/20 px-2 py-0.5 text-xs font-semibold text-success">
                                                                {centro.estado}
                                                            </span>
                                                        ) : (
                                                            <span className="rounded-full bg-error/20 px-2 py-0.5 text-xs font-semibold text-error">
                                                                {centro.estado}
                                                            </span>
                                                        )}
                                                    </div>
                                                ),
                                            )}
                                        </div>
                                    </td>
                                    <td>
                                        <div className="flex justify-center gap-2">
                                            <Button
                                                href={route(
                                                    'instalaciones.edit',
                                                    instalacion.id,
                                                )}
                                                className="btn text-info btn-ghost btn-sm hover:bg-info/10"
                                            >
                                                Editar
                                            </Button>
                                            <Button
                                                onClick={() =>
                                                    handleEliminar(
                                                        instalacion.id,
                                                    )
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
