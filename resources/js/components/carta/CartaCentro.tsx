import { Link } from '@inertiajs/react';
import '../../../css/carta/carta_centro.css';

interface Props {
<<<<<<< HEAD
    id: number;
    nombre: string;
    imagen: string;
}

export default function CartaCentro({ id, nombre, imagen }: Props) {
    return (
        <Link key={id} href={`/centros/${id}`} className="centro-item">
=======
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
>>>>>>> fb55ae0 (Intregración de las cookies)
            <div className="img-card-container">
                <img src={`/storage/${imagen}`} alt={nombre} />
            </div>
            <p className="centro-title">{nombre}</p>
        </Link>
    );
}
