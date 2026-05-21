import Button from '@/components/Layouts/Button';
import React, { useState } from 'react';
import '../../../../../css/carta/sec_instalaciones.css';

interface Props {
    id: number;
    nombre: string;
    imagen: string;
}

export default function CartaInstalacion({ id, nombre, imagen }: Props) {
    const [isHovered, setIsHovered] = useState(false);

    return (
        <div
            className="carta-instalacion"
            onMouseEnter={() => setIsHovered(true)}
            onMouseLeave={() => setIsHovered(false)}
            style={isHovered ? { transform: 'translateY(-5px)' } : {}}
        >
            <div className="icono-instalacion">
                <img
                    src={`/storage/${imagen}`}
                    alt={nombre}
                    className="icono-img"
                />
            </div>
            <h3>{nombre}</h3>
        </div>
    );
}
