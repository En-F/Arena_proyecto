import { Pencil } from 'lucide-react';
import React, { useState } from 'react';
import '../../../../../css/centro/show.css';
import { usePage } from '@inertiajs/react';

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
    const { auth } = usePage().props as any;
    const is_admin = auth.user?.is_admin || false;
    const is_jefe = auth.user?.is_jefe || false;

    const handleEdit = (e: React.MouseEvent) => {
        e.stopPropagation();
        route('tarifas.edit', id);
    };

    return (
        <div
            className={`pricing-card ${tipo}`}
            onMouseEnter={() => setIsHovered(true)}
            onMouseLeave={() => setIsHovered(false)}
            style={isHovered ? { transform: 'translateY(-5px)' } : {}}
        >
            {(is_admin || is_jefe) && (
                <button className="pricing-edit-button" onClick={handleEdit}>
                    <Pencil size={16} />
                </button>
            )}
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

                <button
                    className="pricing-button"
                    // onClick={handleSubscribe}
                >
                    Suscribirse
                </button>
            </div>
        </div>
    );
}
