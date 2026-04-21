import { Link } from '@inertiajs/react';
import '../../../css/carta/carta_actividad.css';

interface Props {
    id?: number;
    titulo?: string;
    imagen?: string;
    esCrear?: boolean;
}

export default function CartaActividad({
    id,
    titulo,
    imagen,
    esCrear = false,
}: Props) {
    if (esCrear) {
        return (
            <Link href="/actividades/create" className="centro-item">
                <div className="img-card-container carta-crear">
                    <span className="carta-crear-plus">+</span>
                </div>
            </Link>
        );
    }
    
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
