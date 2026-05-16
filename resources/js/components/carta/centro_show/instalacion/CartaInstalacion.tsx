import Button from '@/components/Layouts/Button';
import React, { useState } from 'react';

interface Props {
    id: number;
    nombre: string;
    imagen: string;
}

export default function CartaInstalacion({ id, nombre, imagen }: Props) {
    const [isHovered, setIsHovered] = useState(false);

    return (
        <div
            className="carta-instalación"
            onMouseEnter={() => setIsHovered(true)}
            onMouseLeave={() => setIsHovered(false)}
            style={isHovered ? { transform: 'translateY(-5px)' } : {}}
        >
            <div className="icono-instalacion">
                <img
                    src={`/storage/${imagen}`}
                    alt={nombre}
                    style={{
                        width: '40px',
                        height: '40px',
                        display: 'block',
                        margin: '0 auto 10px',
                    }}
                />
            </div>
            <h3>{nombre}</h3>
        </div>
    );
}
