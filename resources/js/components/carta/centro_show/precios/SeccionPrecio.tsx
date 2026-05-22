import React from 'react';
import CartaPrecio from './CartaPrecio';

interface Tarifa {
    id: number;
    titulo: string;
    precio: number;
    tipo: string;
    descripcion: string[];
    periodo: string;
}

interface Props {
    tarifas: Tarifa[];
    centro: { id: number; nombre: string };
}

export default function PricingSection({ tarifas,centro }: Props) {
    return (
        <section className="pricing-section">
            <h2 className="section-title">Planes de Suscripción</h2>
            <div className="pricing-grid">
                {tarifas.map((plan) => (
                    <CartaPrecio key={plan.id} {...plan} centro_id={centro.id} />
                ))}
            </div>
        </section>
    );
}
