import React, { useState } from 'react';

interface Props {
    id: number;
    tipo: string;
    titulo: string;
    precio: number;
    descripcion: string[];
    periodo: string;
}

export default function PricingCard({
    id,
    tipo,
    titulo,
    precio,
    descripcion,
    periodo,
}: Props) {
    const [isHovered, setIsHovered] = useState(false);

    const handleSubscribe = () => {
        alert(`¡Te has suscrito al plan ${titulo}!`);
    };

    return (
        <div
            className={`pricing-card ${tipo}`}
            onMouseEnter={() => setIsHovered(true)}
            onMouseLeave={() => setIsHovered(false)}
            style={isHovered ? { transform: 'translateY(-5px)' } : {}}
        >
            <div className="pricing-card-header">
                <h2>{titulo}</h2>
                <div className="precio">
                    <span className="precio-término">€</span>
                    {precio}
                </div>
                <span className="precio-periodo">/{periodo}</span>
            </div>

            <div className="pricing-card-body">
                <ul className="pricing-descripcion">
                    {descripcion.map((des, i) => (
                        <li key={i}>{des}</li>
                    ))}
                </ul>

                <button className="pricing-button" onClick={handleSubscribe}>
                    Suscribirse
                </button>
            </div>
        </div>
    );
}
