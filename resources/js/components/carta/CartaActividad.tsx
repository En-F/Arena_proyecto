// resources/js/Components/ActivityCard.jsx
import { Link } from '@inertiajs/react';
import '../../../css/carta/carta_actividad.css';

interface Props {
    id: number;
    titulo: string;
    imagen: string;
}

export default function CartaActividad({ id, titulo, imagen }: Props) {
    return (
        <Link key={id} href={`/actividades/${id}`} className="activity-card">
            <div className="activity-img-wrapper">
                <img
                    src={`/storage/${imagen}`}
                    alt={titulo}
                    className="activity-img"
                />
                <div className="activity-overlay">
                    <span className="activity-explore">Explorar</span>
                </div>
            </div>
            <p className="activity-title">{titulo}</p>
        </Link>
    );
}
