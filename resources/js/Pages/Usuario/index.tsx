import { Eye, EyeOff } from 'lucide-react';
import { useState } from 'react';
import '../../../css/usuario/usuario.css'


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
}

interface Props {
    usuarios: Usuario[];
    centros : Centro[];
    roles: Rol[];
}

export default function Show({ usuarios,centros,roles }: Props) {
    const [visibles, setVisibles] = useState<number[]>([]);

    const toggleVisibilidad = (id: number) => {
        if (visibles.includes(id)) {
            setVisibles(visibles.filter((itemId) => itemId !== id));
        } else {
            setVisibles([...visibles, id]);
        }
    };

    return (
        <>
            <h2 className="title-black">Gestión de Usuarios</h2>
            <div className="mt-10 mr-10 ml-10 overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
                <table className="table">
                    <thead>
                        <tr>
                            <th className='encabezado'></th>
                            <th className='encabezado'>Nombre</th>
                            <th className='encabezado'>Email</th>
                            <th className='encabezado'>DNI</th>
                            <th className='encabezado'>Contraseña</th>
                            <th className='encabezado'>Rol</th>
                            <th className='encabezado'>Centro</th>
                            <th className='encabezado'>Activo</th>
                            <th className='encabezado'>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <select className="select-personalizado">
                                    <option  selected value="">Todos los roles</option>
                                    {roles.map((rol) => (
                                        <option key={rol.id} value={rol.id}>
                                            {rol.rol}
                                        </option>
                                    ))}
                                </select>
                            </td>
                            <td>
                                <select className="select-personalizado">
                                    <option  selected value="">Todos los centros</option>
                                    {centros.map((centro) => (
                                        <option key={centro.id} value={centro.id}>
                                            {centro.nombre}
                                        </option>
                                    ))}
                                </select>
                            </td>
                            <td>
                                <select className="select-personalizado ">
                                    <option  selected value="">Todos</option>
                                    <option  value="true">Activo</option>
                                    <option value="false">Inactivo</option>
                                </select>
                            </td>
                        </tr>
                        
                        {usuarios.map((usuario, index) => {
                            const estaVisible = visibles.includes(usuario.id);

                            return (
                                <tr key={usuario.id} className="hover">
                                    <th>{index + 1}</th>
                                    <td>{usuario.name}</td>
                                    <td>{usuario.email}</td>
                                    <td>{usuario.dni}</td>
                                    <td>
                                        <div className="flex items-center gap-2">
                                            <input
                                                type={
                                                    estaVisible
                                                        ? 'text'
                                                        : 'password'
                                                }
                                                value={'password_ejemplo'}
                                                readOnly
                                                className="w-24 border-none bg-transparent focus:outline-none"
                                            />
                                            <button
                                                onClick={() =>
                                                    toggleVisibilidad(
                                                        usuario.id,
                                                    )
                                                }
                                                className="btn btn-ghost btn-xs"
                                            >
                                                {estaVisible ? (
                                                    <EyeOff size={16} />
                                                ) : (
                                                    <Eye size={16} />
                                                )}
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        {usuario.roles
                                            .map((rol) => rol.rol)
                                            .join(', ')}
                                    </td>
                                    <td>
                                        {usuario.centros
                                            .map((centro) => centro.nombre)
                                            .join(', ')}
                                    </td>
                                    <td>
                                        {usuario.activo ? (
                                            <span className="activo">Activo</span>
                                        ) : (
                                            <span className="inactivo">Inactivo</span>
                                        )}
                                    </td>
                                    <td className="flex justify-center gap-2">
                                        <button className="btn text-blue-500 btn-ghost btn-xs">
                                            Editar
                                        </button>
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