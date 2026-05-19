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
}

export default function PricingSection({ tarifas }: Props) {
    return (
        <section className="pricing-section">
            <h2 className="section-title">Planes de Suscripción</h2>
            <div className="pricing-grid">
                {tarifas.map((plan) => (
                    <CartaPrecio key={plan.id} {...plan} />
                ))}
            </div>
        </section>
    );
}
