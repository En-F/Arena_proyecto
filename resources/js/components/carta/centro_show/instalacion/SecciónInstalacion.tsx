import React from 'react';
import CartaInstalacion from './CartaInstalacion';

export default function InstallationsSection() {
    const instalaciones_prueba = [
        {
            id: 1,
            name: 'Pista Olímpica',
            icon: '🏃',
        },
        {
            id: 2,
            name: 'Gimnasio',
            icon: '⚙️',
        },
        {
            id: 3,
            name: 'Entrenamiento Personal',
            icon: '👤',
        },
        {
            id: 4,
            name: 'Máquinas',
            icon: '🏋️',
        },
        {
            id: 7,
            name: 'Vestuarios',
            icon: '🚿',
        },
    ];

    return (
        <section className="installations-section">
            <h2 className="section-title">Instalaciones</h2>
            <div className="installations-grid">
                {instalaciones_prueba.map((instalacion) => (
                    <CartaInstalacion key={instalacion.id} {...instalacion} />
                ))}
            </div>
        </section>
    );
}
