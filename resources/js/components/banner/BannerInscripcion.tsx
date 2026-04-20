import '../../../css/carta/banner_inscripcion.css';
import { Link } from '@inertiajs/react';
import Button from '../Layouts/Button';

interface Props {
    imagen: string;
    titulo: string;
    descripcion: string;
    textBoton: string;
    href: string;
}

export default function BannerInscripcion({
    imagen,
    titulo,
    descripcion,
    textBoton,
    href,
}: Props) {
    return (
        <>
            <div className="banner-content">
                <div className="banner-image">
                    <img src={`/storage/otros/${imagen}`} alt="titulo" />
                </div>
                <div className="banner-text-box">
                    <h3>{titulo}</h3>
                    <p>{descripcion}</p>
<<<<<<< HEAD
                    <Button href="/pendiente" className="btn-inscripcion">
=======
                    <Button href={href} className="btn-inscripcion">
>>>>>>> fb55ae0 (Intregración de las cookies)
                        {textBoton}
                    </Button>
                </div>
            </div>
        </>
    );
}
