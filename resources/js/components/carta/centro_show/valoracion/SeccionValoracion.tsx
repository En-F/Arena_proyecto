import React from 'react';
import CartaValoracion from './CartaValoracion';
import { usePage } from '@inertiajs/react';

interface Valoracion {
    id?: number;
    titulo?: string;
    puntuacion?: number;
    comentario?: string;
}

interface Props {
    valoraciones: Valoracion[];
    centro: { id: number; nombre: string };
}

export default function SeccionValoracion({ valoraciones, centro }: Props) {
    const { auth } = usePage().props as any;
    const is_admin = auth.user?.is_admin || false;
    const is_jefe = auth.user?.is_jefe || false;

    return (
        <section className="reviews-section">
            <h2 className="section-title">Reseñas</h2>
            <div className="reviews-grid">
                {valoraciones.map((valoracion) => (
                    <CartaValoracion key={valoracion.id} {...valoracion} />
                ))}
                {(is_admin || is_jefe) && (
                    <CartaValoracion esCrear centro_id={centro.id} />
                )}
            </div>
        </section>
    );
}
