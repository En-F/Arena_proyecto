import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import '../../../css/noticia/show.css';
import '../../../css/centro/show.css';
import Button from '@/components/Layouts/Button';
import { route } from 'ziggy-js';

interface Noticia {
    id: number;
    titulo: string;
    contenido: string;
    imagen: string;
    es_activo: boolean;
    fecha: string;
}

interface Props {
    noticia: Noticia;
    centro: any;
}

export default function Show({ noticia, centro }: Props) {
    const { auth } = usePage().props;

    const handleOcultarElemento = (e: React.MouseEvent) => {
        e.stopPropagation();
        e.preventDefault();

        if (confirm(`¿Estás seguro de que quieres ocultar esta noticia?`)) {
            router.post(
                '/noticias/ocultar',
                { id: noticia.id },
                { preserveScroll: true },
            );
        }
    };

    const handleBorrarElemento = (id: number) => {
        if (confirm(`¿Estás seguro de que quieres eliminar esta noticia?`)) {
            router.delete(route('noticias.destroy', id), {
                preserveScroll: true,
            });
        }
    };

    return (
        <>
            <Head title={noticia.titulo} />

            <div className="main-container">
                <section className="section-centros">
                    <div className="hero-wrapper">
                        <img
                            className="imagen-noticia"
                            src={`/storage/${noticia.imagen}?v=${Date.now()}`}
                            alt={noticia.titulo}
                        />
                        <div className="hero-overlay" />
                        <span className="hero-badge">Noticia</span>
                    </div>

                    <div className="noticia-header">
                        <Link
                            href={`/centros/${centro.id}`}
                            className="link-centro"
                        >
                            <h3 className="title-black-centro">
                                {centro.nombre}
                            </h3>
                        </Link>

                        <h1 className="noticia-titulo">{noticia.titulo}</h1>
                        <h2 className="noticia-fecha">{noticia.fecha}</h2>
                    </div>

                    <p className="descripcion-wrapper">
                        {noticia.contenido || 'Sin descripción disponible...'}
                    </p>

                    {(auth.user?.is_admin || auth.user?.is_jefe) && (
                        <div className="botones-acciones">
                            <Button
                                onClick={handleOcultarElemento}
                                className={`btn btn-soft ${
                                    noticia.es_activo
                                        ? 'btn btn-soft btn-primary'
                                        : 'btn btn-soft btn-success'
                                }`}
                            >
                                {noticia.es_activo ? 'Ocultar' : 'Mostrar'}
                            </Button>

                            <Button
                                href={route('noticias.edit', noticia.id)}
                                className="btn btn-info"
                            >
                                Editar
                            </Button>

                            <Button
                                onClick={() => handleBorrarElemento(noticia.id)}
                                className="btn btn-error"
                            >
                                Eliminar
                            </Button>
                        </div>
                    )}

                    <Button href="/inicio" className="btn-volver">
                        Volver al inicio
                    </Button>
                </section>
            </div>
        </>
    );
}
