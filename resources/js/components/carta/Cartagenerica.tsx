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

    let resaltado = false;

    if (tipo === 'centro') {
        resaltado = auth.user?.centros?.some((c) => c.id === id);
    } else if (tipo === 'curso') {
        resaltado = auth.user?.centros?.some((centro) =>
            centro.cursos?.some((curso) => curso.id === id),
        );
    }
    const textoEtiqueta = tipo === 'centro' ? 'MI CENTRO' : 'ACCESO INCLUIDO';

    const fondos = [
        'bg-green-600',
        'bg-blue-600',
        'bg-purple-600',
        'bg-orange-600',
    ];

    const CentroPertenezo = auth.user?.centros?.find((centro) => {
        if (tipo === 'centro') return centro.id === id;
        if (tipo === 'curso') return centro.cursos?.some((c) => c.id === id);
        return false;
    });

    const colorFondo = CentroPertenezo
        ? fondos[CentroPertenezo.id % fondos.length]
        : 'bg-gray-500';

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
        <div className="relative">
            <Link
                href={`${rutaDetalle}/${id}`}
                className={'carta-item'}
                style={{
                    position: 'relative',
                    opacity: es_activo ? 1 : 0.5,
                    borderRadius: '12px',
                    display: 'block',
                }}
            >
                {resaltado && (
                    <span
                        className={`absolute top-2 right-2 z-10 rounded-full px-2 py-1 text-[10px] font-bold text-white shadow-md ${colorFondo}`}
                    >
                        {textoEtiqueta}
                    </span>
                )}

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
                <div className="flex w-full justify-center">
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
