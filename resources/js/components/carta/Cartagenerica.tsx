import { Link, router, usePage } from '@inertiajs/react';
import '../../../css/carta/carta_generica.css';
import Button from '../Layouts/Button';
import '../../../css/button.css';

interface Props {
    id?: number;
    nombre?: string;
    imagen?: string;
    esCrear?: boolean;
    tipo?: 'centro' | 'curso';
    rutaDetalle?: string;
    rutaCrear?: string;
    rutaOcultar?: string;
    textoOcultar?: string;
    textoConfirmacion?: string;
    mostrarBotones?: boolean;
}

export default function Carta({
    id,
    nombre,
    imagen,
    esCrear = false,
    tipo = 'centro',
    rutaDetalle = '/centros',
    rutaCrear = '/centros/create',
    rutaOcultar = '/centros/ocultar',
    textoOcultar = 'Ocultar',
    textoConfirmacion,
    mostrarBotones = true,
}: Props) {
    const { auth } = usePage().props;

    const textoConfirmacionDefault =
        textoConfirmacion ||
        `¿Estás seguro de que quieres ${textoOcultar.toLowerCase()} este ${tipo}?`;

    const handleOcultarElemento = (e: React.MouseEvent) => {
        e.stopPropagation();
        e.preventDefault();

        if (confirm(textoConfirmacionDefault)) {
            router.post(
                rutaOcultar,
                { id: id },
                {
                    preserveScroll: true,
                },
            );
        }
    };

    if (esCrear) {
        return (
            <Link href={rutaCrear} className="carta-item">
                <div className="img-card-container carta-crear">
                    <span className="carta-crear-plus">+</span>
                </div>
            </Link>
        );
    }

    return (
        <div style={{ position: 'relative' }}>
            <Link href={`${rutaDetalle}/${id}`} className="carta-item">
                <div className="img-card-container">
                    <img src={`/storage/${imagen}`} alt={nombre} />
                </div>
                <p className="centro-title">{nombre}</p>
            </Link>

            {(auth.user?.is_admin ||
                (auth.user?.is_jefe && tipo !== 'centro')) && (
                <Button
                    type="button"
                    onClick={handleOcultarElemento}
                    className="btn-crud ocultar"
                >
                    {textoOcultar}
                </Button>
            )}
        </div>
    );
}
