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
    const usuario = auth.user;
    const is_admin = auth.user?.is_admin || false;
    const is_jefe = auth.user?.is_jefe || false;
    console.log(usuario);

    const manejarIntentoVoto = (e: React.MouseEvent) => {
        const permiso = is_admin || is_jefe;
        const pertenece = usuario?.centros?.some(
            (ce: any) => ce.id === centro.id,
        );

        if (!permiso && !pertenece) {
            e.preventDefault();
            alert(
                `Acceso restringido: Solo miembros del ${centro.nombre} pueden votar.`,
            );
        }
    };

    return (
        <section className="reviews-section">
            <h2 className="section-title">Reseñas</h2>
            <div className="reviews-grid">
                {valoraciones.map((valoracion) => (
                    <CartaValoracion key={valoracion.id} {...valoracion} />
                ))}
                {usuario && (
                    <div onClickCapture={manejarIntentoVoto}>
                        <CartaValoracion esCrear={true} centro_id={centro.id} />
                    </div>
                )}
            </div>
        </section>
    );
}
