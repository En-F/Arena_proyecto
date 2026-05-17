import { useEffect, useState } from 'react';
import '../../../css/usuario/usuario.css';
import { Input } from '@/components/ui/input';
import '../../../css/inicio.css';
import Button from '@/components/Layouts/Button';
import { router, usePage } from '@inertiajs/react';

interface Centro {
    id: number;
    nombre: string;
}

interface Rol {
    id: number;
    rol: string;
}

interface Usuario {
    id: number;
    name: string;
    email: string;
    dni: string;
    activo: boolean;
    roles: Rol[];
    centros: Centro[];
    telefono: string;
}

interface ErrorValidacion {
    campo: string;
    mensaje: string;
}

interface Props {
    usuarios: Usuario[];
    centros: Centro[];
    roles: Rol[];
}

export default function Index({ usuarios, centros, roles }: Props) {
    const { auth } = usePage().props;
    const is_admin = auth.user?.is_admin || false;
    const is_jefe = auth.user?.is_jefe || false;

    const [editandoActivoId, setEditandoActivoId] = useState(null);
    const [editandoUsuarioId, setEditandoUsuarioId] = useState(null);
    const [resultado, setResultado] = useState([]);
    const [filtroNombre, setFiltroNombre] = useState('');
    const [filtroEmail, setFiltroEmail] = useState('');
    const [filtroDni, setFiltroDni] = useState('');
    const [filtroCentro, setFiltroCentro] = useState('0');
    const [filtroActivo, setFiltroActivo] = useState('');
    const [errores, setErrores] = useState<ErrorValidacion[]>([]);
    const [mensajeSistema, setMensajeSistema] = useState('');

    const handleRolCambiado = async (usuarioId, nuevoRol) => {
        try {
            const respuesta = await fetch(`/usuarios/${usuarioId}/rol`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ nuevoRol: nuevoRol }),
            });
            if (respuesta.ok) {
                //Viaja al controlador en segundo plano y los usuarios
                router.reload({ only: ['usuarios'] });
            }
        } catch (error) {
            console.error('Error de red:', error);
        }
        setEditandoUsuarioId(null);
    };

    const handleActivoCambiado = async (
        usuarioId: number,
        nuevoEstado: boolean,
    ) => {
        try {
            const respuesta = await fetch(`/usuarios/${usuarioId}/activo`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ activo: nuevoEstado }),
            });

            if (respuesta.ok) {
                router.reload({ only: ['usuarios'] });
            } else {
                const datosError = await respuesta.json();
            }
        } catch (error) {
            console.error('Error de red:', error);
        }
        setEditandoActivoId(null);
    };

    const validarFiltros = (
        nombre: string,
        email: string,
        dni: string,
        centroId: string,
        activo: string,
    ): ErrorValidacion[] => {
        const erroresValidacion: ErrorValidacion[] = [];

        if (nombre && nombre.length > 50) {
            erroresValidacion.push({
                campo: 'nombre',
                mensaje: 'El nombre no puede exceder 50 caracteres',
            });
        }

        if (email && email.length > 50) {
            erroresValidacion.push({
                campo: 'email',
                mensaje: 'El email no puede exceder 50 caracteres',
            });
        }

        if (dni && dni.length > 20) {
            erroresValidacion.push({
                campo: 'dni',
                mensaje: 'El DNI no puede exceder 20 caracteres',
            });
        }

        return erroresValidacion;
    };

    useEffect(() => {
        const buscarAsincrono = async () => {
            const erroresValidacion = validarFiltros(
                filtroNombre,
                filtroEmail,
                filtroDni,
                filtroCentro,
                filtroActivo,
            );

            if (erroresValidacion.length > 0) {
                setErrores(erroresValidacion);
                setResultado([]);
                setMensajeSistema('');
                return;
            }

            if (
                !filtroNombre &&
                !filtroEmail &&
                !filtroDni &&
                filtroCentro === '0' &&
                filtroActivo === ''
            ) {
                setErrores([]);
                setResultado([]);
                setMensajeSistema('');
                return;
            }

            setErrores([]);

            //URL
            try {
                const parametros = new URLSearchParams();
                //String
                if (filtroNombre.trim())
                    parametros.append('nombre', filtroNombre.trim());
                if (filtroEmail.trim())
                    parametros.append('email', filtroEmail.trim());
                if (filtroDni.trim())
                    parametros.append('dni', filtroDni.trim());

                //Select
                if (filtroCentro !== '0')
                    parametros.append('centro_id', filtroCentro);
                if (filtroActivo !== '')
                    parametros.append('activo', filtroActivo);

                const response = await fetch(
                    `/usuarios/buscar?${parametros.toString()}`,
                );

                if (!response.ok) {
                    if (response.status === 403) {
                        setErrores([
                            {
                                campo: 'general',
                                mensaje:
                                    'No tienes permisos para buscar usuarios',
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
                    setResultado(
                        Array.isArray(dato_respuesta.usuarios)
                            ? dato_respuesta.usuarios
                            : [],
                    );
                    setMensajeSistema(dato_respuesta.message);
                    setErrores([]);
                } else {
                    setErrores([
                        { campo: 'general', mensaje: dato_respuesta.message },
                    ]);
                    setResultado([]);
                }
            } catch (error) {
                console.error('Error en la búsqueda:', error);
                setErrores([
                    {
                        campo: 'general',
                        mensaje: 'Error al conectar con el servidor',
                    },
                ]);
                setResultado([]);
            }
        };
        buscarAsincrono();
    }, [filtroNombre, filtroEmail, filtroDni, filtroCentro, filtroActivo]);

    let UsuariosMostrar = resultado.length > 0 ? resultado : usuarios;

    const limpiarFiltros = () => {
        setFiltroNombre('');
        setFiltroEmail('');
        setFiltroDni('');
        setFiltroCentro('0');
        setFiltroActivo('');
        setErrores([]);
        setMensajeSistema('');
        setResultado([]);
    };

    return (
        <>
            <h2 className="title-black">Gestión de Usuarios</h2>

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
                <button onClick={limpiarFiltros} className="limpiar-filtro">
                    Limpiar filtro
                </button>
            </div>
            <div className="mr-10 mb-10 ml-10 overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
                <table className="table">
                    <thead>
                        <tr>
                            <th className="encabezado"></th>
                            <th className="encabezado">Nombre</th>
                            <th className="encabezado">Email</th>
                            <th className="encabezado">DNI</th>
                            <th className="encabezado">Telefono</th>
                            <th className="encabezado">Rol</th>
                            <th className="encabezado">Centro</th>
                            <th className="encabezado">Activo</th>
                            <th className="encabezado">Tipo de Suscripción</th>
                            <th className="encabezado">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td>
                                <Input
                                    id="nombre"
                                    type="text"
                                    placeholder="Nombre"
                                    value={filtroNombre}
                                    onChange={(e) =>
                                        setFiltroNombre(e.target.value)
                                    }
                                ></Input>
                            </td>
                            <td>
                                <Input
                                    id="email"
                                    type="email"
                                    placeholder="correo electronico"
                                    value={filtroEmail}
                                    onChange={(e) =>
                                        setFiltroEmail(e.target.value)
                                    }
                                ></Input>
                            </td>
                            <td>
                                <Input
                                    id="dni"
                                    type="text"
                                    placeholder="DNI"
                                    value={filtroDni}
                                    onChange={(e) =>
                                        setFiltroDni(e.target.value)
                                    }
                                ></Input>
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <select
                                    className="select-personalizado"
                                    value={filtroCentro}
                                    onChange={(e) =>
                                        setFiltroCentro(e.target.value)
                                    }
                                >
                                    <option value="0">Todos los centros</option>
                                    {centros.map((centro) => (
                                        <option
                                            key={centro.id}
                                            value={centro.id}
                                        >
                                            {centro.nombre}
                                        </option>
                                    ))}
                                </select>
                            </td>
                            <td>
                                <select
                                    className="select-personalizado"
                                    value={filtroActivo}
                                    onChange={(e) =>
                                        setFiltroActivo(e.target.value)
                                    }
                                >
                                    <option value="">Todos</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </td>
                        </tr>

                        {UsuariosMostrar.map((usuario, index) => {
                            const rolDeLaFila = usuario.roles
                                .map((r) => r.rol)
                                .join(', ');

                            const estaBloqueado =
                                usuario.id === auth.user?.id ||
                                (rolDeLaFila.includes('admin') && is_admin) ||
                                (rolDeLaFila.includes('registrado') &&
                                    is_admin) ||
                                (rolDeLaFila.includes('registrado') &&
                                    is_jefe) ||
                                (rolDeLaFila.includes('admin') && is_admin) ||
                                (rolDeLaFila.includes('jefe') && is_jefe);

                            const estaBloqueadoActivo =
                                usuario.id === auth.user?.id ||
                                (!usuario.activo &&
                                    rolDeLaFila.includes('registrado'));
                            <tr>
                                <td
                                    colSpan={9}
                                    className="py-10 text-center text-gray-500"
                                >
                                    No se han encontrado usuarios con el nombre
                                    "{filtroNombre}"
                                </td>
                            </tr>;

                            return (
                                <tr key={usuario.id} className="hover">
                                    <th>{index + 1}</th>
                                    <td>{usuario.name}</td>
                                    <td>{usuario.email}</td>
                                    <td>{usuario.dni}</td>
                                    <td>{usuario.telefono}</td>
                                    <td
                                        onClick={() => {
                                            if (estaBloqueado) return;

                                            setEditandoUsuarioId(usuario.id);
                                        }}
                                        style={{
                                            cursor: estaBloqueado
                                                ? 'not-allowed'
                                                : 'pointer',
                                        }}
                                        title={
                                            is_admin || is_jefe
                                                ? 'No se pueden editar Admins o Jefes o Registrados'
                                                : 'Haz clic para editar'
                                        }
                                    >
                                        {editandoUsuarioId === usuario.id ? (
                                            <select
                                                value={
                                                    usuario.roles.map(
                                                        (rol) => rol.rol,
                                                    )[0]
                                                }
                                                onChange={(e) =>
                                                    handleRolCambiado(
                                                        usuario.id,
                                                        e.target.value,
                                                    )
                                                }
                                                onBlur={() =>
                                                    setEditandoUsuarioId(null)
                                                }
                                                autoFocus
                                                className="select"
                                            >
                                                {roles
                                                    .slice(0, -1)
                                                    .map((rol) => (
                                                        <option
                                                            key={rol.id}
                                                            value={rol.rol}
                                                        >
                                                            {rol.rol}
                                                        </option>
                                                    ))}
                                            </select>
                                        ) : (
                                            usuario.roles
                                                .map((rol) => rol.rol)
                                                .join(', ')
                                        )}
                                    </td>
                                    <td>
                                        {usuario.centros
                                            .map((centro) => centro.nombre)
                                            .join(', ')}
                                    </td>
                                    <td
                                        onClick={() => {
                                            if (estaBloqueadoActivo) return;

                                            setEditandoActivoId(usuario.id);
                                        }}
                                        style={{
                                            cursor: estaBloqueadoActivo
                                                ? 'not-allowed'
                                                : 'pointer',
                                        }}
                                    >
                                        {editandoActivoId === usuario.id ? (
                                            <select
                                                value={
                                                    usuario.activo ? '1' : '0'
                                                }
                                                onChange={(e) =>
                                                    handleActivoCambiado(
                                                        usuario.id,
                                                        e.target.value === '1',
                                                    )
                                                }
                                                onBlur={() =>
                                                    setEditandoActivoId(null)
                                                }
                                                autoFocus
                                                className="select"
                                            >
                                                <option value="1">
                                                    Activo
                                                </option>
                                                <option value="0">
                                                    Inactivo
                                                </option>
                                            </select>
                                        ) : usuario.activo ? (
                                            <span className="activo">
                                                Activo
                                            </span>
                                        ) : (
                                            <span className="inactivo">
                                                Inactivo
                                            </span>
                                        )}
                                    </td>
                                    <td></td>
                                    <td className="flex justify-center gap-2">
                                        <Button
                                            href={route(
                                                'usuarios.edit',
                                                usuario.id,
                                            )}
                                            className="btn text-blue-500 btn-ghost btn-xs"
                                        >
                                            Editar
                                        </Button>
                                    </td>
                                </tr>
                            );
                        })}
                    </tbody>
                </table>
            </div>
        </>
    );
}
