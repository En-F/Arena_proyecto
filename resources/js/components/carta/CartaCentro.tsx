import { Link } from '@inertiajs/react';
import '../../../css/carta/carta_centro.css';

interface Props {
    id?: number;
    nombre?: string;
    imagen?: string;
    esCrear?: boolean;
}

export default function CartaCentro({
    id,
    nombre,
    imagen,
    esCrear = false,
}: Props) {
    if (esCrear) {
        return (
            <Link href="/centros/create" className="centro-item">
                <div className="img-card-container carta-crear">
                    <span className="carta-crear-plus">+</span>
                </div>
            </Link>
        );
    }

    return (
        <Link href={`/centros/${id}`} className="centro-item">
            <div className="img-card-container">
                <img src={`/storage/${imagen}`} alt={nombre} />
            </div>
            <p className="centro-title">{nombre}</p>
        </Link>
    );
}
