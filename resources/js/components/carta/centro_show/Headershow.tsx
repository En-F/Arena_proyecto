import Button from '@/components/Layouts/Button';
import { usePage, Link, router } from '@inertiajs/react'; // Importamos Link y router
import React from 'react';

interface Centro {
    id: number;
    nombre: string;
    descripcion: string;
    direccion: string;
    telefono: string;
    imagen: string;
    email: string;
    latitud: number;
    longitud: number;
}

interface Props {
    centro: Centro;
}

export default function datosHeader({ centro }: Props) {
    const { auth } = usePage().props as any;

    // Ajusta estas validaciones según cómo manejes los roles en tu UserResource
    const is_admin = auth.user?.rol === 'admin' || auth.user?.is_admin;
    const is_jefe = auth.user?.rol === 'jefe' || auth.user?.is_jefe;
    const puede_gestionar = is_admin || is_jefe;

    const googleMapsUrl =
        centro.latitud && centro.longitud
            ? `https://www.google.com/maps?q=${centro.latitud},${centro.longitud}`
            : '#';

    const handleEliminar = () => {
        if (confirm('¿Estás seguro de que deseas eliminar este centro?')) {
            router.delete(route('centros.destroy', centro.id));
        }
    };

    return (
        <>
            <div className="datos-header">
                <div className="datos-info">
                    <div className="flex items-start justify-between">
                        <h1>{centro.nombre}</h1>

                        {/* Botones de gestión */}
                        {puede_gestionar && (
                            <div className="mb-4 flex gap-2">
                                <Link href={route('centros.edit', centro.id)}>
                                    <Button className="rounded bg-blue-600 px-4 py-2 text-white shadow hover:bg-blue-700">
                                        Editar
                                    </Button>
                                </Link>
                            </div>
                        )}
                    </div>

                    <p>{centro.descripcion}</p>

                    <div className="location-info">
                        <div className="location-icon">📍</div>
                        <div className="location-details">
                            <p className="location-address">
                                {centro.direccion}
                            </p>
                            <a
                                href={googleMapsUrl}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="maps-link"
                            >
                                Ver en Google Maps →
                            </a>
                        </div>
                    </div>
                </div>

                <div className="datos-image-container">
                    <img
                        src={`/storage/${centro.imagen}`}
                        alt={centro.nombre}
                    />
                </div>

                <div className="mt-4 flex gap-8">
                    <div className="contact-item">
                        <span className="contact-icon">📧</span>
                        <div className="contact-details">
                            <p className="contact-label">Email</p>
                            <a
                                href={`mailto:${centro.email}`}
                                className="contact-link"
                            >
                                {centro.email}
                            </a>
                        </div>
                    </div>
                    <div className="contact-item">
                        <span className="contact-icon">📱</span>
                        <div className="contact-details">
                            <p className="contact-label">Teléfono</p>
                            {centro.telefono}
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
