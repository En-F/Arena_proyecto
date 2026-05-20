import { router, usePage } from '@inertiajs/react';
import { Link } from '@inertiajs/react';
import React from 'react';
import '../../../../../css/carta/carta_generica.css';
import '../../../../../css/centro/show.css';
import { route } from 'ziggy-js';

interface Props {
    id?: number;
    titulo?: string;
    puntuacion?: number;
    comentario?: string;
    esCrear?: boolean;
    user_id?: { id: number; name: string };
    centro_id: number;
}

export default function CartaValoracion({
    id,
    titulo,
    puntuacion,
    comentario,
    esCrear = false,
    centro_id,
    user_id,
}: Props) {
    const { auth } = usePage().props;
    const is_admin = auth.user?.is_admin || false;
    const is_jefe = auth.user?.is_jefe || false;

    if (esCrear) {
        return (
            <Link
                href={route('valoraciones.create', { centro_id: centro_id })}
                className="carta-valoracion-create"
            >
                <span className="plus-icon">+</span>
            </Link>
        );
    }

    const renderStars = (puntuacion: number) => {
        return (
            <div className="review-estrellas">
                {[...Array(5)].map((v, i) => (
                    <span
                        key={i}
                        className={`Estrellas ${i < puntuacion ? '' : 'empty'}`}
                    >
                        ★
                    </span>
                ))}
            </div>
        );
    };

    return (
        <div className="carta-valoracion" style={{ position: 'relative' }}>
            {(is_admin || is_jefe) && (
                <button
                    onClick={() => {
                        if (
                            confirm(
                                '¿Estás seguro de que quieres borrar esta valoración?',
                            )
                        ) {
                            router.delete(route('valoraciones.destroy', id), {
                                preserveScroll: true,
                            });
                        }
                    }}
                    className="btn-eliminar-valoracion"
                    title="Eliminar comentario"
                >
                    &times;
                </button>
            )}

            <div className="review-estrellas">{renderStars(puntuacion)}</div>
            <h3>{titulo}</h3>
            <p>{comentario}</p>
        </div>
    );
}
