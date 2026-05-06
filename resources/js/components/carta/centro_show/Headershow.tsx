import Button from '@/components/Layouts/Button';
import { usePage } from '@inertiajs/react';
import React from 'react';

export default function datosHeader({ centros }: any) {
    const googleMapsUrl = `https://www.google.com/maps/dir/?api=1&destination=${centros.latitud},${centros.longitud}`;

    const { auth } = usePage().props as any;
    const is_admin = auth.user?.is_admin || false;
    const is_jefe = auth.user?.is_jefe || false;

    return (
        <>
            <div className="datos-header">
                <div className="datos-info">
                    <h1>{centros.nombre}</h1>
                    <p>{centros.descripcion}</p>

                    <div className="location-info">
                        <div className="location-icon">📍</div>
                        <div className="location-details">
                            <p className="location-address">
                                {centros.direccion}
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
                    <img src={`/storage/${centros.imagen}`} />
                </div>
                <div className="contact-item">
                    <span className="contact-icon">📧</span>
                    <div className="contact-details">
                        <p className="contact-label">Email</p>
                        <a
                            href={`mailto:${centros.email}`}
                            className="contact-link"
                        >
                            {centros.email}
                        </a>
                    </div>
                </div>
                <div className="contact-item">
                    <span className="contact-icon">📱</span>
                    <div className="contact-details">
                        <p className="contact-label">Teléfono</p>
                        {centros.telefono}
                    </div>
                </div>
                {/* <div className="contact-item">
                    {(is_admin || is_jefe) && (
                        <div>
                            <Button
                                className="btn mt-10 mb-4 btn-info"
                                href={route('actividades.create')}
                            >
                                Crear Actividad
                            </Button>
                        </div>
                    )}
                </div> */}
            </div>
        </>
    );
}
