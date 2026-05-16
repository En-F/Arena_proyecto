import React from 'react';
import CartaInstalacion from './CartaInstalacion';

interface Instalacion {
    id: number;
    nombre: string;
    imagen: string;
}

interface Props {
    instalaciones: Instalacion[];
}

export default function InstallationsSection({ instalaciones }: Props) {
    return (
        <section className="installations-section">
            <h2 className="section-title">Instalaciones</h2>
            <div className="installations-grid">
                {instalaciones.map((instalacion) => (
                    <CartaInstalacion key={instalacion.id} {...instalacion} />
                ))}
            </div>
        </section>
    );
}
