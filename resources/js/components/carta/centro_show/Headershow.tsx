import Button from '@/components/Layouts/Button';
import { usePage, Link, router } from '@inertiajs/react';
import React from 'react';
import '../../../../css/centro/show.css';

interface Centro {
    id: number;
    nombre: string;
}

interface Centro {
    id: number;
    nombre: string;
    descripcion: string;
    imagen: string;
    direccion: string;
    telefono: string;
    email: string;
    latitud: number;
    longitud: number;
}

interface Curso {
    id: number;
    nombre: string;
    descripcion: string;
    imagen: string;
    centros: Centro[];
}

interface Props {
    entidad: Centro | Curso;
    tipo?: 'centro' | 'curso';
}

export default function HeaderShow({ entidad, tipo = 'centro' }: Props) {
    const { auth } = usePage().props as any;
    const isCurso = tipo === 'curso';

    if (!entidad) {
        return (
            <div className="p-4 text-gray-500 italic">Cargando datos...</div>
        );
    }

    const is_admin = auth.user?.rol === 'admin' || auth.user?.is_admin;
    const is_jefe = auth.user?.rol === 'jefe' || auth.user?.is_jefe;
    const puede_gestionar = is_admin || is_jefe;

    const puede_eliminar_entidad = isCurso ? puede_gestionar : is_admin;

    const centroDatos = !isCurso ? (entidad as Centro) : null;

    const googleMapsUrl =
        centroDatos?.latitud && centroDatos?.longitud
            ? `https://www.google.com/maps/search/?api=1&query=${centroDatos.latitud},${centroDatos.longitud}`
            : '#';

    const handleEliminar = () => {
        if (confirm(`¿Estás seguro de que deseas eliminar este ${tipo}?`)) {
            const rutaDestroy = isCurso ? 'cursos.destroy' : 'centros.destroy';
            router.delete(route(rutaDestroy, entidad.id));
        }
    };

    return (
        <>
            <div className="datos-header">
                <div className="datos-info">
                    <div className="flex items-start justify-between gap-2">
                        <h1>{entidad.nombre}</h1>

                        <div className="mb-4 flex gap-2">
                            {puede_gestionar && (
                                <Link
                                    href={route(
                                        isCurso
                                            ? 'cursos.edit'
                                            : 'centros.edit',
                                        entidad.id,
                                    )}
                                >
                                    <Button className="rounded bg-blue-600 px-4 py-2 text-white shadow hover:bg-blue-700">
                                        Editar
                                    </Button>
                                </Link>
                            )}
                        </div>
                    </div>

                    <p>{entidad.descripcion}</p>
                    {isCurso && (entidad as Curso).centros?.length > 0 && (
                        <div className="mt-4 flex items-start gap-2 text-gray-700">
                            <span
                                className="text-lg"
                                role="img"
                                aria-label="centro"
                            >
                                🏫
                            </span>
                            <span className="text-sm font-semibold uppercase">
                                Centros:
                            </span>
                            <div className="flex flex-wrap gap-1">
                                {(entidad as Curso).centros.map(
                                    (centro, index) => (
                                        <span
                                            key={centro.id}
                                            className="font-medium text-blue-600"
                                        >
                                            {centro.nombre}
                                            {index <
                                            (entidad as Curso).centros.length -
                                                1
                                                ? ', '
                                                : ''}
                                        </span>
                                    ),
                                )}
                            </div>
                        </div>
                    )}

                    {centroDatos?.direccion && (
                        <div className="location-info">
                            <div className="location-icon">📍</div>
                            <div className="location-details">
                                <p className="location-address">
                                    {centroDatos.direccion}
                                </p>
                                {centroDatos.latitud &&
                                    centroDatos.longitud && (
                                        <a
                                            href={googleMapsUrl}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className="maps-link"
                                        >
                                            Ver en Google Maps →
                                        </a>
                                    )}
                            </div>
                        </div>
                    )}
                </div>

                <div className="datos-image-container">
                    <img
                        src={`/storage/${entidad.imagen}?v=${Date.now()}`}
                        alt={entidad.nombre}
                    />
                </div>

                {centroDatos && (
                    <div className="mt-4 flex gap-8">
                        {centroDatos.email && (
                            <div className="contact-item">
                                <span className="contact-icon">📧</span>
                                <div className="contact-details">
                                    <p className="contact-label">Email</p>
                                    <a
                                        href={`mailto:${centroDatos.email}`}
                                        className="contact-link"
                                    >
                                        {centroDatos.email}
                                    </a>
                                </div>
                            </div>
                        )}
                        {centroDatos.telefono && (
                            <div className="contact-item">
                                <span className="contact-icon">📱</span>
                                <div className="contact-details">
                                    <p className="contact-label">Teléfono</p>
                                    {centroDatos.telefono}
                                </div>
                            </div>
                        )}
                    </div>
                )}
            </div>
        </>
    );
}
