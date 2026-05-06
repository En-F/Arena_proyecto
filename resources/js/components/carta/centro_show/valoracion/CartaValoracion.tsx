import { usePage } from '@inertiajs/react';
import { Link } from 'lucide-react';
import React from 'react';
import '../../../../../css/carta/carta_generica.css';

interface Props {
    id?: number;
    titulo?: string;
    puntuacion?: number;
    comentario?: string;
    esCrear?: boolean;
}

export default function ReviewCard({
    id,
    titulo,
    puntuacion,
    comentario,
    esCrear = false,
}: Props) {
    const { auth } = usePage().props;

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

    if (esCrear) {
        return (
            <Link href={route('valoraciones.create')} className="carta-item">
                <div className="img-card-container carta-crear">
                    <span className="carta-crear-plus">+</span>
                </div>
            </Link>
        );
    }

    return (
        <div className="carta-valoracion">
            {renderStars(puntuacion)}
            <h3>{titulo}</h3>
            <p>{comentario}</p>
        </div>
    );
}
