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
    periodo: string;
    descuento: number;
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

    const multiplicadores = {
        mes: 1,
        trimestre: 3,
        semestre: 6,
        año: 12,
    };

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
                            <th>Centro / Nivel</th>
                            <th>Plan y Descuento</th>
                            <th className="text-center">Precio Base</th>
                            <th className="text-center">Total Periodo</th>
                            <th className="text-center">Alumnos</th>
                            <th className="w-[15%] text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr className="bg-base-200/20">
                            <td></td>
                            <td colSpan={2}>
                                <input
                                    type="text"
                                    placeholder="Buscar por centro..."
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
                            <td></td>
                        </tr>

                        {TarifasMostrar.length === 0 ? (
                            <tr>
                                <td
                                    colSpan={7}
                                    className="py-10 text-center text-base-content/50 italic"
                                >
                                    No se han encontrado tarifas.
                                </td>
                            </tr>
                        ) : (
                            TarifasMostrar.map((tarifa, index) => {
                                const precioMensual = parseFloat(tarifa.precio);
                                const cantidadMeses =
                                    multiplicadores[tarifa.periodo] || 1;
                                const totalSinDescuento =
                                    precioMensual * cantidadMeses;

                                const dineroDescontado =
                                    totalSinDescuento *
                                    (tarifa.descuento / 100);

                                const precioFinal =
                                    totalSinDescuento - dineroDescontado;

                                return (
                                    <tr
                                        key={tarifa.id}
                                        className="transition-colors hover:bg-base-200/40"
                                    >
                                        <th className="text-center font-normal opacity-50">
                                            {index + 1}
                                        </th>
                                        <td className="p-4">
                                            <div className="font-bold text-gray-800">
                                                <Link
                                                    href={route(
                                                        'centros.show',
                                                        tarifa.centro.id,
                                                    )}
                                                >
                                                    {tarifa.centro.nombre}
                                                </Link>
                                            </div>
                                            <div className="text-xs text-gray-500 uppercase">
                                                {tarifa.tipo}
                                            </div>
                                        </td>
                                        <td>
                                            <div className="flex flex-col">
                                                <span className="badge badge-outline badge-sm capitalize badge-info">
                                                    {tarifa.periodo}
                                                </span>
                                                {tarifa.descuento > 0 && (
                                                    <span className="text-xs font-bold text-green-600">
                                                        -
                                                        {Math.round(
                                                            tarifa.descuento,
                                                        )}
                                                        % ahorro
                                                    </span>
                                                )}
                                            </div>
                                        </td>
                                        <td className="text-center font-medium">
                                            {precioMensual.toFixed(2)}€/mes
                                        </td>
                                        <td className="text-center">
                                            <div className="font-bold text-success">
                                                {precioFinal.toFixed(2)}€
                                            </div>
                                            {tarifa.periodo !== 'mes' && (
                                                <div className="text-[10px] text-gray-400 line-through">
                                                    {(
                                                        precioMensual *
                                                        cantidadMeses
                                                    ).toFixed(2)}
                                                    €
                                                </div>
                                            )}
                                        </td>
                                        <td className="text-center">
                                            <div className="flex flex-col items-center gap-1">
                                                {tarifa.inscripciones.length >
                                                0 ? (
                                                    tarifa.inscripciones.map(
                                                        (ins, i) => (
                                                            <span
                                                                key={i}
                                                                className="text-s rounded-full bg-info/10 px-3 py-1 font-medium text-info"
                                                            >
                                                                {
                                                                    ins.usuario
                                                                        .name
                                                                }
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
                                                    href={route(
                                                        'tarifas.edit',
                                                        {
                                                            tarifa: tarifa.id,
                                                            from: 'index',
                                                        },
                                                    )}
                                                    className="btn text-info btn-ghost btn-sm"
                                                >
                                                    Editar
                                                </Button>
                                                <Button
                                                    onClick={() =>
                                                        handleEliminar(
                                                            tarifa.id,
                                                        )
                                                    }
                                                    className="btn text-error btn-ghost btn-sm"
                                                >
                                                    Borrar
                                                </Button>
                                            </div>
                                        </td>
                                    </tr>
                                );
                            })
                        )}
                    </tbody>
                </table>
            </div>
        </>
    );
}
