import { Eye, EyeOff } from 'lucide-react';
import { useState } from 'react';

interface Rol {
    id: number;
    rol: string;
}

interface Centro {
    id: number;
    nombre: string;
}

interface Usuario {
    id: number;
    name: string;
    email: number;
    dni: string;
    roles: Rol[];
    centros: Centro[];
}

interface Props {
    usuarios: Usuario[];
}

export default function Show({ usuarios }: Props) {
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
            <div className="mt-10 mr-10 ml-10 overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
                <table className="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>DNI</th>
                            <th>Contraseña</th>
                            <th>Rol</th>
                            <th>Centro al que pertenece</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
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