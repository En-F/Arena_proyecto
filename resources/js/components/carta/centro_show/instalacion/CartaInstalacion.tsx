import React, { useState } from 'react';

interface Props {
    id: number;
    name: string;
    icon: string;
}

export default function CartaInstalacion({ id, name, icon }: Props) {
    const [isHovered, setIsHovered] = useState(false);

    return (
        <div
            className="carta-instalación"
            onMouseEnter={() => setIsHovered(true)}
            onMouseLeave={() => setIsHovered(false)}
            style={isHovered ? { transform: 'translateY(-5px)' } : {}}
        >
            <div className="icono-instalacion">{icon}</div>
            <h3>{name}</h3>
        </div>
    );
}
