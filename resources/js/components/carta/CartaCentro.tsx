import { Link } from '@inertiajs/react';
import '../../../css/carta/carta_centro.css';

interface Props {
    id: number;
    nombre: string;
    imagen: string;
}

export default function CartaCentro({ id, nombre, imagen }: Props) {
    return (
        <Link key={id} href={`/centros/${id}`} className="centro-item">
            <div className="img-card-container">
                <img src={`/storage/${imagen}`} alt={nombre} />
            </div>
            <p className="centro-title">{nombre}</p>
        </Link>
    );
}
