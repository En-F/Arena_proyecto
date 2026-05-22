import { Pencil } from 'lucide-react';
import React, { useState } from 'react';
import '../../../../../css/centro/show.css';
import { usePage } from '@inertiajs/react';
import Button from '@/components/Layouts/Button';

interface Props {
    id: number;
    tipo: string;
    precio: number;
    descripcion: string[];
    periodo: string;
}

export default function CartaPrecio({
    id,
    tipo,
    precio,
    descripcion,
    periodo,
    centro_id,
}: Props) {
    const tipoNormalizado = tipo.toLowerCase();
    const [isHovered, setIsHovered] = useState(false);
    const { auth } = usePage().props as any;
    const is_admin = auth.user?.is_admin || false;
    const is_jefe = auth.user?.is_jefe || false;

    return (
        <div
            className={`pricing-card card-${tipoNormalizado}`}
            onMouseEnter={() => setIsHovered(true)}
            onMouseLeave={() => setIsHovered(false)}
            style={isHovered ? { transform: 'translateY(-5px)' } : {}}
        >
            {(is_admin || is_jefe) && (
                <Button
                    className="pricing-edit-button"
                    href={route('tarifas.edit', id)}
                >
                    <Pencil size={16} />
                </Button>
            )}
            <div className="pricing-card-header">
                <h2>{tipo}</h2>
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

                <Button
                    className="pricing-button"
                    href={route('socio.create', {
                        centro_id: centro_id,
                        tarifa_id: id,
                    })}
                >
                    Suscribirse
                </Button>
            </div>
        </div>
    );
}
