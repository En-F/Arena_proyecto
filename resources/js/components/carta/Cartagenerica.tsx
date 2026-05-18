import { Link, router, usePage } from '@inertiajs/react';
import '../../../css/carta/carta_generica.css';
import Button from '../Layouts/Button';
import '../../../css/button.css';
import { useState, useEffect } from 'react';

interface Props {
    id?: number;
    nombre?: string;
    imagen?: string;
    esCrear?: boolean;
    tipo?: 'centro' | 'curso' | 'actividad';
    rutaDetalle?: string;
    rutaCrear?: string;
    rutaOcultar?: string;
    textoOcultar?: string;
    textoConfirmacion?: string;
    es_activo?: boolean;
}

export default function Cartagenerica({
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
    es_activo = true,
}: Props) {
    const { auth } = usePage().props;
    const [timestamp, setTimestamp] = useState<number>(0);

    useEffect(() => {
        setTimestamp(Date.now());
    }, [imagen]);

    const textoConfirmacionDefault =
        textoConfirmacion ||
        `¿Estás seguro de que quieres ${textoOcultar.toLowerCase()} este ${tipo}?`;

    const handleOcultarElemento = (e: React.MouseEvent) => {
        e.stopPropagation();
        e.preventDefault();

        const accion = es_activo ? 'ocultar' : 'mostrar';
        if (confirm(`¿Estás seguro de que quieres ${accion} este ${tipo}?`)) {
            router.post(rutaOcultar, { id: id }, { preserveScroll: true });
        }
    };

    if (esCrear) {
        return (
            <Link href={rutaCrear} className="enlace-corto">
                <div className="img-card-container carta-crear">
                    <span className="carta-crear-plus">+</span>
                </div>
            </Link>
        );
    }

    return (
        <div>
            <Link
                href={`${rutaDetalle}/${id}`}
                className="carta-item"
                style={{
                    position: 'relative',
                    opacity: es_activo ? 1 : 0.5,
                }}
            >
                <div className="img-card-container">
                    <img
                        src={`/storage/${imagen}?v=${timestamp}`}
                        alt={nombre}
                        suppressHydrationWarning={true}
                    />
                </div>
                <p className="centro-title">{nombre}</p>
            </Link>

            {(auth.user?.is_admin ||
                (auth.user?.is_jefe && tipo !== 'centro')) && (
                <div>
                    <Button
                        type="button"
                        onClick={handleOcultarElemento}
                        className={` ${es_activo ? 'btn mt-5 btn-soft btn-primary' : 'btn mt-5 btn-soft btn-info'}`}
                    >
                        {es_activo ? 'Ocultar' : 'Mostrar'}
                    </Button>
                </div>
            )}
        </div>
    );
}
